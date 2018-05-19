<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalApiPermissionTables extends Migration
{
    public function up () {
        Schema::create('dental_api_permission_resource_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->tinyInteger('authorize_per_user');
            $table->tinyInteger('authorize_per_patient');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::table('dental_api_permission_resource_groups', function (Blueprint $table) {
            $table->unique('slug');
            $table->index('created_by');
            $table->index('updated_by');
        });

        Schema::create('dental_api_permission_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->string('slug');
            $table->string('route');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::table('dental_api_permission_resources', function (Blueprint $table) {
            $table->foreign('group_id')
                ->references('id')
                ->on('dental_api_permission_resource_groups')
            ;
            $table->unique('slug');
            $table->index('route');
            $table->index('created_by');
            $table->index('updated_by');
        });

        Schema::create('dental_api_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->integer('doc_id');
            $table->integer('patient_id');
            $table->timestamps();
        });

        Schema::table('dental_api_permissions', function (Blueprint $table) {
            $table->foreign('group_id')
                ->references('id')
                ->on('dental_api_permission_resource_groups')
            ;
            $table->index('doc_id');
            $table->index('patient_id');
        });
    }

    public function down () {
        Schema::drop('dental_api_permissions');
        Schema::drop('dental_api_permission_resources');
        Schema::drop('dental_api_permission_resource_groups');
    }
}
