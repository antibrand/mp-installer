/**
 * MP Installer UI scripts
 *
 * @since 1.0.0
 */
jQuery( document ).ready( function() {

	jQuery( '#mp-install .handlediv' ).click(function() {
		jQuery(this).parent().toggleClass( 'closed' );
	});

	jQuery( '#mpi-collapse' ).click(function() {
		jQuery( '#mp-install .postbox' ).addClass( 'closed' );
	});

	jQuery( '#mpi-expand' ).click(function() {
		jQuery( '#mp-install .postbox' ).removeClass( 'closed' );
	});

	var thspar = jQuery( '#mp-install a' ).attr( 'target','_parent' );

	jQuery( thspar ).parent( 'p' ).not( '.not-found' ).hide();
});

function valid_extension() {

	var extension  = new Array();
	var fieldvalue = document.form_expImp.mpi_expfileUp.value;
	extension[0]   = ".mpi";
	var thisext    = fieldvalue.substr( fieldvalue.lastIndexOf( '.' ) );

	for ( var i = 0; i < extension.length; i++ ) {

		if ( thisext == extension[i] ) {
			return true;
		}
	}

	alert( 'Please upload vaild .mpi extension file.' );

	return false;
}

function valid_zipfile( mpi_eleId ) {

	var	extension = '.zip';
	var inp       = document.getElementById( mpi_eleId );
	var count     = inp.files.length;

	for ( var a=0; a < count; a++ ) {

		var fieldvalue = inp.files.item( a ).name;
		var thisext    = fieldvalue.substr( fieldvalue.lastIndexOf( '.' ) );

		if ( thisext == extension ) {
			return true;
		}
	}

	alert( 'Please upload vaild .zip extension file.' );

	return false;
}

function mpi_delcfirm() {
	var mpi_agree = confirm( 'Are you sure you want to delete file.' );
	return mpi_agree;
}
