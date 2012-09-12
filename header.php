<!DOCTYPE html>
<html id="doc" class="no-js">
<head profile="http://gmpg.org/xfn/11">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0;">	
    <title><?php
        if ( is_single() ) { single_post_title(); }
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); get_page_number(); }
    ?></title>

<!-- need to use "enqueuescript" to load this properly -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<!-- This script needs to stay here (I think...) -->
<script type="text/javascript">
  var doc = document.getElementById('doc');
  doc.removeAttribute('class', 'no-js');
  doc.setAttribute('class', 'js');
</script>
	
<!-- This script section needs to go in to a theme.js file but for now it's here! -->
<script type="text/javascript">
// If we're using a two-column view, hide the "Extra" button
jQuery(document).ready(function(){
  if ($('#content').attr('class') === 'two-column'){
    $('.sidebar-button').css('visibility', 'hidden');									
  }
});	

// Show/Hide the Sidebar ("Extra") area
var showSidebar = function() {
  $('body').removeClass("active-nav").toggleClass("active-sidebar");
  $('.menu-button').removeClass("active-button");					
  $('.sidebar-button').toggleClass("active-button");

  // Swap the labels to show "Main" as a link to get back to the central panel
  $('.sidetext').toggle();
  $('.maintextside').toggle();
  $('.menutext').show();
  $('.maintextmenu').hide();
}

// Show/Hide the Nav ("Menu") area
var showMenu = function() {
  $('body').removeClass("active-sidebar").toggleClass("active-nav");
  $('.sidebar-button').removeClass("active-button");				
  $('.menu-button').toggleClass("active-button");	

  // Swap the labels to show "Main" as a link to get back to the central panel
  $('.menutext').toggle();
  $('.maintextmenu').toggle();
  $('.sidetext').show();
  $('.maintextside').hide();
}

// add/remove classes everytime the window resize event fires
jQuery(window).resize(function(){
	if ($('#content').attr('class') === 'two-column'){
		$('.sidebar-button').css('visibility', 'hidden');									
	}
	var off_canvas_nav_display = $('.off-canvas-navigation').css('display');
	
	var menu_button_display = $('.menu-button').css('display');
	
	if ($.browser.msie && parseInt($.browser.version, 10) === 8) {
	} else {
  	if (off_canvas_nav_display === 'block') {			
			$("body").removeClass("three-column").addClass("small-screen");				
		} 
		if (off_canvas_nav_display === 'none') {
			$("body").removeClass("active-sidebar active-nav small-screen")
				.addClass("three-column");			
		}	
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

// When clicking on A tags in the central panel, go to the HREF location and don't do anything else! (blocks the function below)
jQuery(function () { 
  $('div#content a').click(function() { 
    event.stopPropagation();
  });
});

// Can click _*ANYWHERE*_ (apart from A tags) on the little strip of central panel that remains visible
// to bring that back when in "Menu" or "Extra" views
jQuery(function () { 
    $('div#content').click(function() { 
      $('body').removeClass("active-nav").removeClass("active-sidebar");
      $('.menutext').show();
      $('.maintextmenu').hide();
      $('.sidetext').show();
      $('.maintextside').hide();
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

    <!-- IE8 specific stuff makes the site work in IE8, but not in an "Off-Canvas" manner - put this in a separate CSS file? -->
    <!--[if IE 8]>
    <style type="text/css">
.site-title {
text-align: center;
font-size: 100px;
margin-bottom: -.2em;
padding: 0;
}
.site-title img {width: 300px;}
.off-canvas-navigation {display: none;}
	.js [role="navigation"] {
width: 19%;
margin-left: 0;
float: left;
padding: 3%;
background: #222;
}
.js [role="main"] {
width: 44%;
padding: 3%;
}
.js [role="complementary"] {
width: 19%;
padding: 3%;
margin-right: 0;
float: right;
background: #222;
}
	div.two-column {width: 69% !important;}
	.site-footer {background: #222;}

    </style>
    <![endif]-->

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
    ?>

    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'offcanvas-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'offcanvas-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

</head>
<body id="page" <?php body_class(''); ?>>
<div id="wrapper" class="hfeed container">
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
				<!--<div class="skip-link"><a href="#content" title="<?php _e( 'Skip to content', 'offcanvas-theme' ) ?>"><?php _e( 'Skip to content', 'offcanvas-theme' ) ?></a></div>-->
							<span class="off-canvas-navigation">
								<ul>
									<li class="menu-item"><a class='menu-button' href="#menu"><span class='menutext'>Menu ≣</span><span class='maintextmenu'>Main</span></a></li>			
									<li class="sidebar-item"><a class='sidebar-button' href="#sidebar"><span class='sidetext'>Extra +</span><span class='maintextside'>Main</span></a></li>
								</ul>
							</span>	
            </div><!-- #access -->
 			
        </div><!-- #masthead -->
    </div><!-- #header -->
 
    <div id="main">