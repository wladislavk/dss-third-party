<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewsCombineUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('drop view if exists v_users');

        DB::unprepared(
            "create view v_users as ".
            // dental_users table
            "select concat('u_', userid) as id, email, if(name is null, concat(first_name,' ', last_name), name) as name, first_name, last_name, username, password, salt, status, ip_address, user_access as access, adddate from dental_users ".
            "union ".
            // admin table
            "select concat('a_', adminid) as id, email, if(name is null, concat(first_name,' ', last_name), name) as name, first_name, last_name, username, password, salt, status, ip_address, admin_access access, adddate from admin"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view v_users');
    }
}
