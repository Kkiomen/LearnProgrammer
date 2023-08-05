<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jakub Owsianka',
            'email' => 'kurytplagain@gmail.com',
            'password' => Hash::make('kurytplagain@gmail.com'),
            'open_ai_key' => 'fdsfdsfdsf'
        ]);
        User::factory()->count(5)->create();

    }
}
