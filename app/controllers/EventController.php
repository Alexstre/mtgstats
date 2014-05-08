<?php

use App\Event;

class EventController extends \BaseController {

	protected $layout = "master";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = Event::all();
		return $this->layout->content = View::make('events.index')->with('events', $events);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('events.create');
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
        	'played_on' => array('required')
    	);

    	$validation = Validator::make(Input::all(), $rules);

    	if ($validation->fails()) {
        	return Redirect::to('events/create')->withInput()->withErrors($validation);
    	}

    	else {
    		$event = new Event;
    		$event->name = Input::get('name');
    		$event->played_on = Input::get('played_on');
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
	public function show($id)
	{
		return View::make('events.show')->with('events', Event::where('id', '=', $id)->with('decks')->get());
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
