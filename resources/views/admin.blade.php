<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AdminMenu</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="admin-container">

        <!-- 登録ボタン -->
        <div class="admin-actions">
            <button class="btn-create" onclick="location.href='{{ route('admin.movies.create') }}'">
                映画を登録する
            </button>
        </div>

        <!-- 映画一覧 -->
        <div class="movie-list">
            <table class="movie-table">
                <thead>
                    <tr>
                        <th>タイトル</th>
                        <th>画像</th>
                        <th>公開年</th>
                        <th>上映ステータス</th>
                        <th>概要</th>
                        <th>登録日時</th>
                        <th>更新日時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movies as $movie)
                    <tr>
                        <td>{{ $movie->title }}</td>
                        <td><img src="{{ $movie->image_url }}" alt="{{ $movie->title}}" class="movie-image"></td>
                        <td>{{ $movie->published_year }}</td>
                        <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
                        <td>{{ $movie->description }}</td>
                        <td>{{ $movie->created_at }}</td>
                        <td>{{ $movie->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>