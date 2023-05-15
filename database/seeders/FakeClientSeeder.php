<?php

namespace Aspectcs\MyForumBuilder\Database\Seeders;

use Aspectcs\MyForumBuilder\Models\ClientUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       ClientUser::factory()->count(rand(500, 1000))->create();
    }
}
