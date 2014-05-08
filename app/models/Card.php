<?php

class Card extends Eloquent {

    protected $fillable = array('name', 'set', 'manacost', 'power', 'toughness');

    // RELATIONSHIPS ----------------------------
    public function decks() {
        return $this->belongsToMany('Deck', 'cards_decks', 'card_id', 'deck_id')
            ->withPivot('amount', 'maindeck')
                ->orderBy('pivot_maindeck', 'desc');
    }

}
