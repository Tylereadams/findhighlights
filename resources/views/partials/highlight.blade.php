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
                            <span class="button" data-clipboard-target="#copy-text-gif-{{ $highlight->id }}">Gif</span>
                        </p>
                        <p class="control is-expanded">
                            <input class="input" type="text" id="copy-text-gif-{{ $highlight->id }}" value="{{ $highlight->gifUrl() }}" readonly>
                        </p>
                        <p class="control">
                            <a class="button" data-clipboard-target="#copy-text-gif-{{ $highlight->id }}">
                                Copy
                            </a>
                        </p>
                    </div>

                    <div class="field has-addons">
                        <p class="control">
                            <span class="button" data-clipboard-target="#copy-text-mp4-{{ $highlight->id }}">MP4</span>
                        </p>
                        <p class="control is-expanded">
                            <input class="input" type="text" id="copy-text-mp4-{{ $highlight->id }}" value="{{ $highlight->url() }}" readonly>
                        </p>
                        <p class="control">
                            <a class="button" data-clipboard-target="#copy-text-mp4-{{ $highlight->id }}">
                                Copy
                            </a>
                        </p>
                    </div>


                    {{----}}
                    {{--<div class="is-one-fifth">--}}
                        {{--Gif: &nbsp;--}}
                        {{--<input type="text" class="input" style="width: 60%" id="copy-text-gif-{{ $highlight->id }}" value="{{ $highlight->gifUrl() }}" readonly>--}}
                        {{--<a class="button has-text-centered" data-clipboard-target="#copy-text-gif-{{ $highlight->id }}">Copy</a>--}}
                    {{--</div>--}}
                    {{--<div class="is-one-fifth">--}}
                        {{--MP4: &nbsp;--}}
                        {{--<input type="text" class="input" style="width: 60%" id="copy-text-mp4-{{ $highlight->id }}" value="{{ $highlight->url() }}" readonly>--}}
                        {{--<a class="button has-text-centered" data-clipboard-target="#copy-text-mp4-{{ $highlight->id }}">Copy</a>--}}
                    {{--</div>--}}
                </div>
            {{--<div class="column">--}}
                {{--<div class="field">--}}
                    {{--<div class="field-label is-normal">--}}
                        {{--<label class="label">GIF</label>--}}
                    {{--</div>--}}
                    {{--<div class="field-body">--}}
                        {{--<div class="field">--}}
                            {{--<p class="control">--}}
                                {{--<input class="input" type="email" value="{{ $highlight->gifUrl() }}" width="3" disabled>&nbsp;<i class="far fa-copy"></i>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="column">--}}
                {{--<label>MP4:</label><input type="text" value="{{ $highlight->url() }}" disabled>&nbsp;<i class="far fa-copy"></i>--}}
            {{--</div>--}}
            {{----}}
    </footer>
</div>