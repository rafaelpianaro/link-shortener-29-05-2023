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
        Schema::create('shorteners', function (Blueprint $table) {
            $table->string('identifier',8);
            $table->string('title',50);
            $table->string('url',500);
            $table->integer('access')->nullable()->default(0);
            $table->ipAddress('ip')->nullable();
            $table->string('user_agent',500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shorteners');
    }
};
