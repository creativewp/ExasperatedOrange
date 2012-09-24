  var doc = document.getElementById('doc');
  doc.removeAttribute('class', 'no-js');
  doc.setAttribute('class', 'js');
  
// If we're using a two-column view, hide the "Extra" button
jQuery(document).ready(function(){
  if (jQuery('#content').attr('class') === 'two-column'){
    jQuery('.sidebar-button').css('visibility', 'hidden');									
  }
});	

// Show/Hide the Sidebar ("Extra") area
var showSidebar = function() {
  jQuery('body').removeClass("active-nav").toggleClass("active-sidebar");
  jQuery('.menu-button').removeClass("active-button");					
  jQuery('.sidebar-button').toggleClass("active-button");

  // Swap the labels to show "Main" as a link to get back to the central panel
  jQuery('.sidetext').toggle();
  jQuery('.maintextside').toggle();
  jQuery('.menutext').show();
  jQuery('.maintextmenu').hide();
}

// Show/Hide the Nav ("Menu") area
var showMenu = function() {
  jQuery('body').removeClass("active-sidebar").toggleClass("active-nav");
  jQuery('.sidebar-button').removeClass("active-button");				
  jQuery('.menu-button').toggleClass("active-button");	

  // Swap the labels to show "Main" as a link to get back to the central panel
  jQuery('.menutext').toggle();
  jQuery('.maintextmenu').toggle();
  jQuery('.sidetext').show();
  jQuery('.maintextside').hide();
}

// add/remove classes everytime the window resize event fires
jQuery(window).resize(function(){
	if (jQuery('#content').attr('class') === 'two-column'){
		jQuery('.sidebar-button').css('visibility', 'hidden');									
	}
	var off_canvas_nav_display = jQuery('.off-canvas-navigation').css('display');
	
	var menu_button_display = jQuery('.menu-button').css('display');
	
	if (jQuery.browser.msie && parseInt($.browser.version, 10) === 8) {
	} else {
  	if (off_canvas_nav_display === 'block') {			
			jQuery("body").removeClass("three-column").addClass("small-screen");				
		} 
		if (off_canvas_nav_display === 'none') {
			jQuery("body").removeClass("active-sidebar active-nav small-screen")
				.addClass("three-column");			
		}	
	}
});	

jQuery(document).ready(function($) {
		// Show main menu (and other widgets on left sidebar)
		jQuery('.menu-button').click(function(e) {
			e.preventDefault();
			showMenu();							
		});	
		// Show the right sidebar
		jQuery('.sidebar-button').click(function(e) {
			e.preventDefault();
			showSidebar();									
		});							
});

// When clicking on A tags in the central panel, go to the HREF location and don't do anything else! (blocks the function below)
jQuery(function () { 
  jQuery('div#content a').click(function() { 
    event.stopPropagation();
  });
});

// Can click _*ANYWHERE*_ (apart from A tags) on the little strip of central panel that remains visible
// to bring that back when in "Menu" or "Extra" views
jQuery(function () { 
    jQuery('div#content').click(function() { 
      jQuery('body').removeClass("active-nav").removeClass("active-sidebar");
      jQuery('.menutext').show();
      jQuery('.maintextmenu').hide();
      jQuery('.sidetext').show();
      jQuery('.maintextside').hide();
    });
});


jQuery(function () {
    jQuery('li.menu-item-type-custom a').click(function() {
        jQuery(this).parent().children('ul').slideToggle();
    });
	
		jQuery('li.menu-item-type-custom ul li a').click(function(event) {
				event.stopImmediatePropagation();
		});
	
		jQuery('li.menu-item-type-custom a').click(function(event) {
    	   event.preventDefault();
		});
});