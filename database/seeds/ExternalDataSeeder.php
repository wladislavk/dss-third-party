<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExternalDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $externalCompanyId = DB::table('dental_external_companies')->insertGetId([
            'software' => 'dentrix',
            'api_key' => 'dentrixapikey',
            'valid_from' => Carbon::now(),
            'valid_to' => Carbon::parse('next year'),
            'name' => 'Dentrix Software for Import and Export of Patient Data, Inc.',
            'short_name' => 'Dentrix Co.',
            'url' => 'https://dentrix.com/',
            'description' => 'Dentrix Co, first app to have access to the external patient endpoint in DS3.',
            'status' => 1,
            'reason' => '',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('dental_external_users')->insert([
            'user_id' => 1,
            'api_key' => 'user1apikey',
            'valid_from' => Carbon::now(),
            'valid_to' => Carbon::parse('next year'),
            'created_by' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('dental_external_company_user')->insert([
            'user_id' => 1,
            'company_id' => $externalCompanyId,
            'created_by' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
