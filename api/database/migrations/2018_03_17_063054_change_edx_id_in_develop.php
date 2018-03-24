<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEdxIdInDevelop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') == 'production') {
            return;
        }
        DB::update("UPDATE dental_users SET edx_id = 3 WHERE userid = 1");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('APP_ENV') == 'production') {
            return;
        }
        DB::update("UPDATE dental_users SET edx_id = 354 WHERE userid = 1");
    }
}
