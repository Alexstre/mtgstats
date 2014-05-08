<?php

class Deck extends Eloquent {

    protected $fillable = array('player', 'meta');

    // RELATIONSHIPS ----------------------------
    public function cards() {
        return $this->belongsToMany('Card', 'cards_decks', 'deck_id', 'card_id')
            ->withPivot('amount', 'maindeck')->orderBy('pivot_maindeck', 'desc');
    }

    public function events() {
        return $this->belongsToMany('App\Event', 'decks_events', 'deck_id', 'event_id');
    }

}
