<?php

use App\Models\Document;
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
        Schema::create('document_views', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Document::class)->constrained()->onDelete('cascade');
            $table->string('ip_address', 45); // IPv4 & IPv6 compatible
            $table->timestamp('viewed_at')->useCurrent();
            $table->timestamps();

            $table->unique(['document_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_views');
    }
};
