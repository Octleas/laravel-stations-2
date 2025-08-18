<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

    public function admin()
    {
        $movies = Movie::with('genre')->get(); 
        return view('admin', ['movies' => $movies]);
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
            'title' => 'required|unique:movies,title', // DBの制約に合わせてmaxルールを追加するのが望ましい
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
    
            $title = $movie->title;
            $movie->delete();
    
            return redirect()
                ->route('admin.movies')
                ->with('success', "映画を削除しました → {$title}");
    
            } catch (\Throwable $e) {
                \Log::error("映画の削除中にエラーが発生しました: " . $e->getMessage());
                return redirect()
                    ->back()
                    ->with('error', '映画の削除中に予期せぬエラーが発生しました。')
                    ->withInput();
            }
    }
}