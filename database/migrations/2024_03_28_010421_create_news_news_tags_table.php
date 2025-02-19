<?php

use App\Models\News;
use App\Models\NewsTag;
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
        Schema::create('news_news_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(News::class);
            $table->foreignIdFor(NewsTag::class);
            $table->enum('is_active', [0,1])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_news_tags');
    }
};
