<?php
/**
 * This makes the child theme work. If you need any
 * additional features or let's say menus, do it here.
 *
 * @return void
 */
function required_starter_themesetup() {

	load_child_theme_textdomain( 'requiredstarter', get_stylesheet_directory() . '/languages' );

	// Register an additional Menu Location
	register_nav_menus( array(
		'meta' => __( 'Meta Menu', 'requiredstarter' )
	) );

	// Add support for custom backgrounds and overwrite the parent backgorund color
	add_theme_support( 'custom-background', array( 'default-color' => 'f7f7f7' ) );

}
add_action( 'after_setup_theme', 'required_starter_themesetup' );


/**
 * With the following function you can disable theme features
 * used by the parent theme without breaking anything. Read the
 * comments on each and follow the link, if you happen to not
 * know what the function is for. Remove the // in front of the
 * remove_theme_support('...'); calls to make them execute.
 *
 * @return void
 */
function required_starter_after_parent_theme_setup() {

	/**
	 * Hack added: 2012-10-04, Silvan Hagen
	 *
	 * This is a hack, to calm down PHP Notice, since
	 * I'm not sure if it's a bug in WordPress or my
	 * bad I'll leave it here: http://wordpress.org/support/topic/undefined-index-custom_image_header-in-after_setup_theme-of-child-theme
	 */
	if ( ! isset( $GLOBALS['custom_image_header'] ) )
		$GLOBALS['custom_image_header'] = array();

	if ( ! isset( $GLOBALS['custom_background'] ) )
		$GLOBALS['custom_background'] = array();

	// Remove custom header support: http://codex.wordpress.org/Custom_Headers
	//remove_theme_support( 'custom-header' );

	// Remove support for post formats: http://codex.wordpress.org/Post_Formats
	//remove_theme_support( 'post-formats' );

	// Remove featured images support: http://codex.wordpress.org/Post_Thumbnails
	//remove_theme_support( 'post-thumbnails' );

	// Remove custom background support: http://codex.wordpress.org/Custom_Backgrounds
	//remove_theme_support( 'custom-background' );

	// Remove automatic feed links support: http://codex.wordpress.org/Automatic_Feed_Links
	//remove_theme_support( 'automatic-feed-links' );

	// Remove editor styles: http://codex.wordpress.org/Editor_Style
	//remove_editor_styles();

	// Remove a menu from the theme: http://codex.wordpress.org/Navigation_Menus
	//unregister_nav_menu( 'secondary' );

}
add_action( 'after_setup_theme', 'required_starter_after_parent_theme_setup', 11 );

/**
 * Add our theme specific js file and some Google Fonts
 * @return void
 */
function required_starter_scripts() {

	/**
	 * Registers the child-theme.js
	 *
	 * Remove if you don't need this file,
	 * it's empty by default.
	 */
	wp_enqueue_script(
		'child-theme-js',
		get_stylesheet_directory_uri() . '/javascripts/child-theme.js',
		array( 'theme-js' ),
		required_get_theme_version( false ),
		true
	);

	/**
	 * Registers the app.css
	 *
	 * If you don't need it, remove it.
	 * The file is empty by default.
	 */
	wp_register_style(
        'app-css', //handle
        get_stylesheet_directory_uri() . '/stylesheets/app.css',
        array( 'foundation-css' ),	// needs foundation
        required_get_theme_version( false ) //version
  	);
  	wp_enqueue_style( 'app-css' );

	/**
	 * Adding google fonts
	 *
	 * This is the proper code to add google fonts
	 * as seen in TwentyTwelve
	 */
	$protocol = is_ssl() ? 'https' : 'http';
	$query_args = array( 'family' => 'Open+Sans:300,600' );
	wp_enqueue_style(
		'open-sans',
		add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ),
		array(),
		null
	);
}
add_action('wp_enqueue_scripts', 'required_starter_scripts');

/**
 * Overwrite the default continue reading link
 *
 * This function is an example on how to overwrite
 * the parent theme function to create continue reading
 * links.
 *
 * @return string HTML link with text and permalink to the post/page/cpt
 */
function required_continue_reading_link() {
	return ' <a class="read-more" href="'. esc_url( get_permalink() ) . '">' . __( ' Read on! &rarr;', 'requiredstarter' ) . '</a>';
}

/**
 * Overwrite the defaults of the Orbit shortcode script
 *
 * Accepts all the parameters from http://foundation.zurb.com/docs/orbit.php#optCode
 * to customize the options for the orbit shortcode plugin.
 *
 * @param  array $args default args
 * @return array       your args
 */
function required_orbit_script_args( $defaults ) {
	$args = array(
		'animation' 	=> 'fade',
		'advanceSpeed' 	=> 8000,
	);
	return wp_parse_args( $args, $defaults );
}
add_filter( 'req_orbit_script_args', 'required_orbit_script_args' );

/**
 * Display Featured Image In Admin Post View
 *
 * 
 *
 * @param  array $args default args
 * @return array       your args
 */

function my_custom_featured_image_column_image( $image ) {
    if ( !has_post_thumbnail() )
        return trailingslashit( get_stylesheet_directory_uri() ) . 'images/no-featured-image';
}
add_filter( 'featured_image_column_default_image', 'my_custom_featured_image_column_image' );

