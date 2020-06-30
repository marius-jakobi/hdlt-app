<?php

use App\Models\StationComponent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RestructureComponentUploadTables extends Migration
{
    protected array $types = [];

    public function __construct()
    {
        foreach (StationComponent::types() as $key => $value) {
            $this->types[] = $key;
        }
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $type) {
            Schema::table($type . '_upload_files', function (Blueprint $table) use(&$type) {
                $table->renameColumn('path', 'fileId');
                $table->string('extension', 4)->after('path');
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
        foreach ($this->types as $type) {
            Schema::table($type . 'upload_files', function (Blueprint $table) use(&$type) {
                $table->renameColumn('fileId', 'path');
                $table->dropColumn('extension');
            });
        }
    }
}
