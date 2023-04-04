<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserSodaqo;
use Faker\Factory;
use Illuminate\Database\Seeder;

class RandomPeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('it_IT');


        for ($i = 1; $i <= 2000; $i++) {
            $name = $faker->name();
            $role = 'user';
            $contact = $faker->phoneNumber;
            $email = $faker->unique()->safeEmail;
            $photo = null;
            $password = bcrypt($faker->password);

            $user = new User();
            $user->name = $name;
            $user->role = $role;
            $user->contact = $contact;
            $user->email = $email;
            $user->photo = $photo;
            $user->password = $password;
            $user->save();
        }
    }

    function insertUser(
        $name, $role, $contact, $email, $photo, $password
    )
    {
        $user = new User();
        $user->name = $name;
        $user->role = $role;
        $user->contact = $contact;
        $user->email = $email;
        $user->photo = $photo;
        $user->password = $password;
        $user->save();
    }



}