/*############################################################################################
#
#   ADD CUSTOM JS FILES/LIBRARIES(STICKY.JS)
#   //This function adds custom javascript libraries and files
*/

/*---------------------------NOT ENABLED---------------------------*/

function lowermedia_add_theme_js()  
  {  
      // Register and enque sticky.js the script like this for a theme:  
      // Sticky JS http://www.labs.anthonygarand.com/sticky
      wp_register_script( 'sticky', get_stylesheet_directory_uri() . '/js/jquery.sticky.js', array( 'jquery' ), '1.0.0', true);
      wp_register_script( 'run-sticky', get_stylesheet_directory_uri() . '/js/run-sticky.js', array( 'sticky' ), '1.0.0', true);
      wp_enqueue_script( 'run-sticky' );

  }  
//add_action( 'wp_enqueue_scripts', 'lowermedia_add_theme_js' ); 


/*############################################################################################
#
#   ADJUST CUSTOM EXCERPT SETTINGS
#   //
*/

function custom_excerpt_length( $length ) {
	return 50;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

/*--------------------------- ^ ENABLED HERE ^ ---------------------------*/

/*############################################################################################
#
#   ADD PRESS CUSTOM CONTENT TYPE
#   //
*/

function press_custom_init() {
  $labels = array(
    'name' => 'Press Articles',
    'singular_name' => 'Press Article',
    'add_new' => 'Add Press Article',
    'add_new_item' => 'Add New Press Article',
    'edit_item' => 'Edit Press Article',
    'new_item' => 'New Press Article',
    'all_items' => 'All Press Articles',
    'view_item' => 'View Press Article',
    'search_items' => 'Search Press Articles',
    'not_found' =>  'No Press Articles found',
    'not_found_in_trash' => 'No Press Articles found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Press Articles'
  );

  $args = array(
    'labels' => $labels,
    'description'   => 'Water Is My Sky Press Article',
    'menu_position' => 1,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'press-articles' ),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'author', 'thumbnail', 'excerpt', 'comments' ), // 'editor',  ---removed
    'taxonomies' => array('category', 'post_tag')
  ); 

  register_post_type( 'press', $args );
}
add_action( 'init', 'press_custom_init' );


/*
#
#
#
*/

add_action( 'add_meta_boxes', 'lowermedia_add_press_link_meta_boxes' );
/* Create one or more meta boxes to be displayed on the post editor screen. */
function lowermedia_add_press_link_meta_boxes() {

	add_meta_box(
		'lowermedia-press-link',			// Unique ID
		esc_html__( 'Press Article Link', 'example' ),		// Title
		'lowermedia_press_link_meta_box',		// Callback function
		'press',					// Admin page (or post type)
		'normal',					// Context ('side', 'advanced', 'normal')
		'high'					// Priority ('high', 'core', 'default' or 'low')
	);
}

/* Display the post meta box. */
function lowermedia_press_link_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'lowermedia_press_link_link_nonce' ); ?>

	<p>
		<label for="lowermedia-press-link">
			<?php _e( "Add Press Article Link", 'example' ); ?>
		</label>
		<br />
		<br />
		<input style='width:250px' class="widefat" type="text" name="lowermedia-press-link" id="lowermedia-press-link" value="<?php echo esc_attr( get_post_meta( $object->ID, 'lowermedia_press_link_link', true ) ); ?>" size="15" />
	</p>
<?php }

/* Save post meta on the 'save_post' hook. */
add_action( 'save_post', 'lowermedia_save_press_link_link_meta', 10, 2 );

/* Meta box setup function. */
function lowermedia_press_link_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'lowermedia_add_press_link_meta_boxes' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'lowermedia_save_press_link_link_meta', 10, 2 );
}


/* Save the meta box's post metadata. */
function lowermedia_save_press_link_link_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['lowermedia_press_link_link_nonce'] ) || !wp_verify_nonce( $_POST['lowermedia_press_link_link_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	//$new_meta_value = 'http://vimeo.com/';
	//$new_meta_value = ( isset( $_POST['lowermedia-press-link'] ) ? sanitize_html_class( $_POST['lowermedia-press-link'] ) : '' );
	$new_meta_value = ( isset( $_POST['lowermedia-press-link'] ) ?  $_POST['lowermedia-press-link'] : '' );

	/* Get the meta key. */
	$meta_key = 'lowermedia_press_link_link';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}

/* Filter the post class hook with our custom post class function. */
add_filter( 'post_class', 'lowermedia_press_link_link' );
function lowermedia_press_link_link( $classes ) {

	/* Get the current post ID. */
	$post_id = get_the_ID();

	/* If we have a post ID, proceed. */
	if ( !empty( $post_id ) ) {

		/* Get the custom post class. */
		$post_class = get_post_meta( $post_id, 'lowermedia_press_link_link', true );

		/* If a post class was input, sanitize it and add it to the post class array. */
		if ( !empty( $post_class ) )
			$classes[] = sanitize_html_class( $post_class );
	}

	return $classes;
}

