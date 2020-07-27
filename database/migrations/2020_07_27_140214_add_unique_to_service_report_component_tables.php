<?php

use App\Models\StationComponent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueToServiceReportComponentTables extends Migration
{
    protected $types;

    public function __construct() {
        $this->types = array_keys(StationComponent::types());
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->types as $type) {
            Schema::table($type . 's_service_reports', function (Blueprint $table) use (&$type) {
                $table->unique(['component_id', 'service_report_id'], $type . '_service_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach($this->types as $type) {
            Schema::table($type . 's_service_reports', function (Blueprint $table) use (&$type)  {
                $table->dropUnique($type . '_service_unique');
            });
        }
    }
}
