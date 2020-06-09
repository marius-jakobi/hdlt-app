<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefDryersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_dryers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_address_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('brand_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('model');
            $table->string('serial');
            $table->year('year')->nullable();
            $table->enum('ref_type', ['R134a', 'R404A', 'R407C', 'R410A', 'R452a', 'R22'])->nullable();
            $table->decimal('ref_amount', 6, 2, true)->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('next_service');
            $table->string('memo');
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
        Schema::dropIfExists('ref_dryers');
    }
}
