<?php

namespace Database\Seeders;

use App\Models\Genre; // Genreモデルをインポート
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存のデータを削除
        Genre::query()->delete();

        // GenreFactoryを使って5件のデータを作成
        Genre::factory(5)->create();
    }
}