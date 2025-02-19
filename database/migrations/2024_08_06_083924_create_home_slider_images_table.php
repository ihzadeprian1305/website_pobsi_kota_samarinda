<?php

use App\Models\HomeSlider;
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
        Schema::create('home_slider_images', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('image_name')->nullable();
            $table->foreignIdFor(HomeSlider::class);
            $table->enum('is_active', [0,1])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_slider_images');
    }
};
