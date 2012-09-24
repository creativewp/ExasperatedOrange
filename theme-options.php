<?php
function offcanvas_get_default_options() {
	$options = array(
		'mobile_background_img' => '',
		'enable_mobile_background' => 0,
		'mobile_background_type' => 'solid',
		'mobile_background_position' => 'center',
		'mobile_background_repeat' => 'no',
		'mobile_background_attach' => 'scroll'
	);
	return $options;
}


function offcanvas_options_init() {
     $offcanvas_options = get_option( 'theme_offcanvas_options' );
	 
	 // Are our options saved in the DB?
     if ( false === $offcanvas_options ) {
		  // If not, we'll save our default options
          $offcanvas_options = offcanvas_get_default_options();
		  add_option( 'theme_offcanvas_options', $offcanvas_options );
     }
	 
     // In other case we don't need to update the DB
}
// Initialize Theme options
add_action( 'after_setup_theme', 'offcanvas_options_init' );

function offcanvas_options_setup() {
	global $pagenow;
	if ('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) {
		// Now we'll replace the 'Insert into Post Button inside Thickbox' 
		add_filter( 'gettext', 'replace_thickbox_text' , 1, 2 );
	}
}
add_action( 'admin_init', 'offcanvas_options_setup' );

function replace_thickbox_text($translated_text, $text ) {	
	if ( 'Insert into Post' == $text ) {
		$referer = strpos( wp_get_referer(), 'offcanvas-settings' );
		if ( $referer != '' ) {
			return __('Set as mobile background', 'offcanvas' );
		}
	}
	return $translated_text;
}

// Add "offcanvas Options" link to the "Appearance" menu
function offcanvas_menu_options() {
     add_theme_page('Theme Options', 'Theme Options', 'edit_theme_options', 'offcanvas-settings', 'offcanvas_admin_options_page');
}

// Load the Admin Options page
add_action('admin_menu', 'offcanvas_menu_options');

function offcanvas_admin_options_page() {
	// 'wrap','submit','icon32','button-primary' and 'button-secondary' are classes 
	// for a good WP Admin Panel viewing and are predefined by WP CSS -->
	?>
	<div class="wrap">

		<?php screen_icon(); echo "<h2>" . wp_get_theme() . __( ' Theme Options', 'offcanvastheme' ) . "</h2>"; ?>		

		<!-- If we have any error by submiting the form, they will appear here -->
		<?php settings_errors( 'offcanvas-settings-errors' ); ?>
		
		<form id="form-offcanvas-options" action="options.php" method="post" enctype="multipart/form-data">
			
			<?php
				settings_fields('theme_offcanvas_options');
				do_settings_sections('offcanvas');
			?>
			
			<p class="submit">
				<input name="theme_offcanvas_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'offcanvas'); ?>" />
				<input name="theme_offcanvas_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'offcanvas'); ?>" />		
			</p>
			
		</form>
			
	</div>
	<?php
}

function offcanvas_options_validate( $input ) {
	$default_options = offcanvas_get_default_options();
	$valid_input = $default_options;
	
	$offcanvas_options = get_option('theme_offcanvas_options');
	
	$submit = ! empty($input['submit']) ? true : false;
	$reset = ! empty($input['reset']) ? true : false;
	$delete_mobile_background = ! empty($input['delete_mobile_background']) ? true : false;
	
	if ( $submit ) {
		if ( $offcanvas_options['mobile_background_img'] != $input['mobile_background_img']  && $offcanvas_options['mobile_background_img'] != '' )
			delete_image( $offcanvas_options['mobile_background_img'] );
		
		$valid_input['mobile_background_img'] = $input['mobile_background_img'];

		if ( ! isset( $input['enable_mobile_background'] ) )
			$input['enable_mobile_background'] = null;
		$valid_input['enable_mobile_background'] = ( $input['enable_mobile_background'] == 1 ? 1 : 0 );

		$valid_input['mobile_background_type'] =  $input['mobile_background_type'];
		$valid_input['mobile_background_position'] =  $input['mobile_background_position'];
		$valid_input['mobile_background_repeat'] =  $input['mobile_background_repeat'];	
		$valid_input['mobile_background_attach'] =  $input['mobile_background_attach'];
	}
	elseif ( $reset ) {
		delete_image( $offcanvas_options['mobile_background_img'] );
		$valid_input['mobile_background_img'] = $default_options['mobile_background_img'];
	}
	elseif ( $delete_mobile_background ) {
		delete_image( $offcanvas_options['mobile_background_img'] );
		$valid_input['mobile_background_img'] = '';
	}
	
	return $valid_input;
}

