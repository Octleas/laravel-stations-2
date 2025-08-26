<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Schedule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PracticeController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        //$request->input('keyword')というコードは、「送られてきたリクエストデータの中から、nameがkeywordである値を取り出してください」という意味
        $is_showing = $request->input('is_showing');

        $query = Movie::query();

        if (!empty($keyword)) {
            //where('絞り込むカラム名', '比較の方法', '比較する値')
            $query->where('title', 'LIKE', '%' . $keyword . '%')->orWhere('description', 'LIKE', '%' . $keyword . '%');   
        }   

        //0を有効なデータとして扱いたい場合、その存在チェックにempty()は使わない。
        if ($is_showing !== null && $is_showing !== '') {
            //比較の方法が '=' の場合、省略可
            $query->where('is_showing', $is_showing);
        }

        $movies = $query->paginate(20);

        return view('movies', compact('movies'));
    }

    public function detail($id)
    {
        $movie = Movie::find($id);
        //$movie->schedules で取得できるデータは、Laravelのコレクションという便利なオブジェクト
        //コレクションのメソッドでsortBy()というものがあり、データを照準に並び替えられる。
        $schedules = $movie->schedules->sortBy('start_time');

        return view('detail', compact('movie', 'schedules'));
    }


    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:movies,title',
            'image_url' => 'required|active_url',
            'published_year' => 'required|integer',
            'genre' => 'required',
            'description' => 'required',
            'is_showing' => 'required|boolean',
        ]);

        DB::transaction(function () use ($validatedData) {
            $genre = Genre::firstOrCreate(
                ['name' => $validatedData['genre']]
            );

            $movie = new Movie();
            $movie->title = $validatedData['title'];
            $movie->image_url = $validatedData['image_url'];
            $movie->published_year = $validatedData['published_year'];
            $movie->description = $validatedData['description'];
            $movie->is_showing = $validatedData['is_showing'];
            $movie->genre_id = $genre->id;
            $movie->save(); // ここでDB例外が起きると、自動でロールバックされ、例外がスローされる
        });

        return redirect()->route('admin.movies')->with('success', '映画が作成されました。');
    }

    public function edit($id)
    {
        $movie = Movie::find($id);
        return view('edit', ['movie' => $movie]);
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|unique:movies,title',
            'image_url' => 'required|active_url',
            'published_year' => 'required|integer',
            'genre' => 'required',
            'description' => 'required',
            'is_showing' => 'required|boolean',
        ]);

        DB::transaction(function () use ($validatedData, $movie) {
            $genre = Genre::firstOrCreate(
                ['name' => $validatedData['genre']]
            );

            $movie->title = $validatedData['title'];
            $movie->image_url = $validatedData['image_url'];
            $movie->published_year = $validatedData['published_year'];
            $movie->description = $validatedData['description'];
            $movie->is_showing = $validatedData['is_showing'];
            $movie->genre_id = $genre->id;
            $movie->save(); 
        });

        return redirect()->route('admin.movies')->with('success', '映画情報を更新しました。');
    }
    
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        try {
            // 関連するスケジュールを削除
            $movie->schedules()->delete();

            $title = $movie->title;
            $movie->delete();
    
            return redirect()
                ->route('admin.movies')
                ->with('success', "映画を削除しました → {$title}");
    
        } catch (\Throwable $e) {
            \Log::error("映画の削除中にエラーが発生しました: " . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', '映画の削除中に予期せぬエラーが発生しました。');
        }
    }
    
    public function sheets()
    {
        $rows = DB::table('sheets')->select('row')->distinct()->orderBy('row', 'asc')->pluck('row');
        return view('sheets', compact('rows'));
    }

    public function admin()
    {
        $movies = Movie::with('genre')->get(); 
        return view('admin', ['movies' => $movies]);
    }

    public function adminMovieDetail($id)
    {
        $movie = Movie::find($id);
        if (!$movie) {
            abort(404);
        }
        $schedules = $movie->schedules->sortBy('start_time');
        return view('adminMovieDetail', compact('movie', 'schedules'));
    }

    public function schedules()
    {
        $movies = Movie::with(['schedules' => function ($query) {
            $query->orderBy('start_time'); // スケジュールを開始時刻でソート
        }])->get();
        return view('schedules', compact('movies'));
    }

    public function scheduleDetail($id)
    {
        $movie = Movie::find($id);
        $schedules = $movie->schedules->sortBy('start_time');
        return view('scheduleDetail', compact('movie', 'schedules'));
    }

    public function scheduleCreate($id)
    {
        $movie = Movie::find($id);
        return view('scheduleCreate', compact('movie'));
    }

    public function scheduleStore(Request $request, $id)
    {
        // 基本的なバリデーション（日付比較は除く）
        $validatedData = $request->validate([
            'movie_id' => 'required|integer|exists:movies,id',
            'start_time_date' => 'required|date|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        // 開始日時と終了日時を結合して Carbon インスタンスを作成
        $startDateTime = Carbon::parse($validatedData['start_time_date'] . ' ' . $validatedData['start_time_time']);
        $endDateTime = Carbon::parse($validatedData['end_time_date'] . ' ' . $validatedData['end_time_time']);

        // カスタムバリデーション
        $errors = [];

        // 1. 開始日付が終了日付より後の場合
        if ($validatedData['start_time_date'] > $validatedData['end_time_date']) {
            $errors['start_time_date'] = ['開始日付は終了日付以前である必要があります。'];
            $errors['end_time_date'] = ['終了日付は開始日付以降である必要があります。'];
        }

        // 2. 同じ日付で開始時刻が終了時刻より後の場合、または同一の場合
        if ($validatedData['start_time_date'] === $validatedData['end_time_date']) {
            if ($validatedData['start_time_time'] >= $validatedData['end_time_time']) {
                $errors['start_time_time'] = ['開始時刻は終了時刻より前である必要があります。'];
                $errors['end_time_time'] = ['終了時刻は開始時刻より後である必要があります。'];
            }
        }

        // 3. 開始日時と終了日時の差を計算（5分超チェック）
        $differenceInMinutes = $startDateTime->diffInMinutes($endDateTime, false);
        if ($differenceInMinutes <= 5) {
            $errors['start_time_time'] = ['開始時刻と終了時刻の差は5分超である必要があります。'];
            $errors['end_time_time'] = ['終了日時は開始日時より5分超後である必要があります。'];
        }

        // エラーがある場合はリダイレクト
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        // スケジュールを保存
        $schedule = new Schedule();
        $schedule->start_time = $startDateTime;
        $schedule->end_time = $endDateTime;
        $schedule->movie_id = $validatedData['movie_id'];
        $schedule->save();

        return redirect()->route('admin.schedules.detail', $id)->with('success', 'スケジュールを作成しました。');
    }

    public function scheduleEdit($id)
    {
        $schedule = Schedule::findOrFail($id);

        // start_time と end_time を分割
        $start_time_date = $schedule->start_time->format('Y-m-d'); // 日付部分
        $start_time_time = $schedule->start_time->format('H:i');   // 時刻部分
        $end_time_date = $schedule->end_time->format('Y-m-d');     // 日付部分
        $end_time_time = $schedule->end_time->format('H:i');       // 時刻部分

        return view('scheduleEdit', compact('schedule', 'start_time_date', 'start_time_time', 'end_time_date', 'end_time_time'));
    }

    public function scheduleUpdate(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        // 基本的なバリデーション（日付比較は除く）
        $validatedData = $request->validate([
            'movie_id' => 'sometimes|integer|exists:movies,id',
            'start_time_date' => 'required|date|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        // 開始日時と終了日時を結合して Carbon インスタンスを作成
        $startDateTime = Carbon::parse($validatedData['start_time_date'] . ' ' . $validatedData['start_time_time']);
        $endDateTime = Carbon::parse($validatedData['end_time_date'] . ' ' . $validatedData['end_time_time']);

        // カスタムバリデーション
        $errors = [];

        // 1. 開始日付が終了日付より後の場合
        if ($validatedData['start_time_date'] > $validatedData['end_time_date']) {
            $errors['start_time_date'] = ['開始日付は終了日付以前である必要があります。'];
            $errors['end_time_date'] = ['終了日付は開始日付以降である必要があります。'];
        }

        // 2. 同じ日付で開始時刻が終了時刻より後の場合、または同一の場合
        if ($validatedData['start_time_date'] === $validatedData['end_time_date']) {
            if ($validatedData['start_time_time'] >= $validatedData['end_time_time']) {
                $errors['start_time_time'] = ['開始時刻は終了時刻より前である必要があります。'];
                $errors['end_time_time'] = ['終了時刻は開始時刻より後である必要があります。'];
            }
        }

        // 3. 開始日時と終了日時の差を計算（5分超チェック）
        $differenceInMinutes = $startDateTime->diffInMinutes($endDateTime, false);
        if ($differenceInMinutes <= 5) {
            $errors['start_time_time'] = ['開始時刻と終了時刻の差は5分超である必要があります。'];
            $errors['end_time_time'] = ['終了日時は開始日時より5分超後である必要があります。'];
        }

        // エラーがある場合はリダイレクト
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        // スケジュールを更新
        $schedule->start_time = $startDateTime;
        $schedule->end_time = $endDateTime;

        // movie_id を設定（バリデーション済みの値を使用）
        if (isset($validatedData['movie_id'])) {
            $schedule->movie_id = $validatedData['movie_id'];
        }

        $schedule->save();

        return redirect()->route('admin.schedules.detail', $schedule->movie_id)->with('success', 'スケジュールを更新しました。');
    }

    public function scheduleDestroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $movie_id = $schedule->movie_id;
        $schedule->delete();
        return redirect()
                ->route('admin.schedules.detail', ['id' => $movie_id])
                ->with('success', "スケジュールを削除しました");
    }
}