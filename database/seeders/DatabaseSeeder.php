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
        $this->call([PermissionSeeder::class, CategorySeeder::class, SettingSeeder::class]);

        Subtitle::factory()->count(5)->create();
        Ads::factory()->count(7)->create();

        for ($i = 0; $i < 3; $i++) {
            $user = User::inRandomOrder()->first();
            $category = Category::inRandomOrder()->first();
            $article = Article::factory()->for($user)->hasAttached($category)->create();
            $comment = Comment::factory()->for($article)->create();
            Like::factory()->for($comment)->create();
        }


        // Comment::factory()->count(7)->has(Comment::factory()->count(1))->has(Article::factory()->count(1))->create();
        // Like::factory()->count(7)->has(Comment::factory()->count(2))->create();
    }

}
