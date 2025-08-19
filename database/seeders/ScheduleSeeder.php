<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Movie; // Movieモデルもインポート

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // 既存の映画のIDを全て取得
        $movieIds = Movie::pluck('id');

        // 10件のスケジュールを作成
        Schedule::factory()->count(30)->make()->each(function ($schedule) use ($movieIds) {
            // 取得した映画IDの中からランダムに1つ選んで割り当てる
            $schedule->movie_id = $movieIds->random();
            $schedule->save();
        });
    }
}