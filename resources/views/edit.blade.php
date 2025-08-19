<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>編集画面</title>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>

<body>
    <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <div class="form-error">{{ $error }}</div>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-title">
                <label for="title">映画のタイトル</label>
                <input type="text" id="title" name="title" value="{{ old('title', $movie->title) }}" />
            </div>
            <div class="form-image_url">
                <label for="image_url">画像URL</label>
                <input type="text" id="image_url" name="image_url" value="{{ old('image_url', $movie->image_url) }}" />
            </div>
            <div class="form-published_year">
                <label for="published_year">公開年</label>
                <input type="text" id="published_year" name="published_year"
                    value="{{ old('published_year', $movie->published_year) }}" />
            </div>
            <div class="form-published_year">
                <label for="genre">ジャンル</lavel>
                    <input type="text" id="genre" name="genre" value="{{old('genre', $movie->genre->name)}}" />
            </div>
            <div class="form-description">
                <label for="description">概要</label>
                <textarea id="description" name="description" cols="50"
                    rows="5">{{ old('description', $movie->description) }}</textarea>
            </div>
            <div class="form-is_showing">
                <input type="checkbox" id="is_showing" name="is_showing" value="1"
                    {{ old('is_showing', $movie->is_showing) ? 'checked' : '' }} />
                <label for="is_showing">上映中</label>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-update">更新</button>
                <button type="button" class="btn-list"
                    onclick="location.href='{{ route('admin.movies') }}'">一覧画面へ</button>
            </div>
        </form>
    </div>
</body>