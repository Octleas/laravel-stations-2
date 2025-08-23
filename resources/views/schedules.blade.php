<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>映画スケジュール一覧</title>
</head>

<body>
    <h1>映画スケジュール一覧</h1>
    @foreach($movies as $movie)
    <h2 onclick="location.href='{{ route('admin.schedules.detail', $movie->id) }}'" class="movie-title">
        ({{ $movie->id }}) {{ $movie->title }}</h2>
    @if($movie->schedules->isNotEmpty())
    @foreach($movie->schedules as $schedule)
    <button class="schedule-item" onclick="location.href='{{ route('admin.schedules.detail', $movie->id) }}'">
        {{ \Carbon\Carbon::parse($schedule->start_time)->format('n/j H:i') }} ~
        {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
        <span style="color: #7f8c8d; font-size: 0.85em; margin-left: 10px;">スクリーン{{ $schedule->screen_number }}</span>
    </button>
    @endforeach
    @else
    <p>スケジュールがありません。</p>
    @endif
    @endforeach
</body>

</html>