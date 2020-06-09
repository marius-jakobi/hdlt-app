<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAdDryerModelToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_dryers', function (Blueprint $table) {
            $table->string('model')->change();
        });
        Schema::table('adsorbers', function (Blueprint $table) {
            $table->string('model')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_dryers', function (Blueprint $table) {
            $table->smallInteger('model')->change();
        });
        Schema::table('adsorbers', function (Blueprint $table) {
            $table->smallInteger('model')->change();
        });
    }
}
