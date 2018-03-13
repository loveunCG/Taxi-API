<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('provider_id')->default(0);
            $table->integer('current_provider_id');
            $table->integer('service_type_id');
            
            $table->enum('status', [
                    'SEARCHING',
                    'CANCELLED',
                    'ACCEPTED', 
                    'STARTED',
                    'ARRIVED',
                    'PICKEDUP',
                    'DROPPED',
                    'COMPLETED',
                    'SCHEDULED',
                ]);

            $table->enum('cancelled_by', [
                    'NONE',
                    'USER',
                    'PROVIDER'
                ]);

            $table->enum('payment_mode', [
                    'CASH',
                    'CARD',
                    'PAYPAL'
                ]);
            
            $table->boolean('paid')->default(0);

            $table->double('distance', 15, 8);
            
            $table->string('s_address')->nullable();
            $table->double('s_latitude', 15, 8);
            $table->double('s_longitude', 15, 8);
            
            $table->string('d_address')->nullable();
            $table->double('d_latitude', 15, 8);
            $table->double('d_longitude', 15, 8);
            
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('schedule_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            
            $table->boolean('user_rated')->default(0);
            $table->boolean('provider_rated')->default(0);
            $table->boolean('use_wallet')->default(0);
            $table->boolean('surge')->default(0);
            $table->longText('route_key');

            $table->softDeletes();
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
        Schema::dropIfExists('user_requests');
    }
}
