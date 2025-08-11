<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class PracticeController extends Controller
{
    public function movies()
    {
        $movies = Movie::all();
        return view('movies', ['movies' => $movies]);
    }

    public function admin()
    {
            $movies = Movie::all();
            return view('admin', ['movies' => $movies]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'title' => 'required|unique:movies,title',
                'image_url' => 'required|active_url',
                'published_year' => 'required|integer',
                'description' => 'required',
                'is_showing' => 'required',
            ]);
            
        
        $movie = new Movie(); //空箱（Movieインスタンス）を用意
        $movie->title = $request->input('title'); //Movieインスタンスのtitleプロパティにリクエストからの値を保持
        $movie->image_url = $request->input('image_url');
        $movie->published_year = $request->input('published_year');
        $movie->description = $request->input('description');
        $movie->is_showing = $request->input('is_showing', false);
        $movie->save(); //データベースに保存

        return redirect()->route('admin.movies')->with('success', '映画が作成されました。');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch(\Exception $e) {
            \Log::error("映画の保存中にエラーが発生しました: " . $e->getMessage());
            return redirect()->back()->with('error', '映画の保存中に予期せぬエラーが発生しました。')->withInput();
        }        
    }

    public function edit($id)
    {
        $movie = Movie::find($id);

        return view('edit', ['movie' => $movie]);
    }

    public function update(Request $request, $id)
    {

        $movie = Movie::findOrFail($id);

        try{
            $validatedData = $request->validate([
                'title' => 'required|unique:movies,title,' . $id,
                'image_url' => 'required|active_url',
                'published_year' => 'required|integer',
                'description' => 'required', // nullableから'required'に戻します
                'is_showing' => 'boolean', // 'required'を含めず、booleanのみにします
            ]);
            
        
        $movie->title = $request->input('title'); //Movieインスタンスのtitleプロパティにリクエストからの値を保持
        $movie->image_url = $request->input('image_url');
        $movie->published_year = $request->input('published_year');
        $movie->description = $request->input('description');
        $movie->is_showing = $request->input('is_showing', false);
        
        $movie->save(); //データベースに保存

        return redirect()->route('admin.movies')->with('success', '映画情報を更新しました。');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch(\Exception $e) {
            \Log::error("映画の保存中にエラーが発生しました: " . $e->getMessage());
            return redirect()->back()->with('error', '映画の保存中に予期せぬエラーが発生しました。')->withInput();
        }        
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