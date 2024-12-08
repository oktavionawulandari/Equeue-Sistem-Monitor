<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Counter;
use App\Models\Queue;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Queue::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Counter::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Category::class)->constrained()->onDelete('cascade');
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
