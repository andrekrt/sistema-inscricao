<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'email' => 'andrekrt1922@gmail.com',
                'name' => 'André Santos',
                'password' => bcrypt('andre123'),
            ],
            [
                'email' => 'kaiokaratetradicional@hotmail.com',
                'name' => 'Kaio',
                'password' => bcrypt('kaio1234'),
            ]
        ];


        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
