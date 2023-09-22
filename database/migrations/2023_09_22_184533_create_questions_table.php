<?php

use App\Models\Profile;
use App\Models\Subject;
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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150)->comment('Question');
            $table->string('slug', 150);
            $table->text('body', 10000)->comment('Question body');
            $table->foreignIdFor(Profile::class); // Subject picture
            $table->foreignIdFor(Subject::class); // Subject picture
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
