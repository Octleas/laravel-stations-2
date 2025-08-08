<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movies</title>
    <link rel="stylesheet" href="{{ asset('css/movies.css') }}">
</head>

<body>
    <div class="movies-container">
        <h1 class="page-title">映画一覧</h1>

        @foreach ($movies as $movie)
        <div class="movie-card">
            <h2 class="movie-title">{{ $movie->title }}</h2>
            <div class="movie-image-wrapper">
                <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" class="movie-image">
            </div>
            <p class="movie-year">公開年: {{ $movie->published_year }}</p>
            <p class="movie-status">{{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
            <p class="movie-description">{{ $movie->description }}</p>
            <p class="movie-date">登録日時: {{ $movie->created_at }}</p>
            <p class="movie-date">更新日時: {{ $movie->updated_at }}</p>
        </div>
        @endforeach

    </div>
</body>

</html>