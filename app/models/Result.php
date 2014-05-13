<?php

class Result extends Eloquent {
    protected $table = 'results';


    public static function getAllResults($event_id) {
        $res = DB::table('results')->where('event_id', $event_id)->get();
        return $res;
    }

    public static function getSpecificResult($deck1_id, $deck2_id, $event_id) {
        $res = DB::table($table)->where('event_id', '=', $event_id)
            ->where('deck1_id', '=', $deck1_id)->orWhere('deck1_id', '=', $deck2_id)
            ->where('deck2_id', '=', $deck1_id)->orWhere('deck2_id', '=', $deck2_id)->get();
        return $res;
    }

    public static function setSpecificResult($deck1_id, $deck2_id, $event_id, $score1, $score2) {

    }

    public static function swapResults(&$id1, &$id2, &$score1, &$score2) {
        $id1 = $id1 ^ $id2;
        $id2 = $id1 ^ $id2;
        $id1 = $id1 ^ $id2;

        $score1 = $score1 ^ $score2;
        $score2 = $score1 ^ $score2;
        $score1 = $score1 ^ $score2;
    }
}
