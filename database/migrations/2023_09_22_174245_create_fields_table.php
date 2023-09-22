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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('type', 150)->comment('eg:- int, boolean, string, json');
            $table->unsignedBigInteger('length')->comment('specify the character lenght');
            $table->boolean('null')->default(true);
            $table->string('comment', 150)->comment('comment of the field');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
