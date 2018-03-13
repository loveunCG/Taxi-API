<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomPushesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_pushes', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('send_to', ['ALL', 'USERS', 'PROVIDERS']);
            $table->enum('condition', ['ACTIVE', 'LOCATION', 'RIDES', 'AMOUNT']);
            $table->string('condition_data')->nullable();
            $table->string('message')->nullable();
            $table->integer('sent_to')->default(0);
            $table->timestamp('schedule_at')->nullable();
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
        Schema::dropIfExists('custom_pushes');
    }
}
