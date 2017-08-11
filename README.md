# WordPress Subtitle Plugin
Add a subtitle input field to the post edit screen.   
Register your custom post types with 'subtitle' support or add post type support via a filter: 

```
	// Add subtitle input field to the admin screen by adding post type support. 
	add_action( 'init', 'prefix_add_subtitle_support' );

	function prefix_add_subtitle_support() {

		$post_types = array( 'post', 'page' );

		foreach( $post_types as $post_type ) {
			add_post_type_support( $post_type, 'subtitle' );
		}
	}
```