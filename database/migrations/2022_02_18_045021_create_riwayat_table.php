<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            // ->references('id')
            // ->on('users')
            // ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('angkot_id');
            $table->string('jumlah_pendapatan');
            $table->time('waktu_narik');
            $table->boolean('selesai_narik');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat');
    }
}
