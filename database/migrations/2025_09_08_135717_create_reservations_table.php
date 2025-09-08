<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // ID
            $table->date('date'); // 上映日
            $table->unsignedBigInteger('schedule_id'); // スケジュールID
            $table->unsignedBigInteger('sheet_id'); // シートID
            $table->string('email', 255); // 予約者メールアドレス
            $table->string('name', 255); // 予約者名
            $table->boolean('is_canceled')->default(false); // 予約キャンセル済み
            $table->timestamps(); // 作成日時と更新日時

            // 外部キー制約
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('sheet_id')->references('id')->on('sheets')->onDelete('cascade');

            // 複合ユニークキー
            $table->unique(['schedule_id', 'sheet_id'], 'unique_schedule_sheet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
}