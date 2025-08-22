<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理者用映画詳細</title>
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>

<body>
    <div class="container">
        <h1>管理者用映画詳細</h1>

        <div class="movie-details">
            <h2>{{ $movie->title }}</h2>

            <div class="movie-info">
                <div class="image-section">
                    <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" />
                </div>

                <div class="details-section">
                    <p><strong>公開年:</strong> {{ $movie->published_year }}</p>
                    <p><strong>ジャンル:</strong> {{ $movie->genre->name ?? 'N/A' }}</p>
                    <p><strong>概要:</strong> {{ $movie->description }}</p>
                    <p><strong>上映状況:</strong>
                        @if($movie->is_showing)
                        上映中
                        @else
                        上映予定
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="schedules-section">
            <h3>スケジュール一覧</h3>
            @if($schedules && $schedules->count() > 0)
            <div class="schedules-list">
                @foreach($schedules as $schedule)
                <div class="schedule-item">
                    <span>{{ $schedule->start_time }}</span>
                    <span>{{ $schedule->end_time }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p>スケジュールがありません。</p>
            @endif
        </div>

        <div class="actions">
            <a href="{{ route('admin.movies') }}" class="btn btn-back">映画一覧に戻る</a>
            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-edit">編集</a>
        </div>
    </div>
</body>

</html>