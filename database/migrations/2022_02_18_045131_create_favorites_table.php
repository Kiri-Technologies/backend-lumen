<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->unsignedInteger('route_id');
            $table->unsignedInteger('tempat_naik_id');
            $table->unsignedInteger('tempat_turun_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('route_id')
                ->references('id')
                ->on('routes')
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
        Schema::dropIfExists('favorites');
    }
}
