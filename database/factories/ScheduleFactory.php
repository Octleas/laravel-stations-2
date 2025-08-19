<?php

namespace Database\Factories;

use App\Models\Movie;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    public function definition()
    {
        // --- 修正箇所 ---
        // 1. まずはランダムな日時を生成する (例: 今から30日後までの間)
        $randomDate = $this->faker->dateTimeBetween('now', '+30 days');
        $startTime = CarbonImmutable::parse($randomDate);

        // 2. 分を5分刻みに丸める (例: 43分 -> 40分)
        $minute = $startTime->minute;
        $remainder = $minute % 5;
        $adjustedStartTime = $startTime->subMinutes($remainder)->second(0); // 秒も0に設定

        // 3. 上映時間（例: 2時間15分）をランダムに加算して終了時刻を計算
        $addMinutes = [120, 135, 150][array_rand([120, 135, 150])]; // 2時間, 2時間15分, 2時間半からランダム
        $endTime = $adjustedStartTime->addMinutes($addMinutes);

        return [
            // 既存の映画をランダムに選ぶように変更すると、より実践的
            'movie_id' => Movie::inRandomOrder()->first()->id,
            'start_time' => $adjustedStartTime,
            'end_time' => $endTime,
        ];
    }
}