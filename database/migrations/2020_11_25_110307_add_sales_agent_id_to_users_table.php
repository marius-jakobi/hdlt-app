<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalesAgentIdToUsersTable extends Migration
{
    private $columnName = 'sales_agent_id';
    private $indexName = 'fk_users_sales_agent_id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string($this->columnName, 5)->after('password')->nullable();
            $table->foreign($this->columnName, $this->indexName)->references('id')->on('sales_agents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex($this->indexName);
            $table->dropColumn($this->columnName);
        });
    }
}
