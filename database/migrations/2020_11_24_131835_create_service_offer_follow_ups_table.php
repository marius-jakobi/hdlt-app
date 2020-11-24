<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOfferFollowUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_offer_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_offer_id')->references('id')->on('service_offers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('follow_up');
            $table->text('text');
            $table->dateTime('created_at')->useCurrent();
        });

        Schema::table('service_offers', function (Blueprint $table) {
            $table->dropColumn('follow_up');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_offer_follow_ups');
        Schema::table('service_offers', function (Blueprint $table) {
            $table->date('follow_up')->after('offer_id');
        });
    }
}
