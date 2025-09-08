<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movies</title>
    <link rel="stylesheet" href="{{ asset('css/movies.css') }}">
</head>

<body>
    <div class="admin-action">
        <button class="btn-admin" onclick="location.href='{{ route('admin.movies') }}'">
            管理画面へ
        </button>
    </div>
    <div class="movies-container">
        <h1 class="page-title">映画一覧</h1>

        <div>
            <!--検索機能-->
            <form action="{{ route('movies.index') }}" method="GET">
                <div class="search-container">
                    <!-- id: 基本的な処理には関係ない。 name: コントローラー側のinput('name')に対応する。 value: その際に送るデータ。 -->
                    <input type="text" id="keyword" name="keyword" placeholder="映画のタイトルを入力..."
                        value="{{ request('keyword') }}" />
                    <select name="is_showing" id="is_showing_select">
                        <option value="">すべて</option>
                        <option value="1" @selected(request('is_showing')=='1' )> 上映中 </option>
                        <option value="0" @selected(request('is_showing')=='0' )> 上映予定 </option>
                    </select>
                    <button type="submit">Search</button>
                </div>
            </form>

            {{ $movies->appends(request()->query())->links() }}

            @foreach ($movies as $movie)
            <button class="movie-card" onclick="location.href='{{ route('movies.detail', $movie->id) }}'">
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
            </button>
            @endforeach

        </div>
</body>

</html>