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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('question_id')->nullable(true)->default(null);
            $table->foreign('question_id')->references('id')->on('questions');


            $table->unsignedBigInteger('answer_id')->nullable(true)->default(null);
            $table->foreign('answer_id')->references('id')->on('answers');

            $table->unsignedBigInteger('client_id')->nullable(true)->default(null);
            $table->foreign('client_id')->references('id')->on('client_users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
