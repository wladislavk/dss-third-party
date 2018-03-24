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

        DB::unprepared("create view v_users as "
            // dental_users table
            . "select
                concat('u_', u.userid) COLLATE utf8_unicode_ci as id,
                email,
                if(name is null, concat(first_name,' ', last_name), name) as name,
                first_name,
                last_name,
                username,
                password,
                salt,
                status,
                u.ip_address,
                user_access as access,
                uc.companyid as companyid,
                u.adddate
            from dental_users u
            left join dental_user_company uc
                ON uc.userid = (
                    case docid
                        when 0 then u.userid
                        else docid
                end)"
            . " union "
            // admin table
            . "select
                concat('a_', a.adminid) COLLATE utf8_unicode_ci as id,
                email,
                if(name is null, concat(first_name,' ', last_name), name) as name,
                first_name,
                last_name,
                username,
                password,
                salt,
                status,
                a.ip_address,
                admin_access access,
                    ac.companyid as companyid,
                    a.adddate
            from admin a
            left join admin_company ac
                ON a.adminid = ac.adminid
        ");
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
