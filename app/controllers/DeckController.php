<?php

use App\Event;

class DeckController extends \BaseController {

	protected $layout = "base";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$decks = Deck::orderBy('id', 'desc')->paginate(10);
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
        	'decklist' => array('required'),
            'finish' => array('required')
    	);

    	$validation = Validator::make(Input::all(), $rules);

    	if ($validation->fails()) {
        	return Redirect::to('decks/create')->withInput()->withErrors($validation);
    	}

    	else {
    		$deck = new Deck(array(
    			'meta' => Input::get('meta'),
    			'player' => Input::get('player'),
    		));

            $deck->save();

    		/* Pairing the deck with its cards */
    		$maindeck = true;
			$cardsSoFar = 0; // We'll use this to check when sideboard starts
    		foreach(explode("\n", Input::get('decklist')) as $line) {
    			$card = preg_split('/(?<=\d) (?=[a-z])|(?<=[a-z])(?=\d)/i', $line);
    			if (isset($card[1])) { 
    				$cardName = trim($card[1], "\r");
                    $cardCount = ($card[0] ? $card[0] : 1);
                    if ($cardsSoFar >= 60) $maindeck = false;
                    // Support for dual cards like Tear // Wear
                    if (str_contains($cardName, '//') ) {
                        $bothSides = explode(' // ', $cardName);
                        $bothCards = Card::where('name', '=', $bothSides[0])->orWhere('name', '=', $bothSides[1])
                                            ->take(2)->get();

                        if ($bothCards->count() !== 2) {
                            $deck->delete();
                            return Redirect::back()->withInput()->withErrors(["Can't find " . $cardNames]);
                        }

                        foreach ($bothCards as $side) {
                            $side->decks()->attach($deck->id, array('amount' => $cardCount, 'maindeck' => $maindeck));
                        }
                    } // END dual cards
                    else { // Good old regular card
    				    $cardObj = Card::where('name', '=', $cardName)->take(1)->get();
    				    if ($cardObj->count() == 0) { // Couldn't find the card abandon ship!
    					    $deck->delete();
    					    return Redirect::back()->withInput()->withErrors(["Can't find " . $cardName]);
    				    }
                        array_flatten($cardObj)[0]->decks()->attach($deck->id, array('amount' => $cardCount, 'maindeck' => $maindeck));
    			    }
                    $cardsSoFar += $cardCount;
                }
    		}

    		/* Now we need to pair the event with the deck */
    		/* This way requires event names to be unique, might be a better way? */
    		/* No need for as much validation here since the values are pulled from the DB */
    		$eventName = Input::get('event');
    		$eventObj = Event::where('name', '=', $eventName)->take(1)->get();
            $e = array_flatten($eventObj)[0];
    		$deck->events()->attach($e->id, array('finish'=>Input::get('finish')));

    		Session::flash('message', 'Sucess!');
    		return Redirect::to('decks');
    	}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		return View::make('decks.show')->with('decks', Deck::where('slug', '=', $slug)->with('cards')->get());
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

    public function reslugDecks()
    {
        $zz = Deck::all();
        foreach ($zz as $z) {
            $z->resluggify();
            $z->save();
            echo $z->slug;
        }
    }


}
