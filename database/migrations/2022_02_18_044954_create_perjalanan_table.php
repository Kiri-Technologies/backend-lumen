<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerjalananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perjalanan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('penumpang_id');
            $table->unsignedInteger('angkot_id');
            $table->unsignedInteger('supir_id');
            $table->string('titik_naik');
            $table->string('titik_turun');
            $table->string('jarak');
            $table->string('rekomendasi_harga');
            $table->boolean('is_done');
            $table->boolean('is_connected_with_driver');
            $table->timestamps();

            $table->foreign('penumpang_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('angkot_id')
                ->references('id')
                ->on('angkot')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('supir_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('perjalanan');
    }
}
