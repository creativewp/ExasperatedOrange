jQuery(document).ready(function($){
	$('#upload_mobile_background_button').click(function() {
		//type = image,audio,video,file. If we write it wrong, nothing will appear. type = file by default
		// El tipo no importa, ya que desde hace algunas versiones, el uploader puede subir cualquier tipo de archivo
		
		// Si no lo hacemos desde un meta box dentro de un post y adem�s WP_DEBUG = true, nos saldr� un error ya que
		// no estar� asociado a ning�n post
		
		// From Google Translate:
		// The type does not matter, since for some versions, the uploader can upload any type of file
		// If we do from a box within a goal post and also WP_DEBUG = true, we will get an error because
		// Is not associated with any post
		
		//tb_show(caption, url, imageGroup)
		// Google: 'ImageGroup tb_show thickbox':
		//The optional imageGroup parameter can also be used to pass in an array of images for a single or multiple image slide show gallery.
		// The problem is that inserting a gallery needs an associated post to work
		tb_show('Select a mobile background image', 'media-upload.php?referer=offcanvas-settings&amp;type=image&amp;TB_iframe=true&amp;post_id=0', false);
		return false;
	});
	
	window.send_to_editor = function(html) {
		// html returns a link like this:
		// <a href="{server_uploaded_image_url}"><img src="{server_uploaded_image_url}" alt="" title="" width="" height"" class="alignzone size-full wp-image-125" /></a>
		var image_url = $('img',html).attr('src');
		//alert(html);
		$('#mobile_background_url').val(image_url);
		tb_remove();
		$('#upload_logo_preview img').attr('src',image_url);
		
		$('#submit_options_form').trigger('click');
		// $('#uploaded_logo').val('uploaded');
		
	}
	
	
	
});