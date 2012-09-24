<div id="comments">
<?php if ( post_password_required() ) : ?>

	<p class="nopassword">This post is password protected. Enter the password to view any comments.</p>

</div>
<?php
	// Stops comments.php being processed
		return;
	endif;
?>

<?php
	// We have comments
	if ( have_comments() ) : ?>
		<h4 id="comments-title">
			<?php printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'offcanvas' ),
			number_format_i18n( get_comments_number() ) );?>
		</h4>

<?php
	// check for comment navigation 
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<div class="navigation">
			
			<div class="nav-previous">
				<?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'offcanvas' ) ); ?>
			</div>
		
			<div class="nav-next">
				<?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'offcanvas' ) ); ?>
			</div>
			
		</div>
<?php endif; ?>

<?php paginate_comments_links() ?>

	<ol class="commentlist">
		<?php wp_list_comments( array ( 'callback' => 'offcanvas_comment' ) ); ?>
	</ol>

<?php
	// check for comment navigation
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<div class="navigation">
		
			<div class="nav-previous">
				<?php previous_comments_link( '<span class="meta-nav">&larr;</span> Older Comments' ); ?>
			</div>
			
			<div class="nav-next">
				<?php next_comments_link( 'Newer Comments <span class="meta-nav">&rarr;</span>' ); ?>
			</div>
		
		</div>
<?php endif; ?>

<?php 
	// we don't have comments
	else : 
	
	// You closed the comments
	if ( ! comments_open() ) : ?>
	
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>

<?php endif; ?>

<?php comment_form(); ?>

</div><!-- end comments -->
