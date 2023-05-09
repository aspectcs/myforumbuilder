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
        Schema::create('schedulers', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_path');
            $table->integer('total_count')->default(0);
            $table->integer('error_count')->default(0);
            $table->integer('success_count')->default(0);
            $table->text('errors')->nullable(true)->default(null);
            $table->enum('status', ['PENDING','UNDER PROCESS', 'ERROR', 'SUCCESS'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulers');
    }
};
