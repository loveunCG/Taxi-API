<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletPassbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_passbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('amount');
            $table->enum('status', [
                    'CREDITED',
                    'DEBITED',
                ]);
            $table->string('via')->nullable();
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
        Schema::dropIfExists('wallet_passbooks');
    }
}
