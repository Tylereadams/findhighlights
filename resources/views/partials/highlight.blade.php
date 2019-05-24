<div class="card is-shady">
    <div class="card-image">
            <video class="image" poster="{{ $highlight->media_url }}" controls>
                <source src="{{ $highlight->url() }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
    </div>
        <footer class="card-footer">
            <div class="card-footer-item" style="justify-content: left; display: inline;">
                @if($highlight->players->count())
                    @foreach($highlight->players as $player)
                        <a href="{{ $player->url() }}" class="tag is-large is-primary button is-link is-outlined">{{ $player->getFullName() }}</a>&nbsp;
                    @endforeach
                @endif
                    <a href="{{ $highlight->game->league->url() }}" class="tag is-large button is-link is-outlined">{{ strtoupper($highlight->game->league->name) }}</a>&nbsp;
                    <a href="{{ $highlight->team->url() }}" class="tag is-large button is-link is-outlined">{{ $highlight->team->nickname }}</a>
            </div>
        </footer>
</div>