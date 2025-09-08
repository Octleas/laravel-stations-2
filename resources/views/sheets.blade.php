<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sheets</title>
    <link rel="stylesheet" href="{{ asset('css/sheets.css') }}">
</head>

<body>
    <div>
        <h1>座席一覧</h1>
        @if(isset($sheets))
        <!-- 座席一覧表示 -->
        <div>
            @foreach($sheets as $sheet)
                <div>{{ $sheet->row }}-{{ $sheet->column }}</div>
            @endforeach
        </div>
        @elseif(isset($seatsByRow))
        <!-- 座席配置 -->
        <h1>座席配置</h1>
        <div class="legend">
            <span class="available-seat-legend">□ 予約可能</span>
            <span class="reserved-seat-legend">■ 予約済み</span>
        </div>
        <div>
            <table class="seating-chart">
                <thead>
                    <tr>
                        <th colspan="5" class="screen">スクリーン</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seatsByRow as $rowLetter => $seats)
                    <tr>
                        @foreach($seats as $seat)
                        <td class="{{ $seat['is_reserved'] ? 'reserved-seat' : 'available-seat' }}">
                            @if($seat['is_reserved'])
                                <!-- 予約済み座席はリンクなし -->
                                <span class="seat-code">{{ $seat['seat_code'] }}</span>
                            @else
                                <!-- 予約可能座席はリンクあり -->
                                <a href="{{ route('sheets.reserve', ['movie_id' => $movieId, 'schedule_id' => $scheduleId, 'date' => $date, 'sheetId' => $seat['seat_code']]) }}" class="seat-link">
                                    {{ $seat['seat_code'] }}
                                </a>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
</body>

</html>