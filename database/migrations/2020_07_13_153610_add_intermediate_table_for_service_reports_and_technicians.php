<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntermediateTableForServiceReportsAndTechnicians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_report_technicians', function (Blueprint $table) {
            $table->uuid('service_report_id');
            $table->unsignedBigInteger('technician_id');

            $table->foreign('service_report_id')->references('id')->on('service_reports')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('technician_id')->references('id')->on('technicians')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->float('work_time', 6, 2, true);

            $table->unique(['service_report_id', 'technician_id'], 'report_technician_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_report_technicians');
    }
}
