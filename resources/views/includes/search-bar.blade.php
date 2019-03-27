<div class="field has-addons level">
    <div class="level-item has-text-centered" style="width: 100%;">
        <div class="control has-icons-left" style="width: 100%;">
            <span class="icon is-left">
              <i class="fas fa-search"></i>
            </span>
            <input id="search" class="input" type="text" placeholder="Search by team, player, or date to find highlights">
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
                            li.children(":first").attr( "class", "dropdown-item");
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