<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('question_id')->nullable(true)->default(null);
            $table->foreign('question_id')->references('id')->on('questions');

            $table->unsignedBigInteger('client_id')->nullable(true)->default(null);
            $table->foreign('client_id')->references('id')->on('client_users');

            $table->text('answer');
            $table->text('answer_html')->nullable(true)->default(null);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
