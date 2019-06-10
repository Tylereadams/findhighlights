<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Highlights extends Model
{
    protected $table = 'tweet_logs';

    /******************
     * Relations
     ******************/
    public function game()
    {
        return $this->belongsTo(Games::class);
    }

    public function team()
    {
        return $this->belongsTo(Teams::class);
    }

    public function players()
    {
        return $this->hasManyThrough(Players::class, PlayerHighlights::class, 'tweet_logs_id', 'id', 'id', 'player_id');
    }

    public function groupByDaysAndGame($q)
    {
        return $q->groupBy(function($highlight){
            return $highlight->game->homeTeam->nickname.' vs '.$highlight->game->awayTeam->nickname;
        })->groupBy(function($gameHighlights){
            return $gameHighlights->first()->game->start_date->format('n/j');
        });
    }

    /******************
     * Functions
     ******************/

    /**
     * Returns Twitter url for tweet
     * @return string
     */
    public function getTweetUrl()
    {
        return 'https://twitter.com/'.$this->team->twitter.'/status/'.$this->tweet_id;
    }

    /**
     * Returns path of highlight video within Digital Ocean
     * @return string
     */
    public function getVideoPath()
    {
        $leagueName = $this->game->league->name;
        $startDate = $this->game->start_date->format('Y-m-d');
        $gameSlug = str_slug($this->game->homeTeam->nickname . ' ' . $this->game->awayTeam->nickname . ' ' . $this->game->id);
        $fileName = str_slug($this->team->nickname . ' ' . $this->id);
        $extension = 'mp4';

        $path = 'highlights/' .$leagueName . '/' . $startDate . '/' . $gameSlug . '/' . $fileName . '.' . $extension;

        return $path;
    }

    /**
     * Returns highlight mp4 string
     * @return mixed
     */
    public function url()
    {
        return Storage::disk('ocean')->url($this->getVideoPath());
    }

    public function gifUrl()
    {
        if(!$this->gfycat_code) {
            return '';
        }

        return 'https://thumbs.gfycat.com/'.$this->gfycat_code.'-size_restricted.gif';
    }
}
