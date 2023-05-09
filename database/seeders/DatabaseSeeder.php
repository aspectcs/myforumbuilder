<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Aspectcs\MyForumBuilder\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        /*$users = [
            [
                'name' => 'Nikhil Doda',
                'email' => 'nikhild@aspectcs.com',
                'password' => Hash::make('admin@2023'),
                'is_admin' => true
            ],
            [
                'name' => 'Pratik Jain',
                'email' => 'pratikj@aspectcs.com',
                'password' => Hash::make('admin@2023'),
                'is_admin' => true
            ]
        ];
        foreach ($users as $user) {
            if (User::where('email', $user['email'])->doesntExist())
                User::create($user);
        }*/

    }
}
