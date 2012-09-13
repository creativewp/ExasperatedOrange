<?php
require_once ( get_template_directory() . '/theme-options.php' );
register_nav_menu( 'Left Sidebar', 'Menu for the left sidebar' ); 

$header_args = array(
	'width' => 300,
	'height' => 100,
	'header-text' => false
	);
add_theme_support( 'custom-header', $header_args );
add_theme_support( 'custom-background');
add_theme_support( 'menus' );

add_action('init', 'load_scripts');
add_action('init', 'theme_widgets_init' );
add_action('admin_menu', 'offcanvas_admin');
add_action('customize_register', 'offcanvas_customize_register' );

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'offcanvas-theme', TEMPLATEPATH . '/languages' );
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
  require_once($locale_file);






// Function to load scripts...
function load_scripts() {
  //$path = get_bloginfo('template_directory');
  wp_enqueue_script('jquery');
  //wp_enqueue_script('theme_javascript',  $path . '/theme.js', array('jquery'));
}

// Add things to the Admin Menu
function offcanvas_admin() {
  // add the Customize link to the admin menu
  add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}

//  Add options to the Customizer screen
function offcanvas_customize_register($wp_customize) {
 // Title Color (added to Color Scheme section in Theme Customizer)
  $wp_customize->add_setting( 'offcanvas_title_color', array(
   // 'default'           => '#000',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'sanitize_hex_color',
  
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'title_color', array(
  'label'    => __( 'Title Color', 'offcanvas' ),
  'section'  => 'colors',
  'settings' => 'offcanvas_title_color',
  ) ) );

  // Link Color (added to Color Scheme section in Theme Customizer)
  $wp_customize->add_setting( 'offcanvas_link_color', array(
   // 'default'           => '#000',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'sanitize_hex_color',
  
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
  'label'    => __( 'Link Color', 'offcanvas' ),
  'section'  => 'colors',
  'settings' => 'offcanvas_link_color',
  ) ) );
}


// Register widgetized areas
function theme_widgets_init() {
  // Left Sidebar
  register_sidebar( array (
    'name' => 'Left Sidebar Widget Area',
    'id' => 'left_sidebar_widget_area',
    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    'after_widget' => "</li>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ) );

  // Right Sidebar
  register_sidebar( array (
    'name' => 'Right Sidebar Widget Area',
    'id' => 'right_sidebar_widget_area',
    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    'after_widget' => "</li>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ) );
} // end theme_widgets_init


	
	$preset_widgets = array (
	    'left_sidebar_widget_area'  => array( 'search', 'meta' ),
	    'right_sidebar_widget_area'  => array( 'links', 'pages', 'categories', 'archives' )
	);
	if ( isset( $_GET['activated'] ) ) {
	    update_option( 'sidebars_widgets', $preset_widgets );
	}
	// update_option( 'sidebars_widgets', NULL );
	
	// Check for static widgets in widget-ready areas
	function is_sidebar_active( $index ){
	  global $wp_registered_sidebars;

	  $widgetcolums = wp_get_sidebars_widgets();

	  if ($widgetcolums[$index]) return true;

	    return false;
	} // end is_sidebar_active



// Get the page number
function get_page_number() {
  if ( get_query_var('paged') ) {
    print ' | ' . __( 'Page ' , 'offcanvas-theme') . get_query_var('paged');
  }
} // end get_page_number



	// Custom callback to list comments in the offcanvas-theme style
	function custom_comments($comment, $args, $depth) {
	  $GLOBALS['comment'] = $comment;
	    $GLOBALS['comment_depth'] = $depth;
	  ?>
	    <li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
	        <div class="comment-author vcard"><?php commenter_link() ?></div>
	        <div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'offcanvas-theme'),
	                    get_comment_date(),
	                    get_comment_time(),
	                    '#comment-' . get_comment_ID() );
	                    edit_comment_link(__('Edit', 'offcanvas-theme'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
	  <?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'offcanvas-theme') ?>
	          <div class="comment-content">
	            <?php comment_text() ?>
	        </div>
	        <?php // echo the comment reply link
	            if($args['type'] == 'all' || get_comment_type() == 'comment') :
	                comment_reply_link(array_merge($args, array(
	                    'reply_text' => __('Reply','offcanvas-theme'),
	                    'login_text' => __('Log in to reply.','offcanvas-theme'),
	                    'depth' => $depth,
	                    'before' => '<div class="comment-reply-link">',
	                    'after' => '</div>'
	                )));
	            endif;
	        ?>
	<?php } // end custom_comments
	
	// Custom callback to list pings
	function custom_pings($comment, $args, $depth) {
	       $GLOBALS['comment'] = $comment;
	        ?>
	            <li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
	                <div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'offcanvas-theme'),
	                        get_comment_author_link(),
	                        get_comment_date(),
	                        get_comment_time() );
	                        edit_comment_link(__('Edit', 'offcanvas-theme'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
	    <?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'offcanvas-theme') ?>
	            <div class="comment-content">
	                <?php comment_text() ?>
	            </div>
	<?php } // end custom_pings
	
	// Produces an avatar image with the hCard-compliant photo class
	function commenter_link() {
	    $commenter = get_comment_author_link();
	    if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
	        $commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	    } else {
	        $commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	    }
	    $avatar_email = get_comment_author_email();
	    $avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
	    echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
	} // end commenter_link
	
	// For category lists on category archives: Returns other categories except the current one (redundant)
	function cats_meow($glue) {
	    $current_cat = single_cat_title( '', false );
	    $separator = "\n";
	    $cats = explode( $separator, get_the_category_list($separator) );
	    foreach ( $cats as $i => $str ) {
	        if ( strstr( $str, ">$current_cat<" ) ) {
	            unset($cats[$i]);
	            break;
	        }
	    }
	    if ( empty($cats) )
	        return false;

	    return trim(join( $glue, $cats ));
	} // end cats_meow
	
	// For tag lists on tag archives: Returns other tags except the current one (redundant)
	function tag_ur_it($glue) {
	    $current_tag = single_tag_title( '', '',  false );
	    $separator = "\n";
	    $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	    foreach ( $tags as $i => $str ) {
	        if ( strstr( $str, ">$current_tag<" ) ) {
	            unset($tags[$i]);
	            break;
	        }
	    }
	    if ( empty($tags) )
	        return false;

	    return trim(join( $glue, $tags ));
	} // end tag_ur_it
	
	
?>