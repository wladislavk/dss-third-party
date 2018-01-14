<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogoToHst extends Migration
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
        DB::update("UPDATE companies SET logo = 'company_logo_5.jpg' WHERE id = 5");
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
        DB::update("UPDATE companies SET logo = '' WHERE id = 5");
    }
}
