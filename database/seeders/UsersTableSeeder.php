<?php

namespace Database\Seeders;

use App\Models\Retailer;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run ()
    {
        User::factory()->create(['email' => 'paulo@dev.com.br']);
        Retailer::factory()->create(['email' => 'henrique@dev.com.br']);
    }
}