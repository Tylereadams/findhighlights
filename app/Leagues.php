<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leagues extends Model
{
    //
    const NBA_ID = 1;
    const MLB_ID = 2;
    const NFL_ID = 3;
    const NHL_ID = 4;

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

    public function getPeriodLabel($period)
    {
        if(($this->id == Self::NBA_ID || $this->id == Self::NFL_ID) && $period > 4){
            return $period == 5 ? 'OT' : ($period - 4).'OT';
        } elseif($this->id == Self::NHL_ID  && $period > 3){
            return $period == 4 ? 'OT' : ($period - 3).'OT';
        } else {
            return $this->ordinal($period);
        }
    }

    public function ordinal($number) {

        if(!$number) {
            return '';
        }

        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

}
