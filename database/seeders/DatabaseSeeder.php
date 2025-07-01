<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'role' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
        ]);
        // tipos de eventos
        \App\Models\EventType::create(['id' => 1, 'name' => 'Cumpleaños de 15']);
        \App\Models\EventType::create(['id' => 2, 'name' => 'Casamientos']);
        \App\Models\EventType::create(['id' => 3, 'name' => 'Fiestas']);
        \App\Models\EventType::create(['id' => 4, 'name' => 'Eventos']);
        \App\Models\EventType::create(['id' => 5, 'name' => 'Otros']);

        User::factory(10)->create();

        $this->call(ProductSeeder::class);
    }
}