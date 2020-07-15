<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceReportComponentsTable extends Migration
{
    private $types;

    public function __construct() {
        $this->types = \App\Models\StationComponent::types();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('service_scopes'))
        {
            Schema::create('service_scopes', function (Blueprint $table) {
                $table->smallIncrements('id');
                $table->string('description', 100);
            });
        }

        foreach ($this->types as $key => $value) {
            $tableName = $key . 's_service_reports';

            if (!Schema::hasTable($tableName)) {
                Schema::create($tableName, function (Blueprint $table) use (&$key) {
                    $table->unsignedBigInteger('component_id');
                    $table->uuid('service_report_id');
                    $table->unsignedSmallInteger('scope_id');
    
                    $table->foreign('scope_id')->references('id')->on('service_scopes')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
    
                    if ($key === 'compressor') {
                        $table->unsignedMediumInteger('hours_running');
                        $table->unsignedMediumInteger('hours_loaded');
                    }
                    
                    $table->foreign('component_id')->references('id')->on($key . 's')
                        ->onUpdate('cascade')
                        ->onDelete('cascade');
                    $table->foreign('service_report_id')->references('id')->on('service_reports')
                        ->onUpdate('cascade')
                        ->onDelete('cascade');
    
                    $table->unique(['component_id', 'service_report_id'], 'ix_component_report_unique');
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

        foreach ($this->types as $key => $value) {
            $tableName = $key . 's_service_reports';
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use (&$key) {
                    $table->dropForeign($key . 's_service_reports_service_scope_id_foreign');
                });
            }

            Schema::dropIfExists($key . 's_service_reports');
        }

        Schema::dropIfExists('service_scopes');
    }
}
