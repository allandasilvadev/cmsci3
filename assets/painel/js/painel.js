autosize(document.querySelectorAll('textarea'));

/* Midias */
jQuery(document).ready(function($){
	jQuery('#uri').change(function(e){
		e.preventDefault();

		let input = this;
		let url = jQuery(this).val();
		let extension = url.substring( url.lastIndexOf('.') + 1 ).toLowerCase();

		if ( input.files && input.files[0] && ( extension == "png" || extension == "jpg" ) ) {	
			let reader = new FileReader();

			reader.onload = function(){
				let dataurl = reader.result;
				jQuery( '#midias-uri' ).css( 'display', 'block' );
				let response = jQuery( '#midias-uri' ).attr( 'src', dataurl );
			}

			reader.readAsDataURL( input.files[0] );
		} else {
			jQuery( '.midias-errors-messages' ).html( '<br><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>O tipo de arquivo informado não é válido.</div>' );
		}
	});
});

/* Posts */
jQuery(document).ready(function($){
	jQuery('#avatar').change(function(e){
		e.preventDefault();

		let input = this;
		let url = jQuery(this).val();
		let extension = url.substring( url.lastIndexOf('.') + 1 ).toLowerCase();

		if ( input.files && input.files[0] && ( extension == "png" || extension == "jpg" ) ) {	
			let reader = new FileReader();

			reader.onload = function(){
				let dataurl = reader.result;
				jQuery( '#midias-uri' ).css( 'display', 'block' );
				let response = jQuery( '#midias-uri' ).attr( 'src', dataurl );
			}

			reader.readAsDataURL( input.files[0] );
		} else {
			jQuery( '.midias-errors-messages' ).html( '<br><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>O tipo de arquivo informado não é válido.</div>' );
		}
	});
});

/* Usuarios */
jQuery(document).ready(function($){
	jQuery('#usuarios-avatar').change(function(e){
		e.preventDefault();

		let input = this;
		let url = jQuery(this).val();
		let extension = url.substring( url.lastIndexOf('.') + 1 ).toLowerCase();

		if ( input.files && input.files[0] && ( extension == "png" || extension == "jpg" ) ) {	
			let reader = new FileReader();

			reader.onload = function(){
				let dataurl = reader.result;
				jQuery( '.usuarios-avatar-src' ).css( 'display', 'block' );
				let response = jQuery( '.usuarios-avatar-src' ).attr( 'src', dataurl );
			}

			reader.readAsDataURL( input.files[0] );
		} else {
			jQuery( '.usuarios-errors-messages' ).html( '<br><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>O tipo de arquivo informado não é válido.</div>' );
		}
	});
});