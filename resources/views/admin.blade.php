<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AdminMenu</title>
</head>
<body>
    <ul>
    <table>
    <tr>
            <th>タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映しているか</th>
            <th>概要</th>
            <th>登録日時</th>
            <th>更新日時</th>
    </tr>
    @foreach ($movies as $movie)
        <tr>
            <td>{{ $movie->title }}</td>
            <td><img src="{{ $movie->image_url }}" alt="{{ $movie->title}}" style="max-width: 200px;"></td>
            <td>{{ $movie->published_year }}</td>
            <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
            <td>{{ $movie->description }}</td>
            <td>{{ $movie->created_at }}</td>
            <td>{{ $movie->updated_at }}</td>
        </tr>
    @endforeach
    </table>
    </ul>
</body>
</html>