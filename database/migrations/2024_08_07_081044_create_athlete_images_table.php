<?php

use App\Models\Athlete;
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
        Schema::create('athlete_images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('image_name');
            $table->foreignIdFor(Athlete::class);
            $table->enum('is_active', [0,1])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athlete_images');
    }
};
