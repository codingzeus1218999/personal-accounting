<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        Transaction::create([
            'title' => 'Salary',
            'amount' => 5000,
            'author_id' => 1,
        ]);

        Transaction::create([
            'title' => 'Groceries',
            'amount' => -200,
            'author_id' => 1,
        ]);
    }
}
