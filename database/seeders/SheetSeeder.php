<?php

namespace Database\Seeders;

use App\Models\Sheet; // Sheetモデルを忘れずにインポート
use Illuminate\Database\Seeder;

class SheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 'a'から'c'までの行を配列で定義
        $rows = ['a', 'b', 'c'];

        // 1から5までの列を配列で定義
        $columns = range(1, 5);

        // 最初のループで行を一つずつ取り出す (例: 'a')
        foreach ($rows as $row) {
            // 次のループで列を一つずつ取り出す (例: 1)
            foreach ($columns as $column) {
                // 取り出した行と列の組み合わせでデータを作成
                // 例: ['row' => 'a', 'column' => 1]
                Sheet::create([
                    'row' => $row,
                    'column' => $column,
                ]);
            }
        }
    }
}