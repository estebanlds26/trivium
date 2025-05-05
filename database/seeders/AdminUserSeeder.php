<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $email    = config('admin.email');
        $password = config('admin.password');
        $user = config('admin.user');
        $cellphone = config('admin.cellphone');

        if (! User::where('email', $email)->exists()) {
            User::create([
                'username'     => $user,
                'name'     => 'Admin del sitio',
                'email'    => $email,
                'cellphone'    => $cellphone,
                'password' => Hash::make($password),
                'rol_id'     => 1,
            ]);
        }
    }
}