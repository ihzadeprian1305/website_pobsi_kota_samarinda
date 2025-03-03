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
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(PoolHouse::class)->nullable();
            $table->string('another_pool_house')->nullable();
            $table->date('born_date');
            $table->enum('sex', ['Laki-laki', 'Perempuan']);
            $table->text('career_description')->nullable();
            $table->enum('is_active', [0,1])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};