function delete_image( $image_url ) {
	global $wpdb;
	
	// We need to get the image's meta ID..
	$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";  
	$results = $wpdb -> get_results($query);

	// And delete them (if more than one attachment is in the Library
	foreach ( $results as $row ) {
		wp_delete_attachment( $row -> ID );
	}	
}

/********************* JAVASCRIPT ******************************/
function offcanvas_options_enqueue_scripts() {
	wp_register_script( 'offcanvas-upload', get_template_directory_uri() .'/js/offcanvas-upload.js', array('jquery','media-upload','thickbox') );	

	if ( 'appearance_page_offcanvas-settings' == get_current_screen() -> id ) {
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		
		wp_enqueue_script('media-upload');
		wp_enqueue_script('offcanvas-upload');
		
	}
	
}
add_action('admin_enqueue_scripts', 'offcanvas_options_enqueue_scripts');


function offcanvas_options_settings_init() {
	register_setting( 'theme_offcanvas_options', 'theme_offcanvas_options', 'offcanvas_options_validate' );
	
	// Add a form section for the Mobile Background Image
	add_settings_section('offcanvas_settings_header', __( 'Mobile Background', 'offcanvas' ), 'offcanvas_settings_header_text', 'offcanvas');

	// Add Checkbox to enable Custom Mobile Background
	add_settings_field('enable_mobile_background',  __( 'Enable Custom Mobile Background', 'offcanvas' ), 'offcanvas_enable_mobile_background', 'offcanvas', 'offcanvas_settings_header');

	// Add Radio Buttons to choose if Solid colour or image
	add_settings_field('mobile_background_type',  __( 'Select Mobile Background Type', 'offcanvas' ), 'offcanvas_mobile_background_type', 'offcanvas', 'offcanvas_settings_header');
	
	// Add Image uploader
	add_settings_field('offcanvas_setting_mobile_background',  __( 'Mobile Background Image', 'offcanvas' ), 'offcanvas_setting_mobile_background', 'offcanvas', 'offcanvas_settings_header');
	
	// Add Current Image Preview 
	add_settings_field('offcanvas_setting_mobile_background_preview',  __( 'Mobile Background Image Preview', 'offcanvas' ), 'offcanvas_setting_mobile_background_preview', 'offcanvas', 'offcanvas_settings_header');

	// Add a form section for the Mobile Background Image
	add_settings_section('offcanvas_settings_display_options', __( 'Display Options', 'offcanvas' ), 'offcanvas_settings_display_options_text()', 'offcanvas');

	// Set position for image
	add_settings_field('mobile_background_position',  __( 'Position', 'offcanvas' ), 'offcanvas_mobile_background_position', 'offcanvas', 'offcanvas_settings_display_options');

	// Set Repeat option for image
	add_settings_field('mobile_background_repeat',  __( 'Repeat', 'offcanvas' ), 'offcanvas_mobile_background_repeat', 'offcanvas', 'offcanvas_settings_display_options');

	// Set Attachment option for image
	add_settings_field('mobile_background_attach',  __( 'Attachment', 'offcanvas' ), 'offcanvas_mobile_background_attach', 'offcanvas', 'offcanvas_settings_display_options');

}
add_action( 'admin_init', 'offcanvas_options_settings_init' );

function offcanvas_setting_mobile_background_preview() {
	$offcanvas_options = get_option( 'theme_offcanvas_options' );  ?>
	<div id="upload_mobile_background_preview" style="min-height: 100px;">
		<img style="max-width:100%;" src="<?php echo esc_url( $offcanvas_options['mobile_background_img'] ); ?>" />
	</div>
	<?php
}

function offcanvas_settings_display_options_text() {
	?>
		
	<?php
}
function offcanvas_settings_header_text() {
	?>
		<p><?php _e( 'Set a different background for Mobile devices.', 'offcanvas' ); ?></p>
	<?php
}

