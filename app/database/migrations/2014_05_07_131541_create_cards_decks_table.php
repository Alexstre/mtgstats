<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsDecksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cards_decks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('card_id');
			$table->integer('deck_id');
			$table->integer('amount');
			$table->boolean('maindeck');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cards_decks');
	}

}
