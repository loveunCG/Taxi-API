<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTravelTrackingDistanceToUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_requests', function (Blueprint $table) {
            $table->enum('is_track', ['YES','NO'])->default('NO')->after('paid');
            $table->double('track_distance', 15, 8)->default(0)->after('d_latitude');
            $table->double('track_latitude', 15, 8)->default(0)->after('track_distance');
            $table->double('track_longitude', 15, 8)->default(0)->after('track_latitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_requests', function (Blueprint $table) {
            $table->dropColumn('is_track');
            $table->dropColumn('track_distance');
            $table->dropColumn('track_latitude');
            $table->dropColumn('track_longitude');
        });
    }
}
