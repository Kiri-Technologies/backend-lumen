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
            // $table->unsignedInteger('owner_id');
            $table->unsignedInteger('user_id');
            // $table->unsignedInteger('supir_id');
            $table->unsignedInteger('route_id');
            $table->string('plat_nomor');
            $table->text('qr_code')->nullable();
            $table->date('pajak_tahunan');
            $table->date('pajak_stnk');
            $table->date('kir_bulanan');
            $table->boolean('is_beroperasi')->nullable();
            $table->unsignedInteger('supir_id')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('route_id')
                ->references('id')
                ->on('routes')
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
        Schema::dropIfExists('angkot');
    }
}
