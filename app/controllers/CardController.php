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

        /* This is the old way of doing it. It doesn't return Card objects so it requires a more queries down the line
        and although it looks cleaner I think the other way is better.
		$s = DB::table('cards_decks')->select(DB::raw('sum(amount) as card_count, card_id'))
			->groupBy('card_id')->orderBy('card_count', 'desc')
			->take(20)->get();*/

        $s = DB::table('cards')->join('cards_decks', 'cards.id', '=', 'card_id')
                               ->select('cards.*', DB::raw('Sum(Distinct cards_decks.amount) as total_card'))
                               ->groupBy('card_id')->orderBy('total_card', 'desc')
                               ->take(60)->remember(60)->get(); // TODO: Add ->remember(60)
        $cardsInMeta = DB::table('cards_decks')->sum('amount');
		foreach ($s as $b) {
			//$c = Card::find($b->id); // The old way
			if ($b !== null) {
				if (!Card::isBasicLand($b)) {
                    array_push($top, $b);
                    array_push($cards_url, Card::grabImage($b->name));
                    $b->pct = round($b->total_card / $cardsInMeta * 100, 2);
                }
			}
			else {
                Log::error('Card IDs are all fucked up.');
                App::abort(403, 'Unauthorized');
            } // Big problem with card_id not matching the id's in cards_decks
		}

		return $this->layout->content = View::make('cards.index')->with(array(
            'pages' => $s,
            'cardsMeta' => $cardsInMeta,
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
