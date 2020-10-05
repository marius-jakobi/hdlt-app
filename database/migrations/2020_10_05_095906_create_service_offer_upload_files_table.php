<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOfferUploadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_offer_upload_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_offer_id')->references('id')->on('service_offers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('fileId');
            $table->string('extension', 4);
            $table->string('name');
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
        Schema::dropIfExists('service_offer_upload_files');
    }
}
