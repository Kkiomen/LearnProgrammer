<?php

namespace Database\Seeders;

use App\Models\Assistant;
use Illuminate\Database\Seeder;

class AssistantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assistant::factory()->count(1)->create();
    }
}
