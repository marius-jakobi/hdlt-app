<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsorbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adsorbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_address_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('brand_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->smallInteger('model');
            $table->decimal('volume', 6, 2, true)->nullable();
            $table->string('serial')->nullable();
            $table->decimal('pressure', 6, 2, true)->nullable();
            $table->year('year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('next_service');
            $table->text('memo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adsorbers');
    }
}
