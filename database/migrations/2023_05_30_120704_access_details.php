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
        Schema::create('access_details', function (Blueprint $table) {
            // $table->increments('id');
            $table->ipAddress('ip')->nullable();
            $table->string('user_agent',500)->nullable();
            $table->string('shortener_identifier')->nullable();
            $table->foreign('shortener_identifier')->references('identifier')->on('shorteners')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_details');
    }
};
