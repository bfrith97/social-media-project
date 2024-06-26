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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('role', 255)->nullable();
            $table->string('company', 255)->nullable();
            $table->string('info', 255)->nullable();
            $table->string('email', 255)->unique();
            $table->text('profile_picture')->nullable();
            $table->text('cover_picture')->nullable();
            $table->unsignedBigInteger('number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->foreignId('relationship_id')->nullable()->constrained('relationships')->onDelete('set null');
            $table->foreignId('partner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
