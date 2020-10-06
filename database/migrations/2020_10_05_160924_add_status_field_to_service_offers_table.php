<?php

use App\Models\Service\ServiceOfferStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldToServiceOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_offers', function (Blueprint $table) {
            $table->smallInteger('status')
                ->default(ServiceOfferStatus::OPEN)
                ->after('contact_mail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_offers', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
