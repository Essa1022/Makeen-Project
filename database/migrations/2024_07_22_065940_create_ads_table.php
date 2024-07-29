<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link');
            $table->boolean('status')->default(false);
            $table->enum('ad_place', [
                'بنر صفحه اصلی 1',
                'بنر صفحه اصلی 2',
                'بنر صفحه دسته بندی',
                'بنر سکشن 1',
                'بنر سکشن 2',
                'بنر سکشن 3',
                'بنر سکشن 4'
            ]);
            $table->date('starts_at');
            $table->date('ends_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
