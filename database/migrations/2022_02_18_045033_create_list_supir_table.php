<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListSupirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_supir', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supir_id');
            $table->unsignedInteger('angkot_id');
            $table->boolean('is_confirmed');
            $table->timestamps();

            $table->foreign('supir_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('angkot_id')
                ->references('id')
                ->on('angkot')
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
        Schema::dropIfExists('list_supir');
    }
}
