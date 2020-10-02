<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_address_id')->references('id')->on('shipping_addresses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('offer_id', 12);
            $table->date('follow_up');
            $table->string('contact_name', 64);
            $table->string('contact_phone', 64);
            $table->string('contact_mail', 64);
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
        Schema::dropIfExists('offer_service');
    }
}
