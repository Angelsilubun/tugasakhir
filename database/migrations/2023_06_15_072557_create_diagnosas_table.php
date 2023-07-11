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
        Schema::create('diagnosas', function (Blueprint $table) {
            $table->id();
            // $table->integer('user_id');
            // $table->text('gejala');
            // $table->text('hasil');
            // $table->text('deskripsi');
            // $table->text('solusi');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreignId('id_penyakit')->constrained('penyakits')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreignId('id_gejala')->constrained('gejalas')->onDelete('cascade')->onUpdate('cascade');

            $table->text('gejala_diagnosa');
            $table->date('tanggal_diagnosa');

            // $table->foreign('id_penyakit')->references('id')->on('penyakits');
            // $table->foreign('id_gejala')->references('id')->on('gejalas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosas');
    }
};
