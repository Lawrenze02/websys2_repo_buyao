<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a demo user if not exists
        $user = User::firstOrCreate(
            ['username' => '2024-00001'],
            [
                'name'     => 'Juan Dela Cruz',
                'email'    => 'juan@example.com',
                'password' => Hash::make('password123'),
            ]
        );

        // Sample expenses for current month
        $currentMonth = now()->format('Y-m');
        $expenses = [
            ['amount' => 250.00,  'category' => 'Food',      'date' => now()->startOfMonth()->addDays(0)->format('Y-m-d'), 'description' => 'Breakfast and lunch combo'],
            ['amount' => 180.50,  'category' => 'Transport', 'date' => now()->startOfMonth()->addDays(1)->format('Y-m-d'), 'description' => 'Jeep fare to school'],
            ['amount' => 5000.00, 'category' => 'Rent',      'date' => now()->startOfMonth()->addDays(2)->format('Y-m-d'), 'description' => 'Monthly boarding house rent'],
            ['amount' => 320.00,  'category' => 'Food',      'date' => now()->startOfMonth()->addDays(3)->format('Y-m-d'), 'description' => 'Groceries for the week'],
            ['amount' => 95.00,   'category' => 'Transport', 'date' => now()->startOfMonth()->addDays(4)->format('Y-m-d'), 'description' => 'Bus fare round trip'],
            ['amount' => 210.00,  'category' => 'Food',      'date' => now()->startOfMonth()->addDays(5)->format('Y-m-d'), 'description' => 'Dinner with friends'],
            ['amount' => 150.00,  'category' => 'Transport', 'date' => now()->startOfMonth()->addDays(7)->format('Y-m-d'), 'description' => 'Grab ride to campus'],
            ['amount' => 480.00,  'category' => 'Food',      'date' => now()->startOfMonth()->addDays(9)->format('Y-m-d'), 'description' => 'Week supplies'],
        ];

        foreach ($expenses as $exp) {
            Expense::create(array_merge($exp, ['user_id' => $user->id]));
        }

        // Set a budget for current month
        Budget::updateOrCreate(
            ['user_id' => $user->id, 'month' => now()->month, 'year' => now()->year],
            ['monthly_limit' => 8000.00]
        );
    }
}
