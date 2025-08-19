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
        <h1>座席配置</h1>
        <div>
            <table class="seating-chart">
                <thead>
                    <tr>
                        <th colspan="5" class="screen">スクリーン</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    <tr>
                        @for ($column = 1; $column <= 5; $column++) <td>{{ $row }}-{{ $column }}</td>
                            @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>

</html>