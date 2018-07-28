<?php
namespace Tests;

class IndexTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->call('GET', '/');
        $this->assertRedirectedTo('/manage/login');
    }
}
