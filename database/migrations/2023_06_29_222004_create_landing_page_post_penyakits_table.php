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
        Schema::create('landing_page_post_penyakits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_penyakit')->constrained('penyakits')->onDelete('cascade');

            $table->string('title_post_penyakit');
            $table->string('slug_post_penyakit');
            $table->text('tags_post_penyakit');
            $table->longText('description_post_penyakit');
            $table->string('video_post_penyakit')->nullable();
            $table->string('image_post_penyakit');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_post_penyakits');
    }
};
