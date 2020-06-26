<?php

use App\Models\StationComponent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentUploadFileTable extends Migration
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
            Schema::create($type . '_upload_files', function (Blueprint $table) use(&$type) {
                $table->id();
                $table->foreignId('component_id')->references('id')->on($type . 's')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->string('path');
                $table->string('name');
                $table->timestamps(); 
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
            Schema::dropIfExists($type . '_upload_files');
        }
    }
}
