<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id');
            $table->string('document_id');
            $table->string('url');
            $table->string('unique_id')->nullable();
            $table->enum('status', ['ASSESSING', 'ACTIVE']);
            $table->timestamp('expires_at')->nullable();
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
        Schema::dropIfExists('provider_documents');
    }
}
