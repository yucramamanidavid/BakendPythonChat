<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear Superadmin principal (con Telegram ID real)
        User::updateOrCreate(
            ['email' => 'superadmin@upeu.edu.pe'],
            [
                'name' => 'David Yucra Mamani',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
                'telegram_id' => '1565329591' // Reemplaza por tu verdadero telegram_id
            ]
        );

        // Crear Admin
        User::updateOrCreate(
            ['email' => 'admin@upeu.edu.pe'],
            [
                'name' => 'Admin Principal',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'telegram_id' => '810538888' // Cambia si tienes otro ID
            ]
        );

        // Crear Subadmin
        User::updateOrCreate(
            ['email' => 'subadmin@upeu.edu.pe'],
            [
                'name' => 'Subadmin Secundario',
                'password' => Hash::make('subadmin123'),
                'role' => 'subadmin',
                'telegram_id' => '810537777' // Otro ID si lo deseas
            ]
        );
    }
}
