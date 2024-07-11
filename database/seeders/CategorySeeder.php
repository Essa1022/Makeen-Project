<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['جهان','سیاست','اقتصاد','ورزش','فرهنگ',
                       'سلامت','جامعه','دانش و فناوری', 'اندیشه', 'دین'];
        foreach($categories as $category)
        {
            Category::create([
                'name' => $category,
                'category_id' => null
            ]);
        }

        $categories = ['آمریکا','اروپا','روسیه','چین','آفریقا','خاورمیانه'];
        foreach($categories as $category)
        {
            Category::create([
                'name' => $category,
                'category_id' => 1
            ]);
        }

        $categories = ['رهبری','دولت','مجلس','انتخابات','احزاب','نظامی'];
        foreach($categories as $category)
        {
            Category::create([
                'name' => $category,
                'category_id' => 2
            ]);
        }

        $categories = ['بازرگانی','مسکن','کشاورزی','صنعت','اقتصاد کلان',
                       'اقتصاد سیاسی','راهنمای خرید','کسب و کار',
                       'بازار مالی', 'بازار کار', 'انرژی','جهان'];
        foreach($categories as $category)
        {
            Category::create([
                'name' => $category,
                'category_id' => 3
            ]);
        }

        $categories = ['کشتی','وزنه برداری','فوتبال ملی','فوتبال جهان',
                       'مدیریت ورزش','المپیک و پاراالمپیک','ورزش های رزمی',
                       'سایر ورزش ها','بسکتبال','لیگ برتر','والیبال'];
        foreach($categories as $category)
        {
            Category::create([
            'name' => $category,
            'category_id' => 4
            ]);
        }

        $categories = ['تئاتر','سینما','تلویزیون','ادبیات',
                       'تجسمی','مدیریت فرهنگی','طنز و کاریکاتور', 'دفاع مقدس',
                       'موسیقی','رسانه','کتاب'];
        foreach($categories as $category)
        {
            Category::create([
            'name' => $category,
            'category_id' => 5
            ]);
        }

        $categories = ['سالمندی','بیماری ها','سلامت زنان','اصناف پزشکی',
                       'سلامت مردان','تغذیه و تناسب اندام','سلامت کودک و خانواده',
                       'دارو و تجهیزات پزشکی','سلامت روان','مد و زیبایی'];
        foreach($categories as $category)
        {
            Category::create([
            'name' => $category,
            'category_id' => 6
            ]);
        }

        $categories = ['آموزش','شهری','خانواده','حوادث',
                       'پلیس ','سبک زندگی','مشکلات مردم',
                       'محیط زیست','آسیب ها','غذایی','سرگرمی'];
        foreach($categories as $category)
        {
            Category::create([
            'name' => $category,
            'category_id' => 7
            ]);
        }

        $categories = ['بازی','پزشکی','شبه علم','اینترنت',
                       'استارت آپ ','دانش های بنیادی','جنگ افزار',
                       'فناری ','طبیعت','خودرو','نجوم'];
        foreach($categories as $category)
        {
            Category::create([
            'name' => $category,
            'category_id' => 8
            ]);
        }
    }
}
