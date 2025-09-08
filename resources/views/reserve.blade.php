<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>座席予約フォーム</title>
</head>

<body>
    <h1>座席予約フォーム</h1>
    
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div style="color: green; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <!-- 映画作品 -->
        <div>
            <label>映画作品:</label>
            <span>{{ $movieId }}</span>
            <input type="hidden" name="movie_id" value="{{ $movieId }}">
            @error('movie_id')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 上映スケジュール -->
        <div>
            <label>上映スケジュール:</label>
            <span>{{ $scheduleId }}</span>
            <input type="hidden" name="schedule_id" value="{{ $scheduleId }}">
            @error('schedule_id')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 座席 -->
        <div>
            <label>座席:</label>
            <span>{{ $sheetId }}</span>
            <input type="hidden" name="sheet_id" value="{{ $sheetId }}">
            @error('sheet_id')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 日付 -->
        <div>
            <label>日付:</label>
            <span>{{ $date }}</span>
            <input type="hidden" name="date" value="{{ $date }}">
            @error('date')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 予約者氏名 -->
        <div>
            <label for="name">予約者氏名:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 予約者メールアドレス -->
        <div>
            <label for="email">予約者メールアドレス:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">予約する</button>
    </form>
</body>

</html>