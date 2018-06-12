<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDentalDevicesAndCompaniesLogos extends Migration
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
        DB::update("UPDATE companies SET logo = 'resources/company_logo_5.jpg' WHERE id = 5");
        DB::update("UPDATE companies SET logo = 'resources/company_logo_3.png' WHERE id = 3");
        DB::update("UPDATE dental_device SET image_path = 'resources/dental_device_1.jpg' WHERE deviceid = 1");
        DB::update("UPDATE dental_device SET image_path = 'resources/dental_device_2.jpg' WHERE deviceid = 2");
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
        DB::update("UPDATE companies SET logo = 'company_logo_5.jpg' WHERE id = 5");
        DB::update("UPDATE companies SET logo = 'company_logo_3.png' WHERE id = 3");
        DB::update("UPDATE dental_device SET image_path = 'dental_device_1.jpg' WHERE deviceid = 1");
        DB::update("UPDATE dental_device SET image_path = 'dental_device_2.jpg' WHERE deviceid = 2");
    }
}
