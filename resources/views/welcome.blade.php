@extends('layouts.app')

@section('metaTags')
    @include('includes.metaTags', $metaTags)
@endsection

@section('content')
    <nav class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">
                Search by player, team or game...
            </h1>

            @include('includes.search-bar')

            <nav class="columns is-flex-mobile has-padding-top-lg">
                <div class="column">
                    <div>
                        <a href="/nba" class="has-text-dark">
                            <p class="heading">NBA</p>
                            <p class="title"><i class="fas fa-basketball-ball"></i></p>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <a href="/nfl" class="has-text-dark">
                            <p class="heading">NFL</p>
                            <p class="title"><i class="fas fa-football-ball"></i></p>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <a href="/mlb" class="has-text-dark">
                            <p class="heading">MLB</p>
                            <p class="title"><i class="fas fa-baseball-ball"></i></p>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <a href="/nhl" class="has-text-dark">
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
            <h3 class="is-3 title"><i class="fas fa-fire-alt"></i> Recent Highlights</h3>

            <div class="columns is-multiline is-centered">
                @foreach($recentHighlights as $highlight)
                    <div class="column">
                        @include('partials.highlight', $highlight)
                    </div>
                @endforeach
            </div>
        </div>
        <hr>

        <br>
        <div class="container">
            <h3 class="is-3 title"><i class="fas fa-fire-alt"></i> Trending Searches</h3>

            <div class="columns is-multiline is-centered">
                <div class="column">
                    <div>
                        <h4 class="title is-4 has-text-grey-light mb-2">Games</h4>
                        <div class="has-padding-left-lg">
                            @foreach($recentGames as $league => $leagueGames)
                                <p class="heading has-padding"><strong>{{ $league }}</strong></p>
                                <ul>
                                    @foreach($leagueGames as $game)
                                        <li><small>{{ $game['date'] }}</small> - <a href="{{ $game['url'] }}">{{ $game['awayTeam']['nickname'] }} {{ $game['awayTeam']['score'] }} @ {{ $game['homeTeam']['nickname'] }} {{ $game['homeTeam']['score'] }}</a><small> - {{ $game['period'] }}</small></li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="column">
                    <div>
                        <h4 class="title is-4 has-text-grey-light">Teams</h4>
                        <div class="has-padding-left-lg columns is-mobile">
                            @foreach($popularTeams as $league => $leagueTeams)
                                <div class="column">
                                    <p class="heading"><strong>{{ $league }}</strong></p>
                                    <ul>
                                        @foreach($leagueTeams as $team)
                                            <li><small>{!! $team['iconHtml'] !!}</small> <a href="{{ $team['url'] }}">{{ $team['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="column">
                    <div>
                        <h4 class="title is-4 has-text-grey-light">Players</h4>
                        <div class="has-padding-left-lg columns is-mobile">
                            @foreach($popularPlayers as $league => $leaguePlayers)
                                <div class="column">
                                    <p class="heading"><strong>{{ $league }}</strong></p>
                                    <ul>
                                        @foreach($leaguePlayers as $player)
                                            <li><small>{!! $player['iconHtml'] !!}</small> <a href="{{ $player['url'] }}">{{ $player['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                             @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop


@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
    <script>
        $(function(){
            var clipboard = new Clipboard('.button');
        });
    </script>
@endpush