<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('prodi_id')->constrained('prodis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelas');
    }
};
