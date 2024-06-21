<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();

        // User::factory()->create([
        //     'name' => 'Osvaldo Laini',
        //     'panel_user' => 'super_admin',
        //     'email' => 'laini@test.com',
        //     'password' => Hash::make('123456789'),
        //     'active' => true
        // ]);
        $this->call(ConfigSeeder::class);
    }
}
