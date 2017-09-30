<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDentalUserBillingExclusiveTable extends Migration
{
    public function up()
    {
        Schema::create('dental_user_billing_exclusive', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->tinyInteger('exclusive');
        });

        Schema::table('dental_user_billing_exclusive', function (Blueprint $table) {
            $table->unique('user_id');
        });

        DB::insert("INSERT INTO dental_user_billing_exclusive (user_id, exclusive)
            SELECT user.userid, IFNULL(company.exclusive, 0)
            FROM dental_users user
                LEFT JOIN companies company ON company.id = user.billing_company_id
            WHERE user.docid > 0
        ");
    }

    public function down()
    {
        Schema::dropIfExists('dental_user_billing_exclusive');
    }
}
