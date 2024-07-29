<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ads extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;
    protected $fillable = [
        'title',
        'link',
        'ad_place',
        'starts_at',
        'ends_at',
        'status',
    ];
}
