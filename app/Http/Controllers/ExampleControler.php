<?php

namespace App\Http\Controllers;

use App\Models\User;

class ExampleControler extends Controller
{
    public function test()
    {
        User::factory()->create(['email' => 'paulo@dev.com.br']);
    }
}
