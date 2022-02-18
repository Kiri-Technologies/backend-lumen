<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAngkotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('angkot', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id');
            $table->unsignedInteger('supir_id');
            $table->unsignedInteger('route_id');
            $table->string('plat_nomor');
            $table->text('qr_code');
            $table->date('pajak_tahunan');
            $table->date('pajak_stnk');
            $table->date('kir_bulanan');
            $table->boolean('is_beroperasi');
            $table->string('status');
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
        Schema::dropIfExists('angkot');
    }
}
