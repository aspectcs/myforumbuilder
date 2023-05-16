<?php

namespace Aspectcs\MyForumBuilder\Database\Seeders;

use Aspectcs\MyForumBuilder\Enums\ClientUserType;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Aspectcs\MyForumBuilder\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;


class FakeClientSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $today = Carbon::now();

        $clientCount = ClientUser::count();
        $questionCount = Question::count();
        $maxCreation = $questionCount * 5;

        if ($questionCount <= 0 && $clientCount < 500) {
            $count = rand(100, 500);
        } else if ($clientCount > 500 && $questionCount <= 0) {
            return;
        } else {
            $count = rand($questionCount, $maxCreation);
        }

        if ($clientCount >= $maxCreation && $questionCount > 0) {
            return;
        }

        for ($i = 0; $i <= $count; $i++) {
            $forumStartDate = env('FORUM_START_DATE', null);
            $carbon = Carbon::parse($forumStartDate);

            $faker = \Faker\Factory::create('en_US');

            $fakeUserName = $faker->unique()->userName();
            while ($isUserNameExist = ClientUser::where('username', 'LIKE', $fakeUserName)->exists()) {
                $fakeUserName = $faker->unique()->userName();
            }

            $fakeEmail = $faker->unique()->safeEmail();
            while ($isEmailExist = ClientUser::where('email', 'LIKE', $fakeEmail)->exists()) {
                $fakeEmail = $faker->unique()->safeEmail();
            }

            $data = [
                'email' => $fakeEmail,
                'username' => $fakeUserName,
                'city' => $faker->city(),
                'state' => $faker->state(),
                'country' => 'United States',
                'type' => ClientUserType::FAKE,
                'created_at' => $carbon->addDays(rand(1, 90))->addSeconds(rand(0, 86400)),
                'updated_at' => $carbon->addDays(rand(1, 90))->addSeconds(rand(0, 86400)),
            ];

            ClientUser::firstOrCreate([
                'email' => $data['email'],
                'username' => $data['username'],
            ], $data);
        }
    }
}
