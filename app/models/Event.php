<?php namespace App;

use Eloquent;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Event extends Eloquent implements SluggableInterface {

    use SluggableTrait;
    protected $fillable = array('name', 'played_on');
    protected $sluggable = array(
        "build_from" => "name",
        "save_to" => "slug",
    );

    // RELATIONSHIPS ----------------------------
    // Event has many Decks
    public function decks() {
        return $this->belongsToMany('Deck', 'decks_events', 'event_id', 'deck_id');
    }

}
