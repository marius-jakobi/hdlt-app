<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactDataToSalesAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_agents', function (Blueprint $table) {
            $table->string('mail');
            $table->string('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_agents', function (Blueprint $table) {
            $table->dropColumn('mail');
            $table->dropColumn('phone');
        });
    }
}
