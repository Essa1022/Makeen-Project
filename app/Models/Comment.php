<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment_id',
        'name',
        'email',
        'article_id',
        'message',
        'user_id'
    ];
    public function article(): HasMany
    {
        return $this->hasMany(Article::class);
    }
    public function commentables(): MorphTo
    {
        return $this->morphTo();
    }
}
