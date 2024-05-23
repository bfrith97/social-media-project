<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();

            $table->string('author')->nullable();
            $table->foreignId('category_id')->constrained('news_article_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('description')->nullable();
            $table->text('url');
            $table->string('published_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
