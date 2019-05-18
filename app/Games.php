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
}
