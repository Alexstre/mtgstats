<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Deck extends Eloquent implements SluggableInterface {
    use SluggableTrait;

    protected $fillable = array('player', 'meta');
    
    protected $sluggable = array(
        "build_from" => "metaname",
        "save_to" => "slug",
    );
    
    public function getMetanameAttribute() {
        return $this->meta . ' ' . $this->player;
    }

    // RELATIONSHIPS ----------------------------
    public function cards() {
        return $this->belongsToMany('Card', 'cards_decks', 'deck_id', 'card_id')
            ->withPivot('amount', 'maindeck')->orderBy('pivot_maindeck', 'desc');
    }

    public function events() {
        return $this->belongsToMany('App\Event', 'decks_events', 'deck_id', 'event_id')
            ->withPivot('finish')->orderBy('pivot_finish', 'asc');
    }

    public function results() {
        return $this->hasMany('Result', 'decks_events_results', 'deck_id1', 'deck_id2', 'deck_score1', 'deck_score2');
    }
}
