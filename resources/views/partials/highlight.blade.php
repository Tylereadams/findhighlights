<div class="card is-shady">
    <div class="card-image">
            <video class="image" controls>
                <source src="{{ $highlight->url() }}" poster="{{ str_replace('.jpg', '.png', $highlight->media_url) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
    </div>
        <footer class="card-footer">
            <div class="card-footer-item" style="justify-content: left;">
                @if($highlight->players->count())
                    @foreach($highlight->players as $player)
                        <a href="{{ $player->url() }}" class="tag is-link">{{ $player->getFullName() }}</a>&nbsp;
                    @endforeach
                @endif
                    <a href="{{ $highlight->game->league->url() }}" class="tag is-link">{{ strtoupper($highlight->game->league->name) }}</a>&nbsp;
                    <a href="{{ $highlight->team->url() }}" class="tag is-link">{{ $highlight->team->nickname }}</a>
            </div>
        </footer>
</div>