<?php

namespace Database\Seeders;
use App\Models\Label;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labels = [
            'ویژه 1 دسته بندی',
            'ویژه 2 دسته بندی',
            'ویژه 1 صفحه اصلی',
            'ویژه 2 صفحه اصلی',
            'برگزیده'
        ];
        foreach($labels as $label)
        {
            Label::create([
                'name' => $label,
            ]);
        }
    }
}
