<?php

use App\Event;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserSeeder'); // Creates Admin
		$this->call('ThisAppSeeder'); // Adds some cards, 2 decks and an event
		$this->command->info('Seeding is done.'); // done seeding, show on command line
	}

}

class UserSeeder extends Seeder {
	public function run () {
		$users = [
			[
				"username" => "Alex",
				"password" => Hash::make("password"),
				"email" => "alex.marcotte@gmail.com",
				"admin" => true

			]
		];

		foreach ($users as $user) {
			User::create($user);
		}
	}
}

class ThisAppSeeder extends Seeder {
	public function run () {
		// DELETING THE TABLES ---------------------
		//DB::table('cards')->delete();
		DB::table('decks')->delete();
		DB::table('events')->delete();
		DB::table('cards_decks')->delete();
		DB::table('decks_events')->delete();

		// FAKE DATA ---------------------
		// Cards
		$card_1 = Card::create(array(
			'name' => 'Aerie Worshippers',
			'set' => 'BNG',
			'type' => 'Creature',
			'manacost' => '{1}{W}',
			'power' => 4,
			'toughness' => 5
		));

		$card_2 = Card::create(array(
			'name' => 'Bile Blight',
			'set' => 'BNG',
			'type' => 'Instant',
			'manacost' => '{1}{B}',
		));

		$card_3 = Card::create(array(
			'name' => 'Worst Fear',
			'set' => 'JOU',
			'type' => 'Sorcery',
			'manacost' => '{2}{R}{R}'
		));

		$this->command->info('Created some cards');

		// Decks
		$deck_1 = Deck::create(array(
			'meta' => 'U/W Control',
			'player' => 'Cookie Monster'
		));

		$deck_2 = Deck::create(array(
			'meta' => 'RDW',
			'player' => 'Suzy Waterbottle'
		));

		// All 3 cards in Deck 1
		$card_1->decks()->attach($deck_1->id, array('amount' => 4, 'maindeck' => true));
		$card_2->decks()->attach($deck_1->id, array('amount' => 4, 'maindeck' => false));
		$card_3->decks()->attach($deck_1->id, array('amount' => 4, 'maindeck' => true));
		// 2 cards in Deck 2
		$card_1->decks()->attach($deck_2->id, array('amount' => 4, 'maindeck' => true));
		$card_2->decks()->attach($deck_2->id, array('amount' => 4, 'maindeck' => true));

		$this->command->info('Added some cards to some decks');

		// Events
		$event_1 = Event::create(array(
			'name' => 'Super Duper Tourney',
			'played_on' => date('2014-05-07')
		));

		$deck_1->events()->attach($event_1->id, array('finish' => 1));
		$deck_2->events()->attach($event_1->id, array('finish' => 2));

		$this->command->info('Added decks to the events');
	}
}