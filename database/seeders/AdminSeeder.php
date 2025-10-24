<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Xóa admin cũ nếu có
        User::where('email', 'admin@jeans.com')->delete();
        
        // Tạo admin mới với password đã hash
        User::create([
            'full_name' => 'Administrator',
            'email' => 'admin@jeans.com',
            'password_hash' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '0123456789',
            'address' => 'Hà Nội, Việt Nam',
        ]);
        
        echo "Admin user created successfully!\n";
        echo "Email: admin@jeans.com\n";
        echo "Password: admin123\n";
    }
}
