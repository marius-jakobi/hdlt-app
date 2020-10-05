<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalesAgentIdToServiceOfferTable extends Migration
{
    private $indexName = 'offer_service_sales_agent_id_foreign';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_offers', function (Blueprint $table) {
            $table->string('sales_agent_id', 5)->after('shipping_address_id');

            $table->foreign('sales_agent_id', $this->indexName)->references('id')->on('sales_agents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
            $table->dropIndex($this->indexName);
            $table->dropColumn('sales_agent_id');
        });
    }
}
