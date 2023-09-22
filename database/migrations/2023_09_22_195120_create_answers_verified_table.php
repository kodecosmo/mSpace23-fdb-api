<?php

use App\Models\Answer;
use App\Models\Profile;
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
        Schema::create('answers_verified', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Answer::class)->comment('Answer verified');
            $table->foreignIdFor(Profile::class)->comment('Profile of the answer verified teacher');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers_verified');
    }
};
