<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingAddressToServiceReports extends Migration
{
    protected $indexName = 'service_reports_shipping_address_id_foreign';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('shipping_address_id')
                ->nullable()
                ->after('order_confirmation_id');

            $table->foreign('shipping_address_id', $this->indexName)->references('id')->on('shipping_addresses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_reports', function (Blueprint $table) {
            $table->dropForeign($this->indexName);
            $table->dropColumn('shipping_address_id');
        });
    }
}
