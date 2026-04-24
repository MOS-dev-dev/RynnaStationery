<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!\App\Models\User::where('email', 'admin@rynna.com')->exists()) {
            \App\Models\User::create([
                'name' => 'Admin Rynna',
                'email' => 'admin@rynna.com',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
            ]);
        }

        $this->call([
            CategoryProductSeeder::class,
            ProductDemoSeeder::class,
            VoucherSeeder::class,
        ]);
    }
}
