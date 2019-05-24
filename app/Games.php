<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    protected $dates = ['start_date', 'ended_at'];

    //
    public function homeTeam()
    {
        return $this->belongsTo(Teams::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Teams::class, 'away_team_id');
    }

    public function league()
    {
        return $this->belongsTo(Leagues::class);
    }

    public function highlights()
    {
        return  $this->hasMany(Highlights::class, 'game_id');
    }

    /**
     * Functions
     */
    public function url()
    {
        return url('/'.$this->league->name.'/'.str_slug($this->homeTeam->nickname).'/'.str_slug($this->url_segment));
    }

    public function title()
    {
        return $this->awayTeam->nickname . ' ' . ($this->status > 1 ? $this->away_score : '') . ' @ ' . $this->homeTeam->nickname . ' ' . ($this->status > 1 ? $this->home_score : '') . ($this->ended_at ? ' - Final' : '');
    }

    public function imageUrl()
    {
        // TODO: Change betbuddies.co to something more legit
        return 'http://betbuddies.co/game/' . $this->url_segment . '/image';
    }

    public function getPeriodString()
    {
        if($this->ended_at) {
            return 'Final';
        }

        return $this->league->getPeriodLabel($this->period);
    }
}
