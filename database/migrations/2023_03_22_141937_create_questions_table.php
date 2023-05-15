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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id')->nullable(true)->default(null);
            $table->foreign('category_id')->references('id')->on('categories');

            $table->unsignedBigInteger('sub_category_id')->nullable(true)->default(null);
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');

            $table->unsignedBigInteger('client_id')->nullable(true)->default(null);
            $table->foreign('client_id')->references('id')->on('client_users');

//            $table->json('tags')->nullable(true)->default(null);

            $table->text('question');
            $table->text('description')->nullable(true)->default(null);
            $table->boolean('status')->default(true);
            $table->boolean('popular')->default(false);
            $table->enum('api_status', ['N/A', 'E', 'P', 'S', 'IP'])->default('N/A');
            $table->text('api_remarks')->nullable(true)->default(null);

            $table->unsignedBigInteger('total_tokens')->nullable(true)->default(0);

            $table->string('slug')->unique();

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
