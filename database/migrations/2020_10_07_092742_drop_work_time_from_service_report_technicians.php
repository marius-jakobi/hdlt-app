<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropWorkTimeFromServiceReportTechnicians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_report_technicians', function (Blueprint $table) {
            $table->dropColumn('work_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_report_technicians', function (Blueprint $table) {
            $table->decimal('work_time', 8, 2, true)->after('technician_id');
        });
    }
}
