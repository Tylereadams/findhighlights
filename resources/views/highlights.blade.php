@extends('layouts.app')

@section('metaTags')
    @include('includes/metaTags', $metaTags)
@endsection

@section('content')
    <section class="container">

        @include('includes.search-bar')

        <nav class="breadcrumb navbar has-background-white" aria-label="breadcrumbs">
            <div class="navbar-item" style="float:left;">
                <div class="control navbar-start has-icons-left is-size-4">
                    <ul>
                        @foreach($breadcrumbs as $key => $breadcrumb)
                            <li>
                                @if($loop->last)
                                    <a href="{{ $breadcrumb['url'] }}" class="has-text-weight-bold has-text-dark">{{ $breadcrumb['name'] }}</a>
                                @else
                                    <a href="{{ $breadcrumb['url'] }}" class="has-text-dark">{{ $breadcrumb['name'] }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>

        <div class="hero-body">
            @foreach($groupedHighlights as $date => $groupedByGameHighlights)
                <h4 class="subtitle is-4 has-text-grey-light">{{ $date }}</h4>

                @foreach($groupedByGameHighlights as $gameHighlights)
                        <hr>
                    <h3 class="title is-3"><a href="{{ $gameHighlights->first()->game->url() }}" class="has-text-dark">{{ $gameHighlights->first()->game->title() }}</a></h3>

                    @foreach($gameHighlights->chunk(2) as $key => $chunk)
                        <div class="columns">
                            @foreach($chunk as $highlight)
                                <div class="column">
                                    @include('partials.highlight')
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endforeach

            @endforeach
        </div>

        <div>
            {{ $highlightsPaginated->links('vendor.pagination.bulma') }}

        </div>

    </section>

@stop

@push('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
    <script>
        $(function(){

            var clipboard = new Clipboard('.button');

            @foreach($breadcrumbs as $key => $breadcrumb)
                // bind change event to select
                $('#{{ str_slug($breadcrumb['name']) }}-select').on('change', function () {
                    var url = $(this).val(); // get selected value
                    if (url) { // require a URL
                        window.location = url; // redirect
                    }
                    return false;
                });
            @endforeach
        });
    </script>
@endpush