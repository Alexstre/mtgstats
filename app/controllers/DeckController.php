<?php

use App\Event;

class DeckController extends \BaseController {

	protected $layout = "master";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$decks = Deck::all();
		return $this->layout->content = View::make('decks.index')->with('decks', $decks);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$events = DB::table('events')->orderBy('played_on', 'desc')->lists('name', 'name');
		return View::make('decks.create', array('all_events'=>$events));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Validation
		$rules = array(
        	'meta' => array('required'),
        	'player' => array('required'),
        	'event' => array('required'),
        	'decklist' => array('required')
    	);

    	$validation = Validator::make(Input::all(), $rules);

    	if ($validation->fails()) {
        	return Redirect::to('decks/create')->withInput()->withErrors($validation);
    	}

    	else {
    		$deck = Deck::create(array(
    			'meta' => Input::get('meta'),
    			'player' => Input::get('player')
    		));
    		
    		//$deck->event = Input::get('event');
    		//$deck->decklist = Input::get('decklist');

    		/* Pairing the deck with its cards */
    		$maindeck = true;
			$cardsSoFar = 0; // We'll use this to check when sideboard starts
    		foreach(explode("\n", Input::get('decklist')) as $line) {
    			$card = preg_split('/(?<=\d) (?=[a-z])|(?<=[a-z])(?=\d)/i', $line);
    			if (isset($card[1])) {  /* Card goes in the main deck */
    				$cardName = trim($card[1], "\r");
    				$cardObj = Card::where('name', '=', $cardName)->take(1)->get(); // Probably not the best way to do this?
    				if ($cardObj->count() == 0) { // Couldn't find the card abandon ship!
    					$deck->delete();
    					return Redirect::to('decks/create')->withInput()->withErrors(['Some of those cards don\'t look right']);
    				}
    				foreach($cardObj as $c) {  
    					// $c->id is the card's id, $card[0] is the amount
    					if (!$c->id) { var_dump("Couldn't find this card"); }
    					if ($cardsSoFar >= 60) $maindeck = false;
    					$c->decks()->attach($deck->id, array('amount' => $card[0], 'maindeck' => $maindeck));
    					$cardsSoFar += $card[0];
    				}
    			}
    		}

    		/* Now we need to pair the event with the deck */
    		/* This way requires event names to be unique, might be a better way? */
    		/* No need for as much validation here since the values are pulled from the DB */
    		$eventName = Input::get('event');
    		$eventObj = Event::where('name', '=', $eventName)->take(1)->get();
    		foreach($eventObj as $e) {
    			$deck->events()->attach($e->id);
    		}


    		Session::flash('message', 'Sucess!');
    		//return Redirect::to('decks');
    	}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return View::make('decks.show')
			->with('decks', Deck::where('id', '=', $id)
				->with('cards')->get());
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
