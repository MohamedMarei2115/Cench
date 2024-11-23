<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' =>Hash::make('123456'),
            'email_verified_at' => date('Y-m-d H:i:s'),
            'country' => 'Egypt',
            'gender' => 'male',
            'role_id' => 0
        ]);
//        $this->call(showTimeSeeder::class);
//        $this->call(MovieSeeder::class);
    }
}
