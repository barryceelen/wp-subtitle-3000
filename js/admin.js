/* global tinymce, wptitlehint */
(function ($) {
	'use strict';
	$(function () {

		if ( $.isFunction( wptitlehint ) ) {
			wptitlehint( 'subtitle-input' );
		}

		// Tab from the title to the subtitle, rather than the post content.
		$( '#title' ).on( 'keydown.editor-focus', function( event ) {
			if ( 9 === event.keyCode && ! event.ctrlKey && ! event.altKey && ! event.shiftKey ) {
				$( '#subtitle-input' ).focus();
				event.preventDefault();
			}
		});

		// Tab from the subtitle to the post content.
		$( '#subtitle-input' ).on( 'keydown.editor-focus', function( event ) {

			var editor, $textarea = $( '#content' );

			if ( event.keyCode === 9 && ! event.ctrlKey && ! event.altKey && ! event.shiftKey ) {
				editor = typeof tinymce !== 'undefined' && tinymce.get( 'content' );

				if ( editor && ! editor.isHidden() ) {
					editor.focus();
				} else if ( $textarea.length ) {
					$textarea.focus();
				} else {
					return;
				}

				event.preventDefault();
			}
		});
	});
}(jQuery));
