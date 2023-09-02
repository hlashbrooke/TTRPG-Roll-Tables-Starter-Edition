jQuery( function() {

	var table_ref;
	var result_container;
	var roll_result;

	jQuery( '.rolltable_button' ).on( 'click', function(e) {

		table_ref = jQuery( this ).data( 'ref' );
		result_container = jQuery( '#' + table_ref + '-result' );

		result_container.html( '<em style="opacity:0.4;">' + roll_table.rolling + '</em>' );

		roll_result = roll_table.error_message;

		jQuery.ajax({
		    url : roll_table.ajax_url,
		    type : 'post',
		    data : {
		        action : 'do_roll',
		        nonce : roll_table.nonce,
		        ref : table_ref
		    },
		    success : function( response ) {
		    	result_container.shuffleLetters({
					"text": response,
					"step": 2,
					"fps": 15
				});
		    },
		    fail : function( resopnse ) {
		    	result_container.shuffleLetters({
					"text": roll_result,
					"step": 2,
					"fps": 15
				});
		    }
		});

		return false;
	});

});