<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a specific, known visitor for easy testing and verification
        Visitor::create([
            'name' => 'Juan Dela Cruz',
            'address' => '123 Main St, Manila, Philippines',
            'position' => 'Regional Director',
        ]);

        // 2. Generate 50 random visitors using the VisitorFactory
        Visitor::factory()->count(50)->create();
    }
}