<?php

use App\Models\News;
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
        Schema::create('news_views', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(News::class)->constrained()->onDelete('cascade');
            $table->string('ip_address', 45); // IPv4 & IPv6 compatible
            $table->timestamp('viewed_at')->useCurrent();
            $table->timestamps();

            $table->unique(['news_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_views');
    }
};
