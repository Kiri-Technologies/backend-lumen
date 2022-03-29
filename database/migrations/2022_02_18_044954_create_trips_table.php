<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('penumpang_id');
            $table->unsignedInteger('angkot_id');
            $table->unsignedInteger('history_id');
            $table->unsignedInteger('tempat_naik_id');
            $table->unsignedInteger('tempat_turun_id');
            $table->string('supir_id');
            $table->string('nama_tempat_naik');
            $table->string('nama_tempat_turun');
            $table->string('jarak');
            $table->string('rekomendasi_harga');
            $table->boolean('is_done');
            $table->boolean('is_connected_with_driver');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('history_id')
                ->references('id')
                ->on('histories')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('penumpang_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('angkot_id')
                ->references('id')
                ->on('vehicles')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('supir_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('tempat_naik_id')
                ->references('id')
                ->on('setpoints')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('tempat_turun_id')
                ->references('id')
                ->on('setpoints')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
