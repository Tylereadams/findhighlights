@extends('layouts.app')

@section('metaTags')
    @include('includes/metaTags', $metaTags)
@endsection

@section('content')
    <section class="container">

        <nav aria-label="breadcrumb" class="pt-2">
            <ol class="breadcrumb bg-white">
                @foreach($breadcrumbs as $key => $breadcrumb)
                    <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}" aria-current="page"><a href="{{ $breadcrumb['url'] }}" class="text-secondary">{{ $breadcrumb['name'] }}</a></li>
                @endforeach
            </ol>
        </nav>

            @foreach($groupedHighlights as $date => $groupedByGameHighlights)
                @foreach($groupedByGameHighlights as $gameHighlights)
                    <h4 class="title py-2"><a class="text-dark" href="{{ $gameHighlights->first()->game->url() }}">{{ $gameHighlights->first()->game->getTitle() }}</a> <small class="text-secondary">{{ $date }}</small></h4>
                    <div class="card-columns">
                        @foreach($gameHighlights as $highlight)
                                @include('partials.highlight')
                        @endforeach
                    </div>

                    <hr class="pb-5 mt-5">

                @endforeach

            @endforeach

        <div class="row justify-content-center">
            {{ $highlightsPaginated->links('vendor.pagination.simple-bootstrap-4') }}
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

        function SelectAll(id)
        {
            document.getElementById(id).focus();
            document.getElementById(id).select();
        }
    </script>
@endpush