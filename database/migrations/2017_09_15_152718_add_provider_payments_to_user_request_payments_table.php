<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProviderPaymentsToUserRequestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_request_payments', function (Blueprint $table) {
            $table->float('payable',8,2)->default(0)->after('total');
            $table->float('provider_commission',8,2)->default(0)->after('payable');
            $table->float('provider_pay',8,2)->default(0)->after('provider_commission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_request_payments', function (Blueprint $table) {
            $table->dropColumn('payable');
            $table->dropColumn('provider_commission');
            $table->dropColumn('provider_pay');
        });
    }
}
