<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\TaskOrder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'username' => 'admin',
            'name' => 'Naufal',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);

        $teknisi = User::create([
            'username' => 'teknisi',
            'name' => 'Fadhil',
            'password' => Hash::make('12345'),
            'role' => 'teknisi',
        ]);
    }
}
