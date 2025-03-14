<?php

namespace App\Models;

use App\Http\Filters\v1\QueryFilter;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    Use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
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

    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
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
