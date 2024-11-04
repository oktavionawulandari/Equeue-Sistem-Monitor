<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Counter;
use App\Models\Queue;
use App\Models\Category;
use App\Models\Antrian;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('antrian_nows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antrian_id');
            $table->foreignId('queue_id');
            $table->foreignId('counter_id');
            $table->foreignId('category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian_nows');
    }
};
