<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveHomepage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `dental_users` DROP `homepage`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `dental_users` ADD `homepage` tinyint(1) DEFAULT '0';");
        DB::unprepared("ALTER TABLE `dental_users` ADD KEY `homepage` (`homepage`);");
    }
}
