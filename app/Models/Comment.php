<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment_id',
        'name',
        'email',
        'article_id',
        'message'
    ];
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
    public function comments(): HasMany
    {
        return $this->Hasmany(comment::class)->with('comments');
    }
}
