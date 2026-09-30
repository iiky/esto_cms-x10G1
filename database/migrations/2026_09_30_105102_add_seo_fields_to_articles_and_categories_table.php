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
        Schema::table('articles', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('title');
            $table->text('meta_description')->nullable()->after('excerpt');
            $table->text('meta_keywords')->nullable()->after('tags');
            $table->string('canonical_url')->nullable()->after('meta_keywords');
        });

        Schema::table('article_categories', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('name');
            $table->text('meta_description')->nullable()->after('slug');
            $table->text('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords', 'canonical_url']);
        });

        Schema::table('article_categories', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords']);
        });
    }
};
