<?php

use App\Models\PoolHouse;
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
        Schema::create('pool_house_images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('image_name');
            $table->foreignIdFor(PoolHouse::class);
            $table->enum('is_active', [0,1])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pool_house_images');
    }
};
