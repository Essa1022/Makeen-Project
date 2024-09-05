<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ads>
 */
class AdsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'title'=>fake()->word(),
            'link'=>fake()->url(),
            'ad_place'=> fake()->randomElement([
                'بنر صفحه اصلی 1',
                'بنر صفحه اصلی 2',
                'بنر صفحه دسته بندی',
                'بنر سکشن 1',
                'بنر سکشن 2',
                'بنر سکشن 3',
                'بنر سکشن 4']),
            'starts_at'=>fake()->date(),
            'ends_at'=>fake()->date(),
            'status'=>fake()->randomElement([0,1]),
        ];
    }
}