function offcanvas_setting_mobile_background() {
	$offcanvas_options = get_option( 'theme_offcanvas_options' );
	?>
		<input type="hidden" id="mobile_background_url" name="theme_offcanvas_options[mobile_background_img]" value="<?php echo esc_url( $offcanvas_options['mobile_background_img'] ); ?>" />
		<input id="upload_mobile_background_button" type="button" class="button" value="<?php _e( 'Choose Image', 'offcanvas' ); ?>" />
		<?php if ( '' != $offcanvas_options['mobile_background_img'] ): ?>
			<input id="delete_mobile_background_button" name="theme_offcanvas_options[delete_mobile_background]" type="submit" class="button" value="<?php _e( 'Delete Image', 'offcanvas' ); ?>" />
		<?php endif; ?>
		<span class="description"><?php _e('Upload or Choose an image for the mobile background.', 'offcanvas' ); ?></span>
	<?php
}

function offcanvas_enable_mobile_background() {
	$offcanvas_options = get_option( 'theme_offcanvas_options' );
	?>
	<input id="theme_offcanvas_options[enable_mobile_background]" name="theme_offcanvas_options[enable_mobile_background]" type="checkbox" value="1" <?php checked( '1', $offcanvas_options['enable_mobile_background'] ); ?> />
	<span class="description" for="theme_offcanvas_options[enable_mobile_background]"><?php _e( 'Enable a custom background for Mobile Devices?', 'offcanvastheme' ); ?></span>
	<?php
}


function offcanvas_mobile_background_type() {
	$offcanvas_options = get_option( 'theme_offcanvas_options' );
	?>
	<input type="radio" name="theme_offcanvas_options[mobile_background_type]" value="solid" <?php echo is_radio_checked('mobile_background_type', 'solid'); ?> /> <span class="label">Solid Colour (as defined in <a href="' . admin_url() . 'themes.php?page=custom-background">Background</a> menu)</span><br />
	<input type="radio" name="theme_offcanvas_options[mobile_background_type]" value="image" <?php echo is_radio_checked('mobile_background_type', 'image'); ?> /> <span class="label">Image (select below)</span><br />
	<?php
}

function offcanvas_mobile_background_position() {
	$offcanvas_options = get_option( 'theme_offcanvas_options' );
	?>
	<input type="radio" name="theme_offcanvas_options[mobile_background_position]" value="left" <?php echo is_radio_checked('mobile_background_position', 'left'); ?> /> <span class="label">Left</span>
	<input type="radio" name="theme_offcanvas_options[mobile_background_position]" value="center" <?php echo is_radio_checked('mobile_background_position', 'center'); ?> /> <span class="label">Center</span>
	<input type="radio" name="theme_offcanvas_options[mobile_background_position]" value="right" <?php echo is_radio_checked('mobile_background_position', 'right'); ?> /> <span class="label">Right</span> <br />
	<?php
}

function offcanvas_mobile_background_repeat() {
	$offcanvas_options = get_option( 'theme_offcanvas_options' );
	?>
	<input type="radio" name="theme_offcanvas_options[mobile_background_repeat]" value="no" <?php echo is_radio_checked('mobile_background_repeat', 'no'); ?> /> <span class="label">No Repeat</span>
	<input type="radio" name="theme_offcanvas_options[mobile_background_repeat]" value="tile" <?php echo is_radio_checked('mobile_background_repeat', 'tile'); ?> /> <span class="label">Tile</span>
	<input type="radio" name="theme_offcanvas_options[mobile_background_repeat]" value="horiz" <?php echo is_radio_checked('mobile_background_repeat', 'horiz'); ?> /> <span class="label">Tile Horizontally</span> 
	<input type="radio" name="theme_offcanvas_options[mobile_background_repeat]" value="vert" <?php echo is_radio_checked('mobile_background_repeat', 'vert'); ?> /> <span class="label">Tile Vertically</span> <br />

	<?php
}

function offcanvas_mobile_background_attach() {
	$offcanvas_options = get_option( 'theme_offcanvas_options' );
	?>
	<input type="radio" name="theme_offcanvas_options[mobile_background_attach]" value="scroll" <?php echo is_radio_checked('mobile_background_attach', 'scroll'); ?> /> <span class="label">Scroll</span>
	<input type="radio" name="theme_offcanvas_options[mobile_background_attach]" value="fixed" <?php echo is_radio_checked('mobile_background_attach', 'fixed'); ?> /> <span class="label">Fixed</span> <br />
	<?php
}

function is_radio_checked($option_name, $option_value) {
	$offcanvas_options = get_option( 'theme_offcanvas_options' );
	if ($offcanvas_options[$option_name] == $option_value) {
		return 'checked';
	} else {
		return '#' . $offcanvas_options[$option_name] . '#';
	}
}


?>