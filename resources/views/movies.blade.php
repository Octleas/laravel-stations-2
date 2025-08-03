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
        <li>タイトル: {{ $movie->title }}</li>
        <li>画像URL: <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" style="max-width: 200px;"></li>
        <li>登録日時: {{ $movie->created_at }}</li>
        <li>更新日時: {{ $movie->updated_at }}</li>
    @endforeach
    </ul>
</body>
</html>