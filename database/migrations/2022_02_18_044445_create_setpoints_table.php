<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('route_id');
            $table->string('nama_lokasi');
            $table->string('lat');
            $table->string('long');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('route_id')
                ->references('id')
                ->on('routes')
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
        Schema::dropIfExists('setpoints');
    }
}
