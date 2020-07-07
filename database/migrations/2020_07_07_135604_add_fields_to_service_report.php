<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToServiceReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_reports', function (Blueprint $table) {
            $table->string('intent', 128)->after('order_confirmation_id');
            $table->text('text')->after('intent');
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
            $table->dropColumn('intent');
            $table->dropColumn('text');
        });
    }
}
