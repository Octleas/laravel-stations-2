<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スケジュール管理</title>
</head>

<body>
    <h1>スケジュール管理画面</h1>
    <div>
        <h2 class="movie-title">({{ $movie->id }}) {{ $movie->title }}</h2>
        <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('本当にこの映画を削除しますか？')">映画を削除</button>
        </form>
    </div>
    @foreach($schedules as $schedule)
    <div class="schedule-item">
        {{ \Carbon\Carbon::parse($schedule->start_time)->format('n/j H:i') }} ~
        {{ \Carbon\Carbon::parse($schedule->end_time)->format('n/j H:i') }}
        <span style="color: #7f8c8d; font-size: 0.9em; margin-left: 10px;">スクリーン{{ $schedule->screen_number }}</span>
        @if($schedule && $schedule->id)
        <button onclick="location.href='{{ route('admin.schedules.edit', $schedule->id) }}'"> 編集 </button>
        <form action="{{ route('admin.schedules.destroy',$schedule->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" style="color: red;">削除</button>
        </form>
        @endif
    </div>
    @endforeach
    <button onclick="location.href='{{ route('admin.schedules.create', $movie->id) }}'"> 新規作成 </button>

</body>

</html>