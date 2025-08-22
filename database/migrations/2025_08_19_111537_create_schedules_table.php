<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained();
            $table->datetime('start_time')->comment('上映開始時刻');
            $table->datetime('end_time')->comment('上映終了時刻');
            $table->integer('screen_number')->default(1)->comment('スクリーン番号');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};