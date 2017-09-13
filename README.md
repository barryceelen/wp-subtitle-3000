# WordPress Subtitle Plugin

[![Build Status](https://travis-ci.org/barryceelen/wp-subtitle-3000.svg?branch=master)](https://travis-ci.org/barryceelen/wp-subtitle-3000)

Add a subtitle input field to the post edit screen.   
Register your custom post types with 'subtitle' support or add post type support via a filter:

```
add_action( 'init', 'prefix_add_subtitle_support' );

/**
 * Add a subtitle input field to the post and page admin screen.
 */
function prefix_add_subtitle_support() {

	$post_types = array( 'post', 'page' );

	foreach( $post_types as $post_type ) {
		add_post_type_support( $post_type, 'subtitle' );
	}
}
```