<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    //
    /**
     * Relations
     */
    public function league()
    {
        return $this->belongsTo(Leagues::class);
    }

    public function players()
    {
        return $this->hasMany(Players::class, 'team_id');
    }

    public function highlights()
    {
        return $this->hasMany(Highlights::class, 'team_id');
    }

    public function colors()
    {
        return $this->hasMany(TeamsColors::class, 'team_id');
    }


    /**
     * Functions
     */
    public function url()
    {
        return url('/'.$this->league->name.'/'.str_slug($this->nickname));
    }
}
