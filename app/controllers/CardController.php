<?php

use App\Event;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class CardController extends \BaseController {

	protected $layout = "layouts.default";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		/* Let's find the top 15 cards */
		$top = array();

        /* This is the old way of doing it. It doesn't return Card objects so it requires a more queries down the line
        and although it looks cleaner I think the other way is better.
		$s = DB::table('cards_decks')->select(DB::raw('sum(amount) as card_count, card_id'))
			->groupBy('card_id')->orderBy('card_count', 'desc')
			->take(20)->get();*/

        $s = DB::table('cards')->join('cards_decks', 'cards.id', '=', 'card_id')
                               ->select('cards.*', DB::raw('Sum(Distinct cards_decks.amount) as total_card'))
                               ->groupBy('card_id')->orderBy('total_card', 'desc')
                               ->take(60)->remember(60)->get();
        $cardsInMeta = DB::table('cards_decks')->sum('amount');
		foreach ($s as $b) {
			//$c = Card::find($b->id); // The old way
			if ($b !== null) {
				if (!Card::isBasicLand($b)) {
                    array_push($top, $b);
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
	public function show($slug) {
        $card = Card::where('slug', '=', $slug)->firstOrFail();

        /* We can find all the decks containing the card and count the number in the main and sideboard */
        $decks = DB::table('cards_decks')->select('card_id', 'deck_id', 'amount', 'maindeck')
                                         ->where('card_id', '=', $card->id)->orderBy('deck_id')->get();
        $totals = array();
        $deck_ids = array();
        foreach ($decks as $deck => $sub) {
            array_push($deck_ids, $sub->deck_id);
            if (!isset($totals[$sub->deck_id])) $totals[$sub->deck_id] = array();
            if ($sub->maindeck) $totals[$sub->deck_id]['maindeck'] = $sub->amount;
            else $totals[$sub->deck_id]['sideboard'] = $sub->amount;
        }

        /* What we really want to see is popularity over time, let's associate a date with each appearance */
        $deck_dates = array();
        $a = Event::with('decks')->get();
        foreach($a as $b) {
            foreach ($b->decks()->get() as $deck) {
                if (!isset($deck_dates[$deck->id])) $deck_dates[$deck->id] = $b->played_on;
            }
        }

        foreach($decks as $deck) {

            if (isset($totals[$deck->deck_id])) {
                $totals[$deck->deck_id]['played_on'] = $deck_dates[$deck->deck_id];
            }
        }
        /* $totals now has the deck id, the amount of the card it had on main and side, and the date it was played */

        /* To use HighChart we'll need a JS array of dates with a corresponding amount of cards at that time */
        $times = array();
        $mb = array();
        $sb = array();
        foreach ($totals as $moment) {
            // $moment->played_on is a date, we check if it's in the 'times' array
            if (!in_array($moment['played_on'], $times)) array_push($times, $moment['played_on']);
        }
        var_dump($times);
        sort($times);

        foreach ($totals as $moment) {
            $pos = array_search($moment['played_on'], $times);
            if (!isset($mb[$pos])) $mb[$pos] = (isset($moment['maindeck']) ? $moment['maindeck'] : 0);
            else $mb[$pos] += (isset($moment['maindeck']) ? $moment['maindeck'] : 0);


            if (!isset($sb[$pos])) $sb[$pos] = (isset($moment['sideboard']) ? $moment['sideboard'] : 0);
            else $sb[$pos] += (isset($moment['sideboard']) ? $moment['sideboard'] : 0);
        }
        ksort($mb);
        ksort($sb);
        //dd($times, $mb, $sb);
        return $this->layout->content = View::make('cards.show')->with(array(
            'card' => $card,
            'image' => Card::grabImage($card->name),
            'decks' => DB::table('decks')->whereIn('id', $deck_ids)->orderBy('id', 'desc')->get(),
            'totals' => $totals,
            'times' => json_encode($times),
            'mb' => json_encode($mb),
            'sb' => json_encode($sb),
        ));
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
