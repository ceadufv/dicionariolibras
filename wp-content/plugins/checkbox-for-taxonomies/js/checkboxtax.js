(function($) {

	/*
	 * Quick Edit
	 */

	$( '#the-list' ).on( 'click', 'a.editinline', function(){

		// reset
		inlineEditPost.revert();

		// get the post ID
		var post_id = inlineEditPost.getId(this);

		rowData = $('#inline_'+ post_id);

		// hierarchical taxonomies (we're treating all checkbox taxes as hierarchical)
		$('.post_category', rowData).each(function(){ 

			var taxonomy;
			var term_ids = $(this).text();

			term_ids = term_ids.trim() !== '' ? term_ids.trim() : '0';

			// protect against multiple taxonomies (which are separated with a comma , )
			// this should be overkill, but just in case
			var term_id = term_ids.split(",");
			term_id = term_id ? term_id[0] : '0';

			taxonomy = $(this).attr('id').replace('_'+post_id, '');

			$('li#'+taxonomy+'-'+term_id ).find('input:checkbox').first().prop('checked', true );

		});

	});

	/*
	 * Bulk Edit
	 */
	$('#doaction, #doaction2').click(function(e){
		var n = $(this).attr('id').substr(2);
		if ( 'edit' === $( 'select[name="' + n + '"]' ).val() ) {
			e.preventDefault();
			$( '.cat-checklist' ).each( function() {
				if( $(this).find( 'input[type="checkbox"]' ).length ) {
					$(this).find( 'input[type="checkbox"]' ).prop('checked', false );
					$(this).prev( 'input' ).remove(); // remove the hidden tax_input input, prevents WP from running its default save routine
				}
			});
		} 
	});


	/*
	 * SINGLE POST SCREEN
	 */

	// taxonomy metaboxes
	$('.checkbox-for-taxonomies').each( function(){
		var this_id = $(this).attr('id'), taxonomyParts, taxonomy;

		taxonomyParts = this_id.split('-');
		taxonomyParts.shift();
		taxonomy = taxonomyParts.join('-');

		//fix for checkbox- if click on popular select on all and vice versa
        $('#' + taxonomy + '-all li :checkbox, #' + taxonomy + '-pop li :checkbox').on('click', function(){
            var t = $(this), c = t.is(':checked'), id = t.val();
            $('#' + taxonomy + '-all li :checkbox, #' + taxonomy + '-pop li :checkbox').prop('checked',false);
            $('#' + taxonomy + '-all li :checkbox[value="'+id+'"], #' + taxonomy + '-pop li :checkbox[value="'+id+'"]').prop( 'checked', c );
	    });  //end on checkbox click

	}); // end taxonomy metaboxes



})(jQuery);