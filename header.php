<!DOCTYPE html>
<html id="doc" class="no-js">
<head profile="http://gmpg.org/xfn/11">
    <title><?php
        if ( is_single() ) { single_post_title(); }
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); get_page_number(); }
    ?></title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript">
			var doc = document.getElementById('doc');
			doc.removeAttribute('class', 'no-js');
			doc.setAttribute('class', 'js');
		</script>
	
	<!-- This script section needs to go in to a theme.js file but for now it's here! -->
			<script type="text/javascript">
	var showSidebar = function() {
	$('body').removeClass("active-nav").toggleClass("active-sidebar");
	$('.menu-button').removeClass("active-button");					
	$('.sidebar-button').toggleClass("active-button");
}

var showMenu = function() {
	$('body').removeClass("active-sidebar").toggleClass("active-nav");
	$('.sidebar-button').removeClass("active-button");				
	$('.menu-button').toggleClass("active-button");	
}

// add/remove classes everytime the window resize event fires
jQuery(window).resize(function(){
	var off_canvas_nav_display = $('.off-canvas-navigation').css('display');
	var menu_button_display = $('.menu-button').css('display');
	if (off_canvas_nav_display === 'block') {			
		$("body").removeClass("three-column").addClass("small-screen");				
	} 
	if (off_canvas_nav_display === 'none') {
		$("body").removeClass("active-sidebar active-nav small-screen")
			.addClass("three-column");			
	}	
});	

jQuery(document).ready(function($) {
		// Show main menu (and other widgets on left sidebar)
		$('.menu-button').click(function(e) {
			e.preventDefault();
			showMenu();							
		});	
		// Show the right sidebar
		$('.sidebar-button').click(function(e) {
			e.preventDefault();
			showSidebar();									
		});							
});
																																																																																																																																																																																																																																																																																																													
jQuery(function () {
    $('li.menu-item-type-custom a').click(function() {
        $(this).parent().children('ul').slideToggle();
    });
	
		$('li.menu-item-type-custom ul li a').click(function(event) {
				event.stopImmediatePropagation();
		});
	
		$('li.menu-item-type-custom a').click(function(event) {
    	   event.preventDefault();
		});
});
	</script>
	
 	
	
    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
 
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
 
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

    <?php wp_head(); ?>
 
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'hbd-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'hbd-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
</head>
<body id="page" <?php body_class(''); ?>>
<div id="wrapper" class="hfeed">
    <div id="header">
        <div id="masthead">
					<hgroup>
					<?php if ( get_header_image() != '' ) : ?>
               
        <div id="logo" class="site-title">
            <a href="<?php echo home_url('/'); ?>"><img src="<?php header_image(); ?>" width="<?php if(function_exists('get_custom_header')) { echo get_custom_header() -> width;} else { echo HEADER_IMAGE_WIDTH;} ?>" height="<?php if(function_exists('get_custom_header')) { echo get_custom_header() -> height;} else { echo HEADER_IMAGE_HEIGHT;} ?>" alt="<?php bloginfo('name'); ?>" /></a>
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
				<!--<div class="skip-link"><a href="#content" title="<?php _e( 'Skip to content', 'hbd-theme' ) ?>"><?php _e( 'Skip to content', 'hbd-theme' ) ?></a></div>-->
																																																													
							<span class="off-canvas-navigation">
								<ul>
									<li class="menu-item"><a class='menu-button' href="#menu">Menu</a></li>			
									<li class="sidebar-item"><a class='sidebar-button' href="#sidebar">Extra</a></li>
								</ul>
							</span>	
																																																													
            </div><!-- #access -->
 			
        </div><!-- #masthead -->
    </div><!-- #header -->
 
    <div id="main">