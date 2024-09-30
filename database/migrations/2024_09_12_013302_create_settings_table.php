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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('instansi');
            $table->string('logo');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('running_text');
            $table->string('video');
            $table->string('primary');
            $table->string('secondary');
            $table->string('accent');
            $table->string('background');
            $table->string('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
