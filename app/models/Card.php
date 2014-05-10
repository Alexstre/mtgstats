<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Card extends Eloquent {

    use SluggableTrait;
    protected $fillable = array('name', 'set', 'manacost', 'power', 'toughness');
    protected $sluggable = array(
        "build_from" => "setname",
        "save_to" => "slug",
    );

    public function getSetnameAttribute() {
        return $this->set . ' ' . $this->name;
    }

    // RELATIONSHIPS ----------------------------
    public function decks() {
        return $this->belongsToMany('Deck', 'cards_decks', 'card_id', 'deck_id')
            ->withPivot('amount', 'maindeck')
                ->orderBy('pivot_maindeck', 'desc');
    }

    // CARD INFO STUFF ------------------------
    public static function isBasicLand($card) {
        if (isset($card->type)) return strpos($card->type, "Basic Land -") === 0 ? true : false;
        return true;
    }

    // IMAGES -------------------
    public static function grabImage($name) {
        $local = public_path() . "/images/" . $name . ".jpg";
        // We want to check if there's a local copy available, if not grab it from mtgimage.com 
        if (!file_exists('public/images/' . $name . '.jpg')) {
            $url = "http://mtgimage.com/card/" . rawurlencode($name) . ".jpg";
            copy($url, $local);
        }
        return $local;
    }
}
