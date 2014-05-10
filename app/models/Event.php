<?php namespace App;

use Eloquent;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Event extends Eloquent implements SluggableInterface {

    use SluggableTrait;
    protected $fillable = array('name', 'played_on');
    protected $sluggable = array(
        "build_from" => "namedate",
        "save_to" => "slug",
    );

    public function getNamedateAttribute() {
        return $this->name . ' ' . $this->played_on;
    }

    // RELATIONSHIPS ----------------------------
    // Event has many Decks
    public function decks() {
        return $this->belongsToMany('Deck', 'decks_events', 'event_id', 'deck_id', 'finish');
    }

}
