<?php

use App\Models\Asset;
use App\Models\Gender;
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
            $table->string('first_name', 150);
            $table->string('last_name', 150);
            $table->string('email')->unique();
            $table->timestamp('user_verified_at')->nullable();
            $table->string('password');
            $table->string('whatsapp_number', 150);
            $table->text('description', 500);
            $table->foreignIdFor(Gender::class);
            $table->foreignIdFor(Asset::class); // Profile picture
            $table->string('remember_token', 150); // Stored in session storage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
