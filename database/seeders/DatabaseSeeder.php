<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ads;
use App\Models\Like;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Subtitle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([PermissionSeeder::class, CategorySeeder::class, SettingSeeder::class, LabelSeeder::class]);
    }
}
