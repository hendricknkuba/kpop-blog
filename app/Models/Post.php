<?php

namespace App\Models;

use App\Http\Filters\v1\QueryFilter;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    Use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }
}
