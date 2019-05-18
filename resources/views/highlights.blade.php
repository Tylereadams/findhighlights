@extends('layouts.app')

@section('content')
    <section class="container">

        @include('includes.search-bar')

        <nav class="breadcrumb navbar" aria-label="breadcrumbs">
            <div class="navbar-item" style="float:left;">
                <div class="control navbar-start has-icons-left">
                    <ul>
                        @foreach($breadcrumbs as $key => $breadcrumb)
                            <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>

        <div class="hero-body">
            @foreach($groupedHighlights as $date => $groupedByGameHighlights)
                <h3 class="title">{{ $date }}</h3>

                @foreach($groupedByGameHighlights as $gameHighlights)
                        <hr>
                    <h5 class="subtitle is-5">{{ $gameHighlights->first()->game->title() }}</h5>

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

        {{ $highlightsPaginated->links('vendor.pagination.bulma') }}

    </section>

@stop

@push('scripts')
    <script>
        $(function(){
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