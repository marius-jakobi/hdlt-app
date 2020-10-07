<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TransformWorkTimeToStartAndEnd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update('UPDATE service_report_technicians SET time_start = 7.5, time_end = 7.5 + work_time;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_report_technicians', function (Blueprint $table) {
            DB::update('UPDATE service_report_technicians SET work_time = time_end - time_start;');
        });
    }
}
