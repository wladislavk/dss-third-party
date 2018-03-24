<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCompanyLogo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update("UPDATE companies SET logo = 'company_logo_3.png' WHERE id = 3");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update("UPDATE companies SET logo = 'company_logo_3.' WHERE id = 3");
    }
}
