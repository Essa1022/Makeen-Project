<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'visibility',
        'user_id',
    ];

    protected $casts = [
        'body' => 'object',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(label::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
