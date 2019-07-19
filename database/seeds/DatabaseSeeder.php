<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use OrderService\Book;
use OrderService\Customer;
use OrderService\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        factory(Book::class, 50)->create();
        factory(User::class, 50)->create();
        factory(Customer::class, 50)->create();
    }
}
