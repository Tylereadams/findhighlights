<?php

namespace App\Providers;

use App\Leagues;
use App\Teams;
use Illuminate\Support\ServiceProvider;

class TeamMapperProvider extends ServiceProvider
{
    /**
     * Construct the application services.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function mapTeam($teamName, Leagues $league)
    {
        return Teams::where('league_id', $league->id)->where(function($q) use($teamName){
            $q->where('nickname', 'LIKE', '%'.$teamName.'%');
            $q->orWhere('location', 'LIKE', '%'.$teamName.'%');
            $q->orwhere('twitter', 'LIKE', '%'.$teamName.'%');
            $q->orwhere('hashtag', 'LIKE', '%'.$teamName.'%');
        })->first();
    }
}
