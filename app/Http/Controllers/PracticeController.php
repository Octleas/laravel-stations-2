<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

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

}
