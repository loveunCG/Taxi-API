<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromocodePassbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocode_passbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('promocode_id');
            $table->enum('status', ['ADDED', 'USED','EXPIRED']);
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
        Schema::dropIfExists('promocode_passbooks');
    }
}
