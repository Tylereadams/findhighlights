@extends('layouts.app')

@section('content')
    <nav class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">
                Find Highlights
            </h1>
            <h2 class="subtitle">
                Search by player, game or team...
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
            <h3 class="is-3 title has-text-grey-light"><i class="fas fa-fire-alt"></i> Trending</h3>

            <nav class="level">
            <div class="level-item-left">
                <div>
                    <h4 class="title is-4 has-text-grey-light mb-2">Games</h4>
                    <div class="has-padding-left-lg">
                        @foreach($recentGames as $league => $leagueGames)
                            <p class="heading has-padding"><strong>{{ $league }}</strong></p>
                            <ul>
                                @foreach($leagueGames as $game)
                                    <li><small>{{ $game['date'] }}</small> - <a href="{{ $game['url'] }}">{{ $game['awayTeam']['nickname'] }} {{ $game['awayTeam']['score'] }} @ {{ $game['homeTeam']['nickname'] }} {{ $game['homeTeam']['score'] }}</a></li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="level-item-left">
                <div>
                    <h4 class="title is-4 has-text-grey-light">Teams</h4>
                    <div class="has-padding-left-lg">
                        @foreach($popularTeams as $league => $leagueTeams)
                            <p class="heading"><strong>{{ $league }}</strong></p>
                            <ul>
                                @foreach($leagueTeams as $team)
                                    <li><small>{!! $team['iconHtml'] !!}</small> <a href="{{ $team['url'] }}">{{ $team['name'] }}</a></li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="level-item-left">
                <div>
                    <h4 class="title is-4 has-text-grey-light">Players</h4>
                    <div class="has-padding-left-lg">
                        @foreach($popularPlayers as $league => $leaguePlayers)
                            <p class="heading"><strong>{{ $league }}</strong></p>
                            <ul>
                                @foreach($leaguePlayers as $player)
                                    <li><small>{!! $player['iconHtml'] !!}</small> <a href="{{ $player['url'] }}">{{ $player['name'] }}</a></li>
                                @endforeach
                            </ul>
                         @endforeach
                    </div>
                </div>
            </div>
        </nav>
        </div>

    </div>
@stop