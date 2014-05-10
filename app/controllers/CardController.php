<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class CardController extends \BaseController {

	protected $layout = "base";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		/* Let's find the top 15 cards */
		$top = array();
		$cards_url = array();
		$s = DB::table('cards_decks')->select(DB::raw('sum(amount) as card_count, card_id'))
			->groupBy('card_id')->orderBy('card_count', 'desc')
			->take(20)->get();
		foreach ($s as $b) {
			$c = Card::find($b->card_id);
			if ($c !== null) {
				if (!Card::isBasicLand($c)) array_push($top, $c);
				array_push($cards_url, Card::grabImage($c->name));
			}
			else {
				/* Big problem with card_id not matching the id's in cards_decks */
			}
		}

		return $this->layout->content = View::make('cards.index')->with(array(
			'top15' => $top,
			'images' => $cards_url,
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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

	public function reslugCards()
	{
		$zz = Card::all();
		foreach ($zz as $z) {
			$z->resluggify();
			$z->save();
			echo $z->slug;
		}
	}

}
