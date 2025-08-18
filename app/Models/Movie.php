<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    /**
     * 一括代入を許可する属性
     *
     * @var array<int, string>
     */
    // ▼▼▼【この$fillableプロパティを追加】▼▼▼
    protected $fillable = [
        'title',
        'image_url',
        'published_year',
        'genre_id',
        'description',
        'is_showing',
    ];

    public function genre(){
        return $this->belongsTo(Genre::class);
    }
}