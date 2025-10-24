<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'fullname' => 'Admin',
            'email' => 'admin@example.com',
            'password_hash' => 'admin12345', // sẽ tự băm
            'role' => 'admin',
            'phone' => '0900000000',
            'address' => 'HN',
        ]);
    }
}
