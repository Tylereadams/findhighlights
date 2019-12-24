<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div>
        <a class="navbar-brand" href="/"><i class="fas fa-video"></i></a>
    </div>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item {{ $activeTab == 'nba' ? 'active' : '' }} px-2">
                <a class="nav-link" href="{{ url('/NBA') }}">{{--<i class="fas fa-basketball-ball"></i> --}}NBA</a>
            </li>
            <li class="nav-item {{ $activeTab == 'nfl' ? 'active' : '' }} px-2">
                <a class="nav-link" href="{{ url('/NFL') }}">{{--<i class="fas fa-football-ball"></i>--}}NFL</a>
            </li>
            <li class="nav-item {{ $activeTab == 'mlb' ? 'active' : '' }} px-2">
                <a class="nav-link" href="{{ url('/MLB') }}">{{--<i class="fas fa-baseball-ball"></i>--}}MLB</a>
            </li>
            <li class="nav-item {{ $activeTab == 'nhl' ? 'active' : '' }} px-2">
                <a class="nav-link" href="{{ url('/NHL') }}">{{--<i class="fas fa-hockey-puck"></i>--}}NHL</a>
            </li>
        </ul>
    </div>

</nav>

@if(!Route::is('welcome'))
<nav class="navbar navbar-expand-lg navbar-light bg-light  p-0 m-0">
    <div class="col-12  px-0 mx-0">
        @include('includes.search-bar')
    </div>
</nav>
@endif