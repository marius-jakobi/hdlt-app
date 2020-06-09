<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeModelFieldsToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('separators', function (Blueprint $table) {
            $table->string('model')->change();
        });
        Schema::table('controllers', function (Blueprint $table) {
            $table->string('model')->change();
        });
        Schema::table('sensors', function (Blueprint $table) {
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
        Schema::table('separators', function (Blueprint $table) {
            $table->smallInteger('model')->change();
        });
        Schema::table('controllers', function (Blueprint $table) {
            $table->smallInteger('model')->change();
        });
        Schema::table('sensors', function (Blueprint $table) {
            $table->smallInteger('model')->change();
        });
    }
}
