<?php

use App\Models\NewsCategory;
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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('title_summary');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('excerpt');
            $table->foreignIdFor(NewsCategory::class);
            $table->foreignId('created_by');
            $table->foreignId('posted_by');
            $table->enum('is_active', [0,1])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
