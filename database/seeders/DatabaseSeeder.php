<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Pasien',
                'email' =>'pasien@gmail.com',
                'role' => '0',
                'password' => bcrypt('pasien123'),
            ],
            [
                'name' => 'Admin',
                'email' =>'admin@gmail.com',
                'role' => '1',
                'password' => bcrypt('admin123'),
            ],
            [
                'name' => 'Pakar',
                'email' =>'pakar@gmail.com',
                'role' => '2',
                'password' => bcrypt('pakar123'),
            ],
        ];
        foreach($users as $key => $user) {
            User::create($user);
        }

        $this->call([
            DiagnosaSeeder::class,
        ]);
    }
}
