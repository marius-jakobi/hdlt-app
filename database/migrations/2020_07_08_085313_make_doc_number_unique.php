<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeDocNumberUnique extends Migration
{
    protected string $indexName = 'order_confirmations_document_number_unique';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_confirmations', function (Blueprint $table) {
            $table->string('document_number', 10)
                ->unique($this->indexName)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_confirmations', function (Blueprint $table) {
            $table->dropIndex($this->indexName);
        });
    }
}
