<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(5)->create();

        DB::table('users')->insert([
            [
                'name' => 'Marcio',
                'email' => 'giordanigomes@gmail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('marcio'),
                'is_admin' => true,
                // 'is_expired_password' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Amanda',
                'email' => 'amanda@mail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('amanda'),
                'is_admin' => false,
                // 'is_expired_password' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Beatriz',
                'email' => 'beatriz@mail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('beatriz'),
                'is_admin' => false,
                // 'is_expired_password' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Carlos',
                'email' => 'carlos@mail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('carlos'),
                'is_admin' => false,
                // 'is_expired_password' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
