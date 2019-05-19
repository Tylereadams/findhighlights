@extends('layouts.app')

@section('content')
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">
                Search Highlights
            </h1>
            <h2 class="subtitle">
                Find highlights of players, games, teams or leagues
            </h2>

            <section class="hero">
                <div class="hero-body">
                    <div class="container">
                @include('includes.search-bar')
                    </div>
                </div>
            </section>

            <nav class="columns is-flex-mobile">
                <div class="column has-text-centered">
                    <div>
                        <a href="/nba">
                            <p class="heading">NBA</p>
                            <p class="title"><i class="fas fa-basketball-ball"></i></p>
                        </a>
                    </div>
                </div>
                <div class="column has-text-centered">
                    <div>
                        <a href="/nfl">
                            <p class="heading">NFL</p>
                            <p class="title"><i class="fas fa-football-ball"></i></p>
                        </a>
                    </div>
                </div>
                <div class="column has-text-centered">
                    <div>
                        <a href="/mlb">
                            <p class="heading">MLB</p>
                            <p class="title"><i class="fas fa-baseball-ball"></i></p>
                        </a>
                    </div>
                </div>
                <div class="column has-text-centered">
                    <div>
                        <a href="/nhl">
                            <p class="heading">NHL</p>
                            <p class="title"><i class="fas fa-hockey-puck"></i></p>
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <br>

        <hr>

        <div class="container">

            <div class="columns">
                <div class="column">
                    <div>
                        <p class="title">Games</p>
                        <ul>
                            @foreach($recentGames as $game)
                                <li><small>{!! $game['iconHtml'] !!} {{ $game['date'] }}</small> - <a href="{{ $game['url'] }}">{{ $game['awayTeam']['nickname'] }} {{ $game['awayTeam']['score'] }} @ {{ $game['homeTeam']['nickname'] }} {{ $game['homeTeam']['score'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <p class="title">Teams</p>
                        <ul>
                            @foreach($popularTeams as $team)
                                <li><small>{!! $team['iconHtml'] !!}</small> <a href="{{ $team['url'] }}">{{ $team['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <p class="title">Players</p>
                        <ul>
                            @foreach($popularPlayers as $player)
                                <li><small>{!! $player['iconHtml'] !!}</small> <a href="{{ $player['url'] }}">{{ $player['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop