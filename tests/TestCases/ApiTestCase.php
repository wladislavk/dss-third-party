<?php
namespace Tests\TestCases;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ApiTestCase extends BaseApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;
}
