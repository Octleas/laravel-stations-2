<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sheets', function (Blueprint $table) {
            $table->id();
            $table->integer('column')->comment('列');
            $table->string('row')->comment('行');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('sheets');
    }
};