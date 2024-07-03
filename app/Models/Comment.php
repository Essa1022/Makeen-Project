<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function article(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
