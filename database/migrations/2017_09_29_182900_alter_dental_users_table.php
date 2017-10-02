<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterDentalUsersTable extends Migration
{
    public function up()
    {
        Schema::create('dental_user_billing_exclusive', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->tinyInteger('exclusive');
        });

        Schema::table('dental_users', function (Blueprint $table) {
            $table->tinyInteger('is_billing_exclusive');
        });

        DB::update("UPDATE dental_users user
                LEFT JOIN companies company ON company.id = user.billing_company_id
            SET user.is_billing_exclusive = IFNULL(company.exclusive, 0)
            WHERE user.docid > 0
        ");
    }

    public function down()
    {
        Schema::table('dental_users', function (Blueprint $table) {
            $table->dropColumn('is_billing_exclusive');
        });
    }
}
