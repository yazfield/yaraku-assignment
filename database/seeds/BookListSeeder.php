<?php

use Illuminate\Database\Seeder;

class BookListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\BookList::class, 3)
            ->create()
            ->each(function ($bookList) {
                $bookList->books()
                    ->save(factory(App\Models\Book::class)->make());
            });
    }
}
