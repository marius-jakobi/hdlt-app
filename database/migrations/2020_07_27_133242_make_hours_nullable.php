<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeHoursNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compressors_service_reports', function (Blueprint $table) {
            $table->unsignedInteger('hours_running')->nullable()->change();
            $table->unsignedInteger('hours_loaded')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compressors_service_reports', function (Blueprint $table) {
            $table->unsignedInteger('hours_running')->change();
            $table->unsignedInteger('hours_loaded')->change();
        });
    }
}
