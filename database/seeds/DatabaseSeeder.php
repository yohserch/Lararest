<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        $numberOfUsers = 1000;
        $numberOfCategories = 30;
        $numberOfProducts = 1000;
        $numberOfTransactions = 1000;

        factory(User::class, $numberOfUsers)->create();
        factory(Category::class, $numberOfCategories)->create();
        factory(Product::class, $numberOfProducts)->create()->each(function($product) {
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');

            $product->categories()->attach($categories);
        });
        factory(Transaction::class, $numberOfTransactions)->create();

    }
}
