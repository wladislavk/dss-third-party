<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class SessionTest extends TestCase
{
    use WithoutMiddleware;

    public function testSessionGetter()
    {
        $data = ['pi', 'test'];

        $this->post('session/get', $data)
            ->assertResponseOk()
            ->seeJsonContains([
                'pi'   => 3.14,
                'test' => 'test message'
            ]);
    }

    public function testSessionSetter()
    {
        $data = [
            'pi'   => 3.14,
            'test' => 'test message'
        ];

        dd($this->post('session/set', $data));

        $this->post('session/set', $data)
            ->assertResponseOk()
            ->assertSessionHas('pi', 3.14)
            ->assertSessionHas('test');
    }
}