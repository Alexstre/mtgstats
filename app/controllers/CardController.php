<?php

class CardController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$redis = Redis::connection();
		$c = $redis->command('zadd', 'name', 5);
		echo $redis->get('name');
		return;
	}

}
