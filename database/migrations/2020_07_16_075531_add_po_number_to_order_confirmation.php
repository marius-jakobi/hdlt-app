<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPoNumberToOrderConfirmation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_confirmations', function (Blueprint $table) {
            $table->string('po_number', 100)->nullable()->after('sales_process_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_confirmations', function (Blueprint $table) {
            $table->dropColumn('po_number');
        });
    }
}
