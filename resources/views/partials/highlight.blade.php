<div class="card">
    <video class="card-img-top" poster="{{ $highlight->media_url }}" controls>
    <source src="{{ $highlight->url() }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="card-body">

        <div class="input-group input-group-sm mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <a class="button" data-clipboard-target="#copy-text-gif-{{ $highlight->id }}">
                        GIF
                    </a>
                </span>
            </div>
            <input type="text" class="form-control bg-white inp" id="copy-text-gif-{{ $highlight->id }}" onClick="SelectAll('copy-text-gif-{{ $highlight->id }}');" value="{{ $highlight->gifUrl() }}" readonly>

            <div class="input-group-append">
                <span class="input-group-text">
                    <a class="button" data-clipboard-target="#copy-text-gif-{{ $highlight->id }}">
                        <i class="far fa-copy"></i>
                    </a>
                </span>
            </div>
        </div>

        <div class="input-group input-group-sm mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <a class="button" data-clipboard-target="#copy-text-mp4-{{ $highlight->id }}">
                        MP4
                    </a>
                </span>
            </div>
            <input type="text" class="form-control bg-white"  id="copy-text-mp4-{{ $highlight->id }}" onClick="SelectAll('copy-text-gif-{{ $highlight->id }}');" value="{{ $highlight->url() }}" readonly>
            <div class="input-group-append">
                <span class="input-group-text">
                    <a class="button" data-clipboard-target="#copy-text-mp4-{{ $highlight->id }}">
                        <i class="far fa-copy"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="card-footer p-2 bg-white">
        @if($highlight->players->count())
            @foreach($highlight->players as $player)
                <span class="badge badge-light">
                        <a href="{{ $player->url() }}" class="tag is-large is-primary button is-link is-outlined">{{ $player->getFullName() }}</a>&nbsp;
                    </span>
            @endforeach
        @endif

        <span class="badge badge-light">
                <a href="{{ $highlight->game->league->url() }}" class="tag is-large button is-link is-outlined">{{ strtoupper($highlight->game->league->name) }}</a>&nbsp;
            </span>
        <span class="badge badge-light">
                <a href="{{ $highlight->team->url() }}" class="tag is-large button is-link is-outlined">{{ $highlight->team->nickname }}</a>
            </span>
    </div>
</div>