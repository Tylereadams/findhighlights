<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    //
    public $timestamps = false;

    protected $guarded = ['id'];


    // Relations
    public function team()
    {
        return $this->belongsTo(Teams::class);
    }

    public function highlights()
    {
        return $this->hasManyThrough(Highlights::class, PlayerHighlights::class, 'player_id', 'id', 'id', 'tweet_logs_id');
    }

    /**************
     * Functions
     **************/
    public function setUrl_segmentAttribute()
    {
        $this->attributes['url_segment'] = $this->urlSegment();
    }

    /**
     * Creates URL safe string for game: 'homeTeam-awayTeam-date'
     * @return mixed
     */
    public function getUrlSegment()
    {
        // Create URL segment if we don't have one.
        if(!$this->url_segment){
            $this->url_segment = str_slug($this->getFullName().' '.$this->id);
            $this->save();
        }

        return $this->url_segment;
    }

    public function getFullName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function url() {
        return url('/players/'.$this->getUrlSegment());
    }
}
