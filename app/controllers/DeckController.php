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
		$events = DB::table('events')->orderBy('played_on', 'desc')->lists('name', 'played_on');
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
    		/*
    		$deck = Deck::create(array(
    			'meta' => Input::get('meta'),
    			'player' => Input::get('player')
    		));*/
    		
    		//$deck->event = Input::get('event');
    		//$deck->decklist = Input::get('decklist');

			$cardNames = array();

    		foreach(explode("\n", Input::get('decklist')) as $line) {
    			$card = preg_split('/(?<=\d) (?=[a-z])|(?<=[a-z])(?=\d)/i', $line);
    			if (isset($card[1])) {  /* Card goes in the main deck */
    				array_push($cardNames, $card[1]);
    				/*echo 'Looking for ' . $card[1];
    				$cardObj = Card::where('name', 'LIKE', $card[1])->select('id', 'name')->first();
    				var_dump($cardObj);*/
    			}
    		}
			
			$results = Card::whereIn('name', $cardNames)->get();
			var_dump($results);
    		
    		//$event->save();

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
