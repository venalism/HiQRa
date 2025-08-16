<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('divisi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_divisi');
            $table->foreignId('jabatan_id')->constrained('jabatan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('divisi');
    }
};
