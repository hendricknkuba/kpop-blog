<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    Use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'content',
        'image',
        'status',
        'category',
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

    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
