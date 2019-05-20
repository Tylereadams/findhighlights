<div class="field has-addons level ">
    <div class="level-item">
        <div class="control" style="width: 100%;">
            {{--<span class="icon is-left is-medium">--}}
              {{--<i class="fas fa-search fa-2x"></i>--}}
            {{--</span>--}}
            <input id="search" class="input is-info has-padding-lg is-medium" type="text" placeholder="Ex: 'Browns', 'Baker Mayfield' or 'Warriors vs Rockets'">
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function(){

            $.widget( "custom.catcomplete", $.ui.autocomplete, {
                _create: function() {
                    this._super();
                    this.widget().menu( "option", "items", "> :not(.dropdown-header)" );
                },
                _renderMenu: function( ul, items ) {
                    var that = this,
                        currentCategory = "";

                    $.each( items, function( index, item ) {
                        var li;
                        if ( item.category != currentCategory ) {
                            ul.append( "<li class='dropdown-header' id='"+ item.label +"'>" + item.category + "</li>" );
                            currentCategory = item.category;
                        }

                        li = that._renderItemData( ul, item );
                        if ( item.category ) {
                            li.attr( "aria-label", item.category + " : " + item.label );
                            li.children(":first").attr( "class", "dropdown-item is-size-5");
                            if(item.icon){
                                li.children(":first").prepend(item.icon + " ");
                            }
                        }
                    });
                }
            });

            var cache = {};

            $( "#search" ).catcomplete({
                delay: 1,
                minLength: 2,
                source: function( request, response ) {
                    var term = request.term;
                    if ( term in cache ) {
                        response( cache[ term ] );
                        return;
                    }

                    $.getJSON( "/autocomplete", request, function( data, status, xhr ) {
                        cache[ term ] = data;
                        response( data );
                    });
                },
                open: function(event, ui) {
                    $('.dropdown-header').off('menufocus hover mouseover mouseenter');
                },
                select: function( event, ui ) {
                    window.location.href = ui.item.url;
                }
            });
        });
    </script>
@endpush