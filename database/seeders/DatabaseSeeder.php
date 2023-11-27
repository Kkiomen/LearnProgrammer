<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ClientSeeder::class);
        $this->call(ComboOrderSeeder::class);
//        $this->call(AssistantSeeder::class);
//        $this->call(LongTermMemorySeeder::class);
//        $this->call(LongTermMemorySeeder::class);
    }
}
