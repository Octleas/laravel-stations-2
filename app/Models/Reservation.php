<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        
        // insert操作でも created_at と updated_at を自動設定
        static::creating(function ($model) {
            if (empty($model->created_at)) {
                $model->created_at = $model->freshTimestamp();
            }
            if (empty($model->updated_at)) {
                $model->updated_at = $model->freshTimestamp();
            }
        });
    }

    protected $fillable = [
        'date',
        'schedule_id', 
        'sheet_id',
        'email',
        'name',
        'is_canceled'
    ];

    protected $casts = [
        'is_canceled' => 'boolean',
        'date' => 'date'
    ];

    protected $attributes = [
        'is_canceled' => false
    ];
}