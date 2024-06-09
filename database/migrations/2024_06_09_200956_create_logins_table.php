<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('logins', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45);

            $table->timestamp('login_at');
            $table->timestamp('logout_at')->nullable();
            $table->integer('minutes_logged_in')->nullable();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('logins');
    }
};
