<?php

use App\Event;

class EventController extends \BaseController {

	//protected $layout = "layouts.default";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = Event::where('draft', '=', false)->get();
		return View::make('events/index')->with('events', $events);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('events/create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		/* Validation first */
		$rules = array(
        	'name' => array('required', 'unique:events,name'),
        	'played_on' => array('required'),
    	);

    	$validation = Validator::make(Input::all(), $rules);

    	if ($validation->fails()) {
        	return Redirect::to('events/create')->withInput()->withErrors($validation);
    	}

    	else {
    		$event = new Event;
    		$event->name = Input::get('name');
    		$event->played_on = Input::get('played_on');
    		$event->draft = true;
    		$event->save();

    		Session::flash('message', 'Sucess!');
    		return Redirect::to('events');
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
        /*
         * Would be a lot better if this would work with $event->cards where
         * Event and Card are linked through Deck. Doesn't seem to work with many-to-many
         */
        $event = Event::where('slug', '=', $slug)->firstOrFail();
        $results = Result::getAllResults($event->id);
        // $event->decks all the decks from the event
        $deck_ids = array();
        foreach ($event->decks as $deck) {
            array_push($deck_ids, $deck->id);
        }

        // all the cards from the event
        //$cards_query = DB::table('cards_decks')->whereIn('deck_id', $deck_ids)->orderBy('amount', 'desc')->get();
        $cards_query = DB::table('cards_decks')->whereIn('deck_id', $deck_ids)->select(DB::raw('sum(amount) as card_count, card_id'))
            ->groupBy('card_id')->orderBy('card_count', 'desc')->get();

        $card_amounts = array();
        foreach ($cards_query as $card) {
            $card_amounts[$card->card_id] = $card->card_count;
        }

        $cards = DB::table('cards')->whereIn('id', array_keys($card_amounts))->get();

		return View::make('events.show')->with(array(
            'event' => $event,                 /* the event, including decks */
            'results' => $results,             /* results */
            'cards' => $cards,                 /* all card used (Card objects) */
            'card_amounts' => $card_amounts    /* id->amount for all cards used */
        ));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($slug)
	{
        $event = Event::where('slug', '=', $slug)->firstOrFail();
        $results = Result::getAllResults($event->id);
        $decks = Event::find($event->id)->with('decks');
        return View::make('events.edit')->with(array(
            'event' => $event,
            'results' => $results,
            'decks' => $decks
        ));
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

	public function activate($id) {
		if (Auth::user()->admin) {
			$event = Event::find($id);
			$event->draft = false;
			$event->save();
			Session::flash('message', 'The event was activated and will now be available.');
			Redirect::to('events');
		}
		else {
			Session::flash('error', 'Woah there cowboy!');
			Redirect::to('events');
		}
	}


}
