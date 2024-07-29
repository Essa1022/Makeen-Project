<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'about_us',
            'value' => 'خبرگزاری ........... با در نظر گرفتن دو حوزه‌ی وسیع کاری در داخل و خارج کشور تلاش دارد اهداف خود را در جهت آگاهی بخشی و بصیرت افزایی محقق سازد.
رسانه ها نقش بی بدیلی در شکلگیری، جهت‌دهی و مهندسی افکار عمومی دارند. این نقش در عرصه جنگ نرم اهمیت و برجستگی بیشتری دارد، لذا میتوان از جبهه رسانه‌های
استکبار جهانی به عنوان زرادخانه غرب در جنگ نرم یادکرد. خبرگزاری ..........  با در نظر گرفتن دو حوزه ی وسیع کاری در داخل و خارج کشور تلاش دارد اهداف خود را در جهت آگاهی بخشی و بصیرت افزایی محقق سازد',
        ]);

        Setting::create([
            'key' => 'footer',
            'value' => 'تمامی حقوق این سایت برای خبرگزاری محفوظ است. نقل مطالب با ذکر منبع بلامانع است.Copyright © 2024 khabar News Agancy, All rights reserved',
        ]);

        $logo = Setting::create([
            'key' => 'site_logo',
            'value' => '',
        ]);
//        $logo->addMedia(database_path('seeds/images/logo.jpg'))->toMediaCollection('logo', 'local');
    }
}
