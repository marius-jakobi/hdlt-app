<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LinkPaytermsAndSalesAgentToCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('payterms_id', 16)
                ->after('description');
            $table->string('sales_agent_id', 5)
                ->after('description');

            $table->foreign('payterms_id')
                ->references('id')
                ->on('payterms')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->after('description');
                
            $table->foreign('sales_agent_id')
                ->references('id')
                ->on('sales_agents')
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
        Schema::table('customers', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['payterms_id']);
            $table->dropForeign(['sales_agent_id']);
            $table->dropColumn('payterms_id');
            $table->dropColumn('sales_agent_id');
            Schema::enableForeignKeyConstraints();
        });
    }
}
