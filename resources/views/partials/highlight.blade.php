<div class="card is-shady">
    <header class="card-header">
        <div class="card-header-title">
            <a href="{{ $highlight->game->url() }}">
                <small>{{ $highlight->game->awayTeam->nickname  }} vs {{ $highlight->game->homeTeam->nickname }}</small>
            </a>
        </div>
    </header>
    <div class="card-image">
        <video controls>
            <source src="{{ $highlight->url() }}" poster="{{ $highlight->image_url }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    @if($highlight->players->count())
        <footer class="card-footer">
            <div class="card-footer-item" style="justify-content: left;">
                @foreach($highlight->players as $player)
                    @if($loop->first)
                        <i class="fas fa-tag{{ $loop->count > 1 ? 's' : '' }}"></i>&nbsp;
                    @endif
                    <a href="{{ $player->url() }}"><small>{{ $player->getFullName() }}</small></a>@if (!$loop->last),&nbsp;@endif
                @endforeach
            </div>
        </footer>
    @endif
</div>