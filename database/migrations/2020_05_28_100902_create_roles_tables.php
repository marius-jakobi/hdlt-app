<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
        });

        // Create permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
        });

        // Relationship user to role
        Schema::create('users_roles', function(Blueprint $table) {
            $table->foreignId('user_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId(('role_id'))
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unique(['user_id', 'role_id']);
        });

        // Relationship role to permission
        Schema::create('roles_permissions', function(Blueprint $table) {
            $table->foreignId('role_id')    
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('permission_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unique(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('users_roles');
        Schema::dropIfExists('roles_permissions');
    }
}
