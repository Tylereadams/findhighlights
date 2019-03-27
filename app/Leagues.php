<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leagues extends Model
{
    //

    public function url()
    {
        return url('/'.$this->name);
    }

    /*
     * Functions
     */
    public function icon()
    {
        switch($this->name) {
            case 'nba':
                $icon = '<span class="icon"><i class="fas fa-basketball-ball"></i></span>';
                break;
            case 'nfl':
                $icon = '<span class="icon"><i class="fas fa-football-ball"></i></span>';
                break;
            case 'mlb':
                $icon = '<span class="icon"><i class="fas fa-baseball-ball"></i></span>';
                break;
            case 'nhl':
                $icon = '<span class="icon"><i class="fas fa-hockey-puck"></i></span>';
                break;
        }

        return $icon;
    }
}
