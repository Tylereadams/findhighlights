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

            @include('includes.search-bar')

            <div class="columns features">
                <div class="column is-3 has-text-centered">
                    <h2 class="title">
                        <a href="/nba">
                            <i class="fas fa-basketball-ball"></i><br>
                            NBA
                        </a>
                    </h2>
                </div>
                <div class="column is-3 has-text-centered">
                    <h2 class="title">
                        <a href="/nfl">
                            <i class="fas fa-football-ball"></i><br>
                            NFL
                        </a>
                    </h2>
                </div>
                <div class="column is-3 has-text-centered">
                    <h2 class="title">
                        <a href="/mlb">
                            <i class="fas fa-baseball-ball"></i><br>
                            MLB
                        </a>
                    </h2>
                </div>
                <div class="column is-3 has-text-centered">
                    <h2 class="title">
                        <a href="/nhl">
                            <i class="fas fa-hockey-puck"></i><br>
                            NHL
                        </a>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {{--<section class="container">--}}
        {{--<div class="intro column is-8 is-offset-2">--}}
            {{--<h2 class="title">Perfect for developers or designers!</h2><br>--}}
            {{--<p class="subtitle">Vel fringilla est ullamcorper eget nulla facilisi. Nulla facilisi nullam vehicula ipsum a. Neque egestas congue quisque egestas diam in arcu cursus.</p>--}}
        {{--</div>--}}
        {{--<div class="sandbox">--}}
            {{--<div class="tile is-ancestor">--}}
                {{--<div class="tile is-parent is-shady">--}}
                    {{--<article class="tile is-child notification is-white">--}}
                        {{--<p class="title">Hello World</p>--}}
                        {{--<p class="subtitle">What is up?</p>--}}
                    {{--</article>--}}
                {{--</div>--}}
                {{--<div class="tile is-parent is-shady">--}}
                    {{--<article class="tile is-child notification is-white">--}}
                        {{--<p class="title">Foo</p>--}}
                        {{--<p class="subtitle">Bar</p>--}}
                    {{--</article>--}}
                {{--</div>--}}
                {{--<div class="tile is-parent is-shady">--}}
                    {{--<article class="tile is-child notification is-white">--}}
                        {{--<p class="title">Third column</p>--}}
                        {{--<p class="subtitle">With some content</p>--}}
                        {{--<div class="content">--}}
                            {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.</p>--}}
                        {{--</div>--}}
                    {{--</article>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
@stop