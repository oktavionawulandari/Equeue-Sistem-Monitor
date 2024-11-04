<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Counter;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->onDelete('cascade');
            // $table->foreignIdFor(Counter::class)->onDelete('cascade')->nullable();
            $table->string('no');
            $table->enum('status', ['1', '2', '3', '4', '5']);
            $table->date('date');
            $table->foreignId('operator_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
