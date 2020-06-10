<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNextServiceAndMemoNullable extends Migration
{

    private $tables = [
        'compressors',
        'receivers',
        'filters',
        'ref_dryers',
        'ad_dryers',
        'adsorbers',
        'separators',
        'sensors',
        'controllers',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasColumn($tableName, 'next_service')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->date('next_service')->nullable()->change();
                });
            }

            if (Schema::hasColumn($tableName, 'memo')) {
                Schema::table($tableName, function(Blueprint $table) {
                    $table->string('memo')->nullable()->change();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasColumn($tableName, 'next_service')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->date('next_service')->change();
                });
            }

            if (Schema::hasColumn($tableName, 'memo')) {
                Schema::table($tableName, function(Blueprint $table) {
                    $table->string('memo')->change();
                });
            }
        }
    }
}
