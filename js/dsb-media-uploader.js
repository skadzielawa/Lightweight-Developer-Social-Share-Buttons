jQuery( function($){
	// on upload button click
	$( 'body' ).on( 'click', '.dsb-upload', function( event ){
		event.preventDefault(); // prevent default link click and page refresh
		
		const button = $(this)
		const imageId = button.next().next().val();
		
		const custom_uploader = wp.media({
			title: 'Insert image', // modal window title
			library : {
				// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false
		}).on( 'select', function() { // it also has "open" and "close" events
			const attachment = custom_uploader.state().get( 'selection' ).first().toJSON();
			button.removeClass( 'button' ).html( '<img src="' + attachment.url + '">'); // add image instead of "Upload Image"
			button.next().show(); // show "Remove image" link
			button.next().next().val( attachment.id ); // Populate the hidden field with image ID
		})
		
		// already selected images
		custom_uploader.on( 'open', function() {

			if( imageId ) {
			  const selection = custom_uploader.state().get( 'selection' )
			  attachment = wp.media.attachment( imageId );
			  attachment.fetch();
			  selection.add( attachment ? [attachment] : [] );
			}
			
		})

		custom_uploader.open()
	
	});
	// on remove button click
	$( 'body' ).on( 'click', '.dsb-remove', function( event ){
		event.preventDefault();
		const button = $(this);
		button.next().val( '' ); // emptying the hidden field
		button.hide().prev().addClass( 'button' ).html( 'Upload image' ); // replace the image with text
	});
});