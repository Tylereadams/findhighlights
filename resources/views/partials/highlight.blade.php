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

    <footer class="card-footer">
                <div class="card-footer-item" style="display: inline;">

                    <div class="field has-addons has-margin-bottom-xs">
                        <p class="control">
                            <span class="button is-light" data-clipboard-target="#copy-text-gif-{{ $highlight->id }}">Gif</span>
                        </p>
                        <p class="control is-expanded">
                            <input class="input" type="text" id="copy-text-gif-{{ $highlight->id }}" onClick="SelectAll('copy-text-gif-{{ $highlight->id }}');" value="{{ $highlight->gifUrl() }}" readonly>
                        </p>
                        <p class="control">
                            <a class="button is-light" data-clipboard-target="#copy-text-gif-{{ $highlight->id }}">
                                <i class="far fa-copy"></i>
                            </a>
                        </p>
                    </div>

                    <div class="field has-addons">
                        <p class="control">
                            <span class="button is-light" data-clipboard-target="#copy-text-mp4-{{ $highlight->id }}">MP4</span>
                        </p>
                        <p class="control is-expanded">
                            <input class="input" type="text" id="copy-text-mp4-{{ $highlight->id }}" data-clipboard-target="#copy-text-mp4-{{ $highlight->id }}" onClick="SelectAll('copy-text-mp4-{{ $highlight->id }}');" value="{{ $highlight->url() }}" readonly>
                        </p>
                        <p class="control">
                            <a class="button is-light" data-clipboard-target="#copy-text-mp4-{{ $highlight->id }}">
                                <i class="far fa-copy"></i>
                            </a>
                        </p>
                    </div>
                </div>
    </footer>
</div>