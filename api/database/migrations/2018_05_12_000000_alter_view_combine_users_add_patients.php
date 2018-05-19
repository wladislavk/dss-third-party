<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AlterViewCombineUsersAddPatients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER VIEW v_users AS
                SELECT
                    CONCAT('u_', u.userid) COLLATE utf8_unicode_ci AS id,
                    u.userid,
                    0 AS adminid,
                    0 AS patientid,
                    0 AS admin,
                    0 AS patient,
                    IF(u.docid, u.docid, u.userid) AS docid,
                    0 AS parent_patientid,
                    user_type,
                    email,
                    IF(name IS NULL, CONCAT(first_name, ' ', last_name), name) AS name,
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
                    0 AS userid,
                    a.adminid,
                    0 AS patientid,
                    1 AS admin,
                    0 AS patient,
                    0 AS docid,
                    0 AS parent_patientid,
                    0 AS user_type,
                    email,
                    IF(name IS NULL, CONCAT(first_name, ' ', last_name), name) AS name,
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
            UNION
                SELECT
                    CONCAT('p_', p.patientid) COLLATE utf8_unicode_ci AS id,
                    0 AS userid,
                    0 AS adminid,
                    p.patientid AS patientid,
                    0 AS admin,
                    1 AS patient,
                    IF(p.docid, p.docid, pp.docid) AS docid,
                    p.parent_patientid,
                    0 AS user_type,
                    p.email AS email,
                    CONCAT(p.firstname, ' ', p.lastname) AS name,
                    p.firstname,
                    p.lastname,
                    p.email AS username,
                    p.password,
                    p.salt,
                    p.status,
                    p.ip_address,
                    0 AS access,
                    0 AS companyid,
                    p.adddate
                FROM dental_patients p
                LEFT JOIN dental_patients pp
                    ON pp.patientid = p.parent_patientid
        ");
    }

    public function down()
    {
        DB::unprepared("ALTER VIEW v_users AS
                SELECT
                    CONCAT('u_', u.userid) COLLATE utf8_unicode_ci AS id,
                    u.userid,
                    0 AS adminid,
                    0 AS admin,
                    IF(u.docid, u.docid, u.userid) AS docid,
                    user_type,
                    email,
                    IF(name IS NULL, CONCAT(first_name, ' ', last_name), name) AS name,
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
                    0 AS userid,
                    a.adminid,
                    1 AS admin,
                    0 AS docid,
                    0 AS user_type,
                    email,
                    IF(name IS NULL, CONCAT(first_name, ' ', last_name), name) AS name,
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
