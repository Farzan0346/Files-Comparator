<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin
        $testUser = User::firstOrCreate(
            [
                'email' => 'ismail@devop360.com',
            ],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => Hash::make('devop360')
            ]
        );
        // Create super admin
        $user = User::firstOrCreate(
            [
                'email' => 'muhammadabdullah.developer@gmail.com',
            ],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => Hash::make('devop360')
            ]
        );
        $userthree = User::firstOrCreate(
            [
                'email' => 'junaid@devop360.com',
            ],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => Hash::make('devop360')
            ]
        );

        # Asign Role & permissions
        $user->assignRole(RoleEnum::SUPERADMINISTRATOR->value);
        $testUser->assignRole(RoleEnum::SUPERADMINISTRATOR->value);
        $userthree->assignRole(RoleEnum::ADMINISTRATOR->value);

    }
}
