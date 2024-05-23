<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news_article_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('badge_colour');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_article_categories');
    }
};
