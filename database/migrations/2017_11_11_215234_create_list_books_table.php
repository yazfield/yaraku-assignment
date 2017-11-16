<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_books', function (Blueprint $table) {
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('book_list_id');
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('book_list_id')->references('id')->on('book_lists');
            $table->primary(['book_id', 'book_list_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_books');
    }
}
