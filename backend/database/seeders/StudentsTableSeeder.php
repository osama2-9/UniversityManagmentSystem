<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();


        foreach (range(1, 100) as $index) {
            DB::table('students')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'student_password' => bcrypt('pass'),
                'phone' => $faker->unique()->phoneNumber,
                'gender' => $faker->randomElement(['male', 'female']),
                'semester' => $faker->randomElement(['2024', '2023', '2022']),
                'department_id' => $faker->numberBetween(1, 4),
                'major' => $faker->randomElement(['Software Engineering', 'Computer Science', 'Fine Arts', 'Marketing']),
                'balance' => $faker->randomFloat(2, 0, 800),
                'date_of_birth' => $faker->date('Y-m-d', '2005-12-31'),
                'studant_address' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
                'student_code' => strtoupper($faker->unique()->bothify('??###')),
            ]);
        }
    }
}
