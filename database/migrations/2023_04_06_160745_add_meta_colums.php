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
        Schema::table('questions', function (Blueprint $table) {
            $table->string('meta_title')->nullable(true)->default(null);
            $table->text('meta_description')->nullable(true)->default(null);
        });


        Schema::table('categories', function (Blueprint $table) {
            $table->string('meta_title')->nullable(true)->default(null);
            $table->text('meta_description')->nullable(true)->default(null);
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->string('meta_title')->nullable(true)->default(null);
            $table->text('meta_description')->nullable(true)->default(null);
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->string('meta_title')->nullable(true)->default(null);
            $table->text('meta_description')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
};
