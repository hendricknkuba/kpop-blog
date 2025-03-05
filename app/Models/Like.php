<?php

namespace App\Models;

use Database\Factories\LikeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


class Like extends Model
{
    /** @use HasFactory<LikeFactory> */
    Use HasFactory;

    protected $fillable = [
        'post_id',
        'author_id',
    ];


    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }


    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
