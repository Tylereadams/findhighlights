@extends('layouts.app')

@section('metaTags')
    @include('includes.metaTags', $metaTags)
@endsection

@section('content')

    <div class="container">

        <div class="jumbotron bg-white text-center">
            <h2>Search for highlights</h2>
            @include('includes.search-bar')
        </div>

        <h3 class="m-3"><i class="fas fa-clock"></i> Recent</h3>

        <div class="row pt-3">
            @foreach($recentHighlights as $highlight)
                <div class="col-lg-4">
                    @include('partials.highlight')
                </div>
            @endforeach
        </div>
    </div>

    <hr class="m-3">

    <div class="container">
        <h3 class="m-3"><i class="fas fa-fire-alt"></i> Trending</h3>

        <div class="row pt-3">
            <div class="col-lg-6 mb-4">
                <h4 class="text-center">Games</h4>
                @foreach($recentGames as $league => $leagueGames)
                    <p class="text-secondary">{{ strtoupper($league) }}</p>
                    <ul class="list-group list-group-flush pb-5">
                        @foreach($leagueGames as $game)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <small>{{ $game['date'] }}</small> <a href="{{ $game['url'] }}">{{ $game['awayTeam']['nickname'] }} {{ $game['awayTeam']['score'] }} @ {{ $game['homeTeam']['nickname'] }} {{ $game['homeTeam']['score'] }}</a> <span class="badge badge-secondary badge-pill">{{ $game['highlightCount'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>

            {{--<div class="col-lg-4 mb-4">--}}
                {{--<h4 class="text-center pt-2">Teams</h4>--}}
                {{--@foreach($popularTeams as $league => $leagueTeams)--}}
                    {{--<p class="text-secondary">{{ strtoupper($league) }}</p>--}}
                    {{--<ul class="list-group list-group-flush pb-5">--}}
                        {{--@foreach($leagueTeams as $team)--}}
                            {{--<li class="list-group-item d-flex justify-content-between align-items-center"><a href="{{ $team['url'] }}">{{ $team['name'] }}</a></li>--}}
                        {{--@endforeach--}}
                    {{--</ul>--}}
                {{--@endforeach--}}
            {{--</div>--}}

            <div class="col-lg-6">
                <h4 class="text-center mb-2">Players</h4>
                @foreach($popularPlayers as $league => $leaguePlayers)
                    <p class="text-secondary">{{ strtoupper($league) }}</p>
                    <ul class="list-group list-group-flush pb-5">
                        @foreach($leaguePlayers as $player)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ $player['url'] }}">{{ $player['name'] }}</a> <span class="badge badge-primary badge-pill">{{ $player['highlightCount'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                 @endforeach
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

        function SelectAll(id)
        {
            document.getElementById(id).focus();
            document.getElementById(id).select();
        }
    </script>
@endpush