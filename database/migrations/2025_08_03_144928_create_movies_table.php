<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->text('title')->comment('映画のタイトル');
            $table->text('image_url')->comment('画像URL');
            $table->integer('published_year')->comment('公開年');
            $table->tinyinteger('is_showing')->default(false)->comment('上映中かどうか');
            $table->text('description')->nullable()->comment('概要');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
