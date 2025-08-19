<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>映画作品詳細</title>
</head>

<body>
    <h1>映画詳細</h1>
    <h2 class="movie-title">{{ $movie->title }}</h2>
    <div class="movie-image-wrapper">
        <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" class="movie-image">
    </div>
    <p class="movie-year">公開年: {{ $movie->published_year }}</p>
    <p class="movie-status">{{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
    <p class="movie-description">ジャンル: {{ optional($movie->genre)->name }}</p>
    <p class="movie-description">{{ $movie->description }}</p>
    <p class="movie-date">登録日時: {{ $movie->created_at }}</p>
    <p class="movie-date">更新日時: {{ $movie->updated_at }}</p>

    <h1>上映スケジュール</h1>
    @foreach($schedules as $schedule)
    <div class="schedule-item">
        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} ~
        {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
        <span style="color: #7f8c8d; font-size: 0.9em; margin-left: 10px;">スクリーンx</span>
    </div>
    @endforeach

</body>