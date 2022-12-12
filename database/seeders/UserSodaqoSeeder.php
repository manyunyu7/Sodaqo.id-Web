<?php

namespace Database\Seeders;

use App\Models\UserSodaqo;
use Illuminate\Database\Seeder;
use Faker\Factory;
class UserSodaqoSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        foreach (range(1, 20) as $index) {
            $status = rand(0, 2);

            $nominalNet = null;
            $notesAdmin = null;

            $userId = rand(1, 19);
            if ($userId === 2) {
                $userId = 31;
            }
            if (rand(0, 1)) {
                $userId = 43;
            }

            if ($status !== 0) {
                $nominalNet = rand(10000, 600000);
                $nominalNet = 10000;
                $notesAdmin = $faker->sentence();
            }

            UserSodaqo::create([
                "sodaqo_id" => 5,
                "user_id" => $userId,
                "payment_id" => rand(1, 4),
                "photo" => $faker->imageUrl(),
//                "nominal" => rand(10000, 500000),
                "nominal" => 10000,
                "nominal_net" => $nominalNet,
                "is_anonym" => rand(0, 1) ? "0" : "1",
                "is_whatsapp_enabled" => rand(0, 1) ? "1" : "0",
                "doa" => $faker->sentence(),
                "notes_admin" => $notesAdmin,
                "status" => $status,
                "created_at" => $faker->dateTimeBetween('2020-01-01', '2021-12-31'),
                "updated_at" => $faker->dateTimeBetween('2020-01-01', '2021-12-31'),
            ]);
        }
    }
}
