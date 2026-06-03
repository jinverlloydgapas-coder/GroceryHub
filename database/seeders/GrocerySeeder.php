<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class GrocerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groceries = [
            // Vegetables
            ['title' => 'Fresh Carrots', 'quantity' => 1, 'unit' => 'kg', 'notes' => 'Organic carrots, orange color', 'status' => 'available'],
            ['title' => 'Broccoli', 'quantity' => 1, 'unit' => 'bunch', 'notes' => 'Fresh green broccoli', 'status' => 'available'],
            ['title' => 'Tomatoes', 'quantity' => 500, 'unit' => 'grams', 'notes' => 'Ripe red tomatoes', 'status' => 'available'],
            ['title' => 'Spinach', 'quantity' => 250, 'unit' => 'grams', 'notes' => 'Fresh spinach leaves', 'status' => 'available'],
            ['title' => 'Cucumbers', 'quantity' => 3, 'unit' => 'pieces', 'notes' => 'Crisp and fresh', 'status' => 'available'],
            ['title' => 'Bell Peppers', 'quantity' => 3, 'unit' => 'pieces', 'notes' => 'Red, yellow, and green', 'status' => 'available'],
            ['title' => 'Potatoes', 'quantity' => 2, 'unit' => 'kg', 'notes' => 'Russet potatoes', 'status' => 'available'],
            ['title' => 'Onions', 'quantity' => 1, 'unit' => 'kg', 'notes' => 'Yellow onions', 'status' => 'available'],
            ['title' => 'Garlic', 'quantity' => 100, 'unit' => 'grams', 'notes' => 'Fresh garlic bulbs', 'status' => 'available'],
            ['title' => 'Lettuce', 'quantity' => 1, 'unit' => 'head', 'notes' => 'Crisp iceberg lettuce', 'status' => 'available'],
            ['title' => 'Cabbage', 'quantity' => 1, 'unit' => 'head', 'notes' => 'Purple cabbage', 'status' => 'available'],
            ['title' => 'Celery', 'quantity' => 1, 'unit' => 'bunch', 'notes' => 'Fresh celery stalks', 'status' => 'available'],
            ['title' => 'Zucchini', 'quantity' => 500, 'unit' => 'grams', 'notes' => 'Green zucchini', 'status' => 'available'],
            ['title' => 'Mushrooms', 'quantity' => 250, 'unit' => 'grams', 'notes' => 'Button mushrooms', 'status' => 'available'],
            ['title' => 'Peas', 'quantity' => 300, 'unit' => 'grams', 'notes' => 'Fresh green peas', 'status' => 'available'],
            
            // Fruits
            ['title' => 'Apples', 'quantity' => 6, 'unit' => 'pieces', 'notes' => 'Red and green apples', 'status' => 'available'],
            ['title' => 'Bananas', 'quantity' => 1, 'unit' => 'bunch', 'notes' => 'Golden yellow bananas', 'status' => 'available'],
            ['title' => 'Oranges', 'quantity' => 1, 'unit' => 'kg', 'notes' => 'Fresh Valencia oranges', 'status' => 'available'],
            ['title' => 'Strawberries', 'quantity' => 400, 'unit' => 'grams', 'notes' => 'Sweet red strawberries', 'status' => 'available'],
            ['title' => 'Blueberries', 'quantity' => 150, 'unit' => 'grams', 'notes' => 'Fresh blueberries', 'status' => 'available'],
            ['title' => 'Grapes', 'quantity' => 500, 'unit' => 'grams', 'notes' => 'Red and green grapes', 'status' => 'available'],
            ['title' => 'Watermelon', 'quantity' => 1, 'unit' => 'whole', 'notes' => 'Sweet and juicy watermelon', 'status' => 'available'],
            ['title' => 'Mango', 'quantity' => 3, 'unit' => 'pieces', 'notes' => 'Sweet mangoes', 'status' => 'available'],
            ['title' => 'Pineapple', 'quantity' => 1, 'unit' => 'piece', 'notes' => 'Fresh pineapple', 'status' => 'available'],
            ['title' => 'Lemons', 'quantity' => 500, 'unit' => 'grams', 'notes' => 'Fresh lemons', 'status' => 'available'],
            ['title' => 'Limes', 'quantity' => 250, 'unit' => 'grams', 'notes' => 'Green limes', 'status' => 'available'],
            ['title' => 'Kiwis', 'quantity' => 6, 'unit' => 'pieces', 'notes' => 'Tropical kiwis', 'status' => 'available'],
            ['title' => 'Peaches', 'quantity' => 4, 'unit' => 'pieces', 'notes' => 'Sweet peaches', 'status' => 'available'],
            ['title' => 'Pears', 'quantity' => 4, 'unit' => 'pieces', 'notes' => 'Ripe pears', 'status' => 'available'],
            ['title' => 'Cherries', 'quantity' => 200, 'unit' => 'grams', 'notes' => 'Sweet red cherries', 'status' => 'available'],
        ];

        foreach ($groceries as $grocery) {
            Task::create($grocery);
        }
    }
}
