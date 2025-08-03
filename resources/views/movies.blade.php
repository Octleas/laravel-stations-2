<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movies</title>
</head>
<body>
    <ul>
        <strong>映画一覧</strong>
    </ul>
    <ul>
    @foreach ($movies as $movie)
        <p>タイトル: {{ $movie->title }}</p>
        <p>画像URL: <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" style="max-width: 200px;"></li>
        <p>公開年: {{ $movie->published_year }}</p>
        <p>{{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
        <p>概要: {{ $movie->description }}</p>
        <p>登録日時: {{ $movie->created_at }}</p>
        <p>更新日時: {{ $movie->updated_at }}</p>
        <br>
    @endforeach
    </ul>
</body>
</html>