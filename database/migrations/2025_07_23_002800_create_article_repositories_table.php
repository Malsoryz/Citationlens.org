<?php

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
        Schema::create('article_repositories', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->json('meta');
            $table->unsignedBigInteger('journal_id');
            $table->foreign('journal_id')
                ->references('id')
                ->on('journals')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_repositories');
    }
};
