( function( $ ) {

    var bind_ids = [];

    $( document ).ajaxComplete(function() {
        $('.js-types-and-terms').each(function( index ) {
            $(this).select2();
        });
    });

    $( document ).on( "click",".widget[id*='dd_last_viewed-']", function() {
        var $this = $(this),
            thisID = $this.attr('id');

        if($.inArray(thisID, bind_ids) == -1) {
            $this.find('.js-types-and-terms').select2();
            bind_ids.push(thisID);
        }

    });

    
    $(document).on('click','.dd-switch', function(){
        $(this).toggleClass('on');
        $(this).next('input').trigger('click');
    });

    $(document).on('click','.lv_link', function(){
        $(this).toggleClass('button-primary');
        $(this).next('input').trigger("click");
    });
    
    $(document).on('click','.js-collapse', function(e){
        e.preventDefault();
        
        $(this).next().toggleClass('visible');
    });

} )( jQuery );