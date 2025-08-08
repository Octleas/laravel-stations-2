<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>映画情報入力</title>
</head>

<body>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <div class="form-error">{{ $error }}</div>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('admin.movies.store') }}" method="POST">
        <!-- action="store"で admin/movies/create から admin/movies/store に飛び、データベースへ保存の処理 -->
        @csrf
        <div class="form-title">
            <label for="title">映画のタイトル</lavel>
                <input type="text" id="title" name="title" />
        </div>
        <div class="form-image_url">
            <label for="image_url">画像URL</lavel>
                <input type="text" id="image_url" name="image_url" />
        </div>
        <div class="form-published_year">
            <label for="published_year">公開年</lavel>
                <input type="text" id="published_year" name="published_year" />
        </div>
        <div class="form-description">
            <label for="description">概要</lavel>
                <textarea id="description" name="description" cols="50" rows="5"></textarea>
        </div>
        <div class="form-is_showing">
            <input type="checkbox" id="is_showing" name="is_showing" value="1" />
            <label for="is_showing">上映中</label>
        </div>
        <div class="form-submit">
            <button type="submit">映画を登録</button>
        </div>
    </form>


</body>