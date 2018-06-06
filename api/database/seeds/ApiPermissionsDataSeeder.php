<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ApiPermissionsDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminId = 0;
        $admins = DB::select('SELECT adminid
            FROM admin
            WHERE admin_access = 1
                AND status = 1
            ORDER BY adminid ASC
            LIMIT 1
        ');

        if (!empty($admins[0])) {
            $adminId = $admins[0]->adminid;
        }

        $advancedPainGroupId = DB::table('dental_api_permission_resource_groups')->insertGetId([
            'slug' => 'advanced-pain-tmd',
            'name' => 'Adv. Pain/TMD',
            'authorize_per_user' => 1,
            'authorize_per_patient' => 1,
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $emAssessmentGroupId = DB::table('dental_api_permission_resource_groups')->insertGetId([
            'slug' => 'em-assessment-plan',
            'name' => 'E/M Exam & Assessment Plan',
            'authorize_per_user' => 1,
            'authorize_per_patient' => 0,
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $painTmdGroupId = DB::table('dental_api_permission_resource_groups')->insertGetId([
            'slug' => 'pain-tmd-symptoms',
            'name' => 'Pain/TMD Symptoms',
            'authorize_per_user' => 1,
            'authorize_per_patient' => 0,
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $soapNotesId = DB::table('dental_api_permission_resource_groups')->insertGetId([
            'slug' => 'soap-notes',
            'name' => 'SOAP Notes',
            'authorize_per_user' => 1,
            'authorize_per_patient' => 0,
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('dental_api_permission_resources')->insertGetId([
            'group_id' => $advancedPainGroupId,
            'slug' => 'ex_page9',
            'route' => 'api/v1/advanced-pain-tmd-exams',
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('dental_api_permission_resources')->insertGetId([
            'group_id' => $emAssessmentGroupId,
            'slug' => 'ex_page10',
            'route' => 'api/v1/evaluation-management-exams',
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('dental_api_permission_resources')->insertGetId([
            'group_id' => $emAssessmentGroupId,
            'slug' => 'ex_page11',
            'route' => 'api/v1/assessment-plan-exams',
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('dental_api_permission_resources')->insertGetId([
            'group_id' => $painTmdGroupId,
            'slug' => 'q_page5',
            'route' => 'api/v1/pain-tmd-exams',
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
