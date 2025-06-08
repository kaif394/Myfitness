<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate dependent tables first, then users, to avoid FK issues
        DB::statement('TRUNCATE TABLE profiles, subscriptions, user_branch, users RESTART IDENTITY CASCADE');

        $faker = \Faker\Factory::create();
        User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'is_admin' => true,
            'password' => bcrypt('password'),
            'account_number' => $faker->randomDigit(),
            'avatar' => $faker->imageUrl(50, 50, 'people')
        ]);

        User::factory(24)->create(['is_admin' => false]);
    }
}
