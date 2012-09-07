<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );
add_thickbox();
wp_enqueue_script('media-upload');

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'offcanvas_options', 'offcanvas_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'offcanvastheme' ), __( 'Theme Options', 'offcanvastheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/*
 * Create arrays for the radio buttons
 */
$radio_options = array(
	'solid' => array(
		'value' => 'solid',
		'label' => __( 'Solid Colour (as defined in &quot;Background&quot; menu)', 'offcanvastheme' )
	),
	'image' => array(
		'value' => 'image',
		'label' => __( 'Image (select below)', 'offcanvastheme' )
	),
);

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', 'offcanvastheme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'offcanvastheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'offcanvas_options' ); ?>
			<?php $options = get_option( 'offcanvas_theme_options' ); ?>
<h3><?php _e('Mobile Background') ?></h3>
			<table class="form-table">

				<?php
				/*
				 * Option to use a different background on mobile devices
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( '', 'offcanvastheme' ); ?></th>
					<td>
						<input id="offcanvas_theme_options[mobilebackground]" name="offcanvas_theme_options[mobilebackground]" type="checkbox" value="1" <?php checked( '1', $options['mobilebackground'] ); ?> />
						<label class="description" for="offcanvas_theme_options[mobilebackground]"><?php _e( 'Enable a separate background for Mobile Devices', 'offcanvastheme' ); ?></label>
					</td>
				</tr>

				<?php
				/*
				 * What background type?
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( '', 'offcanvastheme' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( '', 'offcanvastheme' ); ?></span></legend>
						<?php
							if ( ! isset( $checked ) )
								$checked = '';
							foreach ( $radio_options as $option ) {
								$radio_setting = $options['backgroundtype'];

								if ( '' != $radio_setting ) {
									if ( $options['backgroundtype'] == $option['value'] ) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = '';
									}
								}
								?>
								<label class="description"><input type="radio" name="offcanvas_theme_options[backgroundtype]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label><br />
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>
<?php
				/*
				 * Enter image URL...
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( '', 'offcanvastheme' ); ?></th>
					<td>
						<input id="offcanvas_theme_options[imageurl]" class="regular-text" type="text" name="offcanvas_theme_options[imageurl]" value="<?php esc_attr_e( $options['imageurl'] ); ?>" />
						<label class="description" for="offcanvas_theme_options[imageurl]"><?php _e( 'Enter the URL for the image', 'offcanvastheme' ); ?></label>
					</td>
				</tr>
<tr valign="top">
	<th scope="row"><?php _e('Select Image'); ?></th>
	<td><form enctype="multipart/form-data" id="upload-form" method="post" action="">
	        <p>
	                <label for="upload"><?php _e( 'Choose an image from your computer:' ); ?></label><br />
	                <input type="file" id="upload" name="import" />
	                <input type="hidden" name="action" value="save" />
	                <?php wp_nonce_field( 'custom-background-upload', '_wpnonce-custom-background-upload' ); ?>
	                <?php submit_button( __( 'Upload' ), 'button', 'submit', false ); ?>
	        </p>
	        <?php
	                $image_library_url = get_upload_iframe_src( 'image', null, 'library' );
	                $image_library_url = remove_query_arg( 'TB_iframe', $image_library_url );
	                $image_library_url = add_query_arg( array( 'context' => 'custom-background', 'TB_iframe' => 1 ), $image_library_url );
	        ?>
	        <p>
	                <label for="choose-from-library-link"><?php _e( 'Or choose an image from your media library:' ); ?></label><br />
	                <a id="choose-from-library-link" class="button thickbox" href="<?php echo esc_url( $image_library_url ); ?>"><?php _e( 'Choose Image' ); ?></a>
	        </p>
	        </form>
	</td>
	</tr>
			</table>
<h3><?php _e('Display Options') ?></h3>
	<form method="post" action="">
	<table class="form-table">
	<tbody>
	<?php if ( get_background_image() ) : ?>
	<tr valign="top">
	<th scope="row"><?php _e( 'Position' ); ?></th>
	<td><fieldset><legend class="screen-reader-text"><span><?php _e( 'Background Position' ); ?></span></legend>
	<label>
	<input name="background-position-x" type="radio" value="left"<?php checked('left', get_theme_mod('background_position_x', 'left')); ?> />
	<?php _e('Left') ?>
	</label>
	<label>
	<input name="background-position-x" type="radio" value="center"<?php checked('center', get_theme_mod('background_position_x', 'left')); ?> />
	<?php _e('Center') ?>
	</label>
	<label>
	<input name="background-position-x" type="radio" value="right"<?php checked('right', get_theme_mod('background_position_x', 'left')); ?> />
	<?php _e('Right') ?>
	</label>
	</fieldset></td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php _e( 'Repeat' ); ?></th>
	<td><fieldset><legend class="screen-reader-text"><span><?php _e( 'Background Repeat' ); ?></span></legend>
	<label><input type="radio" name="background-repeat" value="no-repeat"<?php checked('no-repeat', get_theme_mod('background_repeat', 'repeat')); ?> /> <?php _e('No Repeat'); ?></label>
	        <label><input type="radio" name="background-repeat" value="repeat"<?php checked('repeat', get_theme_mod('background_repeat', 'repeat')); ?> /> <?php _e('Tile'); ?></label>
	        <label><input type="radio" name="background-repeat" value="repeat-x"<?php checked('repeat-x', get_theme_mod('background_repeat', 'repeat')); ?> /> <?php _e('Tile Horizontally'); ?></label>
	        <label><input type="radio" name="background-repeat" value="repeat-y"<?php checked('repeat-y', get_theme_mod('background_repeat', 'repeat')); ?> /> <?php _e('Tile Vertically'); ?></label>
	</fieldset></td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php _e( 'Attachment' ); ?></th>
	<td><fieldset><legend class="screen-reader-text"><span><?php _e( 'Background Attachment' ); ?></span></legend>
	<label>
	<input name="background-attachment" type="radio" value="scroll" <?php checked('scroll', get_theme_mod('background_attachment', 'scroll')); ?> />
	<?php _e('Scroll') ?>
	</label>
	<label>
	<input name="background-attachment" type="radio" value="fixed" <?php checked('fixed', get_theme_mod('background_attachment', 'scroll')); ?> />
	<?php _e('Fixed') ?>
	</label>
	</fieldset></td>
	</tr>
	<?php endif; // get_background_image() ?>
</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'offcanvastheme' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['mobilebackground'] ) )
		$input['mobilebackground'] = null;
	$input['mobilebackground'] = ( $input['mobilebackground'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['imageurl'] = wp_filter_nohtml_kses( $input['imageurl'] );

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['backgroundtype'] ) )
		$input['radioinput'] = null;
	if ( ! array_key_exists( $input['backgroundtype'], $radio_options ) )
		$input['radioinput'] = null;

	return $input;
}