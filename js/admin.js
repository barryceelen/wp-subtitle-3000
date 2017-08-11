/* global tinymce */
(function ($) {
	'use strict';
	$(function () {

		// Clone of wptitlehint() function in post.js.
		var wptitlehint = function( id ) {

			id = id || 'subtitle-input';

			var title = $( '#' + id ), titleprompt = $( '#' + id + '-prompt-text' );

			if ( '' === title.val() ) {
				titleprompt.removeClass( 'screen-reader-text' );
			}

			titleprompt.click( function(){
				$( this ).addClass( 'screen-reader-text' );
				title.focus();
			});

			title.blur( function() {
				if ( '' === this.value ) {
					titleprompt.removeClass( 'screen-reader-text' );
				}
			}).focus( function() {
				titleprompt.addClass( 'screen-reader-text' );
			}).keydown( function( e ){
				titleprompt.addClass( 'screen-reader-text' );
				$( this ).unbind( e );
			});
		};

		wptitlehint();

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
