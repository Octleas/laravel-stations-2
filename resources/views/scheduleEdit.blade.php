<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>映画スケジュール編集</title>
</head>

<body>
    <form action="{{ route('admin.schedules.update', ['id' => $schedule->id]) }}" method="POST">
        @csrf
        @method('PATCH')
        <div>
            <label for="start_time_date">開演日程 </label>
            <input type="date" id="start_time_date" name="start_time_date"
                value="{{ old('start_time_date', $start_time_date) }}" />
        </div>
        <div>
            <label for="start_time_time">開演時刻 </label>
            <input type="time" id="start_time_time" name="start_time_time"
                value="{{ old('start_time_time', $start_time_time) }}" />
        </div>
        <div>
            <label for="end_time_date">終演日程 </label>
            <input type="date" id="end_time_date" name="end_time_date"
                value="{{ old('end_time_date', $end_time_date) }}" />
        </div>
        <div>
            <label for="end_time_time">終演時刻 </label>
            <input type="time" id="end_time_time" name="end_time_time"
                value="{{ old('end_time_time', $end_time_time) }}" />
        </div>
        <div>
            <label for="screen_number">スクリーン </label>
            <input type="text" id="screen_number" name="screen_number" value="{{old('screen_number')}}" />
        </div>
        <div>
            <button type="submit">更新する</button>
        </div>
    </form>