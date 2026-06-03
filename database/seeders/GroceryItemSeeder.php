<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroceryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add public catalog items (no user_id)
        $catalogItems = [
            // Vegetables
            ['title' => 'Fresh Carrots', 'quantity' => 1, 'unit' => 'kg', 'notes' => 'Organic carrots, orange color', 'status' => 'pending'],
            ['title' => 'Broccoli', 'quantity' => 1, 'unit' => 'bunch', 'notes' => 'Fresh green broccoli', 'status' => 'pending'],
            ['title' => 'Tomatoes', 'quantity' => 500, 'unit' => 'grams', 'notes' => 'Ripe red tomatoes', 'status' => 'pending'],
            ['title' => 'Spinach', 'quantity' => 250, 'unit' => 'grams', 'notes' => 'Fresh spinach leaves', 'status' => 'pending'],
            ['title' => 'Cucumbers', 'quantity' => 3, 'unit' => 'pieces', 'notes' => 'Crisp and fresh', 'status' => 'pending'],
            ['title' => 'Bell Peppers', 'quantity' => 3, 'unit' => 'pieces', 'notes' => 'Red, yellow, and green', 'status' => 'pending'],
            ['title' => 'Potatoes', 'quantity' => 2, 'unit' => 'kg', 'notes' => 'Russet potatoes', 'status' => 'pending'],
            ['title' => 'Onions', 'quantity' => 1, 'unit' => 'kg', 'notes' => 'Yellow onions', 'status' => 'pending'],
            ['title' => 'Garlic', 'quantity' => 100, 'unit' => 'grams', 'notes' => 'Fresh garlic bulbs', 'status' => 'pending'],
            ['title' => 'Lettuce', 'quantity' => 1, 'unit' => 'head', 'notes' => 'Crisp iceberg lettuce', 'status' => 'pending'],
            ['title' => 'Cabbage', 'quantity' => 1, 'unit' => 'head', 'notes' => 'Purple cabbage', 'status' => 'pending'],
            ['title' => 'Celery', 'quantity' => 1, 'unit' => 'bunch', 'notes' => 'Fresh celery stalks', 'status' => 'pending'],
            ['title' => 'Zucchini', 'quantity' => 500, 'unit' => 'grams', 'notes' => 'Green zucchini', 'status' => 'pending'],
            ['title' => 'Mushrooms', 'quantity' => 250, 'unit' => 'grams', 'notes' => 'Button mushrooms', 'status' => 'pending'],
            ['title' => 'Green Peas', 'quantity' => 300, 'unit' => 'grams', 'notes' => 'Fresh green peas', 'status' => 'pending'],
            
            // Fruits
            ['title' => 'Red Apples', 'quantity' => 6, 'unit' => 'pieces', 'notes' => 'Sweet red apples', 'status' => 'pending'],
            ['title' => 'Bananas', 'quantity' => 1, 'unit' => 'bunch', 'notes' => 'Golden yellow bananas', 'status' => 'pending'],
            ['title' => 'Fresh Oranges', 'quantity' => 1, 'unit' => 'kg', 'notes' => 'Fresh Valencia oranges', 'status' => 'pending'],
            ['title' => 'Strawberries', 'quantity' => 400, 'unit' => 'grams', 'notes' => 'Sweet red strawberries', 'status' => 'pending'],
            ['title' => 'Blueberries', 'quantity' => 150, 'unit' => 'grams', 'notes' => 'Fresh blueberries', 'status' => 'pending'],
            ['title' => 'Red Grapes', 'quantity' => 500, 'unit' => 'grams', 'notes' => 'Fresh red grapes', 'status' => 'pending'],
            ['title' => 'Watermelon', 'quantity' => 1, 'unit' => 'whole', 'notes' => 'Sweet and juicy watermelon', 'status' => 'pending'],
            ['title' => 'Sweet Mangoes', 'quantity' => 3, 'unit' => 'pieces', 'notes' => 'Juicy sweet mangoes', 'status' => 'pending'],
            ['title' => 'Fresh Pineapple', 'quantity' => 1, 'unit' => 'piece', 'notes' => 'Tropical fresh pineapple', 'status' => 'pending'],
            ['title' => 'Lemons', 'quantity' => 500, 'unit' => 'grams', 'notes' => 'Fresh citrus lemons', 'status' => 'pending'],
            ['title' => 'Green Limes', 'quantity' => 250, 'unit' => 'grams', 'notes' => 'Tropical limes', 'status' => 'pending'],
            ['title' => 'Kiwis', 'quantity' => 6, 'unit' => 'pieces', 'notes' => 'Tropical green kiwis', 'status' => 'pending'],
            ['title' => 'Sweet Peaches', 'quantity' => 4, 'unit' => 'pieces', 'notes' => 'Juicy sweet peaches', 'status' => 'pending'],
            ['title' => 'Ripe Pears', 'quantity' => 4, 'unit' => 'pieces', 'notes' => 'Fresh ripe pears', 'status' => 'pending'],
            ['title' => 'Red Cherries', 'quantity' => 200, 'unit' => 'grams', 'notes' => 'Sweet red cherries', 'status' => 'pending'],
        ];

        foreach ($catalogItems as $item) {
            Task::create($item);
        }

        // Add user-specific items
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        $groceryItems = [
            ['title' => 'Tomatoes', 'quantity' => 5, 'unit' => 'pieces', 'status' => 'pending', 'notes' => 'Fresh, medium-sized'],
            ['title' => 'Milk', 'quantity' => 2, 'unit' => 'liters', 'status' => 'bought', 'notes' => 'Whole milk preferred'],
            ['title' => 'Bread', 'quantity' => 1, 'unit' => 'pieces', 'status' => 'pending', 'notes' => 'Whole wheat'],
            ['title' => 'Chicken Breast', 'quantity' => 1, 'unit' => 'kg', 'status' => 'bought', 'notes' => 'Boneless, skinless'],
            ['title' => 'Rice', 'quantity' => 2, 'unit' => 'kg', 'status' => 'pending', 'notes' => 'Basmati rice'],
            ['title' => 'Olive Oil', 'quantity' => 1, 'unit' => 'liters', 'status' => 'bought', 'notes' => 'Extra virgin'],
            ['title' => 'Eggs', 'quantity' => 1, 'unit' => 'boxes', 'status' => 'pending', 'notes' => 'Large eggs, brown'],
            ['title' => 'Cheese', 'quantity' => 500, 'unit' => 'g', 'status' => 'bought', 'notes' => 'Cheddar cheese'],
            ['title' => 'Pasta', 'quantity' => 2, 'unit' => 'boxes', 'status' => 'pending', 'notes' => 'Spaghetti or penne'],
            ['title' => 'Apples', 'quantity' => 6, 'unit' => 'pieces', 'status' => 'pending', 'notes' => 'Red apples'],
            ['title' => 'Carrots', 'quantity' => 1, 'unit' => 'kg', 'status' => 'bought', 'notes' => 'Fresh carrots'],
            ['title' => 'Coffee', 'quantity' => 1, 'unit' => 'boxes', 'status' => 'pending', 'notes' => 'Ground coffee'],
        ];

        foreach ($users as $user) {
            foreach ($groceryItems as $item) {
                Task::create([
                    'user_id' => $user->id,
                    'title' => $item['title'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                    'status' => $item['status'],
                    'notes' => $item['notes'],
                ]);
            }
        }

        // Ensure admin user exists (created after migration run)
        try {
            $admin = \App\Models\User::where('email', 'Admin.123@gmail.com')->first();
            if (! $admin) {
                \App\Models\User::create([
                    'name' => 'Administrator',
                    'email' => 'Admin.123@gmail.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('Admin.123'),
                    'role' => 'admin',
                ]);
            } else {
                $admin->update(['role' => 'admin']);
            }
        } catch (\Exception $e) {
            // Ignore if users table/column not yet present during partial seeding
        }
    }
}
