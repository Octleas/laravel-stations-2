<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AdminMenu</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .movie-row:hover {
            background-color: #f5f5f5;
            transition: background-color 0.2s ease;
        }
        .movie-row {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="admin-container">

        <div class="admin-actions">
            <button class="btn-create" onclick="location.href='{{ route('movies.index') }}'">
                作品一覧画面
            </button>
            <button class="btn-create" onclick="location.href='{{ route('admin.schedules') }}'">
                スケジュールを管理する
            </button>
            <button class="btn-create" onclick="location.href='{{ route('admin.movies.create') }}'">
                映画を登録する
            </button>
        </div>

        @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- 映画一覧 -->
        <div class="movie-list">
            <table class="movie-table">
                <thead>
                    <tr>
                        <th>タイトル</th>
                        <th>画像</th>
                        <th>公開年</th>
                        <th>ジャンル</th>
                        <th>上映ステータス</th>
                        <th>概要</th>
                        <th>登録日時</th>
                        <th>更新日時</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movies as $movie)
                    <tr class="movie-row" onclick="location.href='{{ route('admin.movies.detail', $movie->id) }}'" style="cursor: pointer;">
                        <td>{{ $movie->title }}</td>
                        <td><img src="{{ $movie->image_url }}" alt="{{ $movie->title}}" class="movie-image"></td>
                        <td>{{ $movie->published_year }}</td>
                        <td>{{ optional($movie->genre)->name }}</td>
                        <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
                        <td>{{ $movie->description }}</td>
                        <td>{{ $movie->created_at }}</td>
                        <td>{{ $movie->updated_at }}</td>
                        <th>
                            <button class="btn-edit"
                                onclick="event.stopPropagation(); location.href='{{ route('admin.movies.edit', $movie->id) }}'">
                                編集
                            </button>
                        </th>
                        <th>
                            <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST"
                                style="display:inline;" onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-rmv">削除</button>
                            </form>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>