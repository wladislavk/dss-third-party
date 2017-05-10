<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterViewCombineUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add admin flag
        DB::unprepared("ALTER VIEW v_users AS
                SELECT
                    CONCAT('u_', u.userid) COLLATE utf8_unicode_ci AS id,
                    0 AS admin,
                    email,
                    IF(name IS NULL, CONCAT(first_name,' ', last_name), name) AS name,
                    first_name,
                    last_name,
                    username,
                    password,
                    salt,
                    status,
                    u.ip_address,
                    user_access AS access,
                    uc.companyid AS companyid,
                    u.adddate
                FROM dental_users u
                LEFT JOIN dental_user_company uc
                    ON uc.userid = (
                        CASE docid
                            WHEN 0 THEN u.userid
                            ELSE docid
                        END
                    )
            UNION
                SELECT
                    CONCAT('a_', a.adminid) COLLATE utf8_unicode_ci AS id,
                    1 AS admin,
                    email,
                    IF(name IS NULL, CONCAT(first_name,' ', last_name), name) AS name,
                    first_name,
                    last_name,
                    username,
                    password,
                    salt,
                    status,
                    a.ip_address,
                    admin_access access,
                    ac.companyid AS companyid,
                    a.adddate
                FROM admin a
                LEFT JOIN admin_company ac
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
        // Remove admin flag
        DB::unprepared("ALTER VIEW v_users AS
                SELECT
                    CONCAT('u_', u.userid) COLLATE utf8_unicode_ci AS id,
                    email,
                    IF(name IS NULL, CONCAT(first_name,' ', last_name), name) AS name,
                    first_name,
                    last_name,
                    username,
                    password,
                    salt,
                    status,
                    u.ip_address,
                    user_access AS access,
                    uc.companyid AS companyid,
                    u.adddate
                FROM dental_users u
                LEFT JOIN dental_user_company uc
                    ON uc.userid = (
                        CASE docid
                            WHEN 0 THEN u.userid
                            ELSE docid
                        END
                    )
            UNION
                SELECT
                    CONCAT('a_', a.adminid) COLLATE utf8_unicode_ci AS id,
                    email,
                    IF(name IS NULL, CONCAT(first_name,' ', last_name), name) AS name,
                    first_name,
                    last_name,
                    username,
                    password,
                    salt,
                    status,
                    a.ip_address,
                    admin_access access,
                    ac.companyid AS companyid,
                    a.adddate
                FROM admin a
                LEFT JOIN admin_company ac
                    ON a.adminid = ac.adminid
        ");
    }
}
