<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supir_id');
            $table->unsignedInteger('angkot_id');
            $table->boolean('is_confirmed')->nullable();
            $table->timestamps();

            $table->foreign('supir_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('angkot_id')
                ->references('id')
                ->on('vehicles')
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
        Schema::dropIfExists('list_drivers');
    }
}
