<!DOCTYPE html>
<html id="doc" class="no-js" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0;">	
    <title><?php
        if ( is_single() ) { single_post_title(); }
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . esc_html($s); get_page_number(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); get_page_number(); }
    ?></title>

    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
 
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />

    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

    <?php wp_head(); ?>

    <?php
      $options = get_option('theme_offcanvas_options');
      if (($options['enable_mobile_background']) == "1") {
        echo '<style type="text/css"> @media all and (max-width: 599px) { ';
        if (($options['mobile_background_type']) == "solid") {
         echo "body {background-image: none !important;}";
        } else {
          if (($options['mobile_background_img']) != "") {
            echo "body {background-image: url('" . $options['mobile_background_img'] ."') !important; ";
          
            switch ($options['mobile_background_position']) {
              case "left":
               echo "background-position: top left !important; ";
               break;
             case "center":
               echo "background-position: top center !important; ";
               break;
             case "right":
               echo "background-position: top right !important; ";
               break;
            }

            switch ($options['mobile_background_repeat']) {
              case "no":
               echo "background-repeat: no-repeat !important; ";
               break;
              case "tile":
               echo "background-repeat: repeat !important; ";
               break;
              case "horiz":
               echo "background-repeat: repeat-x !important; ";
               break;
              case "vert":
               echo "background-repeat: repeat-y !important; ";
               break;
            }

            switch ($options['mobile_background_attach']) {
              case "scroll":
               echo "background-attachment: scroll !important; ";
               break;
              case "fixed":
               echo "background-attachment: fixed !important; ";
               break;
            }
            echo "}";
          }
        }
        echo '}</style>';
      }

// Apply Theme Mods (from the Customizer)
echo '<style type="text/css">';
if (get_theme_mod( 'offcanvas_link_color')) echo ' #content a { color:' .get_theme_mod( 'offcanvas_link_color' ).';}';

if (get_theme_mod( 'offcanvas_title_color')) echo ' .site-title, .site-title a, .site-title a:hover  { color:' .get_theme_mod( 'offcanvas_title_color', '' ).';}';


echo '</style>';
// Uncomment this to remove theme mods! (need to find a better way to do this!)
//remove_theme_mods();
    ?>
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'offcanvas-theme' ), esc_html( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'offcanvas-theme' ), esc_html( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

</head>
<body id="page" <?php body_class(''); ?>>
<div id="wrapper" class="hfeed container">
    <div id="header">
        <div id="masthead">
					<hgroup>
					<?php if ( get_header_image() != '' ) : ?>
               
        <div id="logo" class="site-title">
            <a href="<?php echo home_url('/'); ?>"><img src="<?php header_image(); ?>"  alt="<?php bloginfo('name'); ?>" /></a>
        </div><!-- end of #logo -->
        
    <?php endif; // header image was removed ?>

    <?php if ( !get_header_image() ) : ?>
                
        <div id="logo" class="site-title">
            <span class="site-name"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></span>
            <!--span class="site-description"><?php bloginfo('description'); ?></span-->
        </div><!-- end of #logo -->  

    <?php endif; // header image was removed (again) ?>
			
			</hgroup>

            <div id="access">
				<!--<div class="skip-link"><a href="#content" title="<?php _e( 'Skip to content', 'offcanvas-theme' ) ?>"><?php _e( 'Skip to content', 'offcanvas-theme' ) ?></a></div>-->
							<span class="off-canvas-navigation">
								<ul>
									<li class="menu-item"><a class='menu-button' href="#menu"><span class='menutext'>Menu &#x2630;</span><span class='maintextmenu'>Main</span></a></li>			
									<li class="sidebar-item"><a class='sidebar-button' href="#sidebar"><span class='sidetext'>Extra +</span><span class='maintextside'>Main</span></a></li>
								</ul>
							</span>	
            </div><!-- #access -->
 			
        </div><!-- #masthead -->
    </div><!-- #header -->
 
    <div id="main">