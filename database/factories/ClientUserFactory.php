<?php

namespace Database\Factories;

use Aspectcs\MyForumBuilder\Enums\ClientUserType;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientUser>
 */
class ClientUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $forumStartDate = env('FORUM_START_DATE', null);
        $carbon = Carbon::parse($forumStartDate);
//        $today = Carbon::now();
        $faker = \Faker\Factory::create('en_US');

        $fakeUserName = $faker->unique()->userName();
        while ($isUserNameExist = ClientUser::where('username', 'LIKE', $fakeUserName)->exists()) {
            $fakeUserName = $faker->unique()->userName();
        }

        $fakeEmail = $faker->unique()->safeEmail();
        while ($isEmailExist = ClientUser::where('email', 'LIKE', $fakeEmail)->exists()) {
            $fakeEmail = $faker->unique()->safeEmail();
        }

        return [
            'email' => $fakeEmail,
            'username' => $fakeUserName,
            'city' => $faker->city(),
            'state' => $faker->state(),
            'country' => 'United States',
            'type' => ClientUserType::FAKE,
            'created_at' => $carbon->addDays(rand(1, 90))->addSeconds(rand(0, 86400)),
            'updated_at' => $carbon->addDays(rand(1, 90))->addSeconds(rand(0, 86400)),
        ];
    }

    public function verified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => now(),
        ]);
    }
}
