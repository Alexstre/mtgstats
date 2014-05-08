<?php namespace App;

use Eloquent;

class Event extends Eloquent {

    protected $fillable = array('name', 'played_on');

    // RELATIONSHIPS ----------------------------
    // Event has many Decks
    public function decks() {
        return $this->belongsToMany('Deck', 'decks_events', 'event_id', 'deck_id');
    }

}
