<?php

namespace Database\Seeders;

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
        \App\Models\Product::insert([
            [
                'name' => 'Everyday Backpack',
                'slug' => 'everyday-backpack',
                'description' => 'A durable backpack for work, travel, and daily essentials.',
                'price' => 45.00,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Minimal Desk Lamp',
                'slug' => 'minimal-desk-lamp',
                'description' => 'Warm, adjustable lighting for focused workspaces.',
                'price' => 32.50,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ceramic Coffee Set',
                'slug' => 'ceramic-coffee-set',
                'description' => 'A simple two-cup ceramic set for slow mornings.',
                'price' => 24.00,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
