<?php
/*
Template Name: Two-column Page
*/
?>
<?php get_header(); ?>
 
        <div id="container" class="container">
			      <?php get_sidebar('left'); ?>
            <div id="content"  role="main" class="two-column">
	
 
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
<?php the_content(); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
<?php edit_post_link( __( 'Edit', 'your-theme' ), '<span class="edit-link">', '</span>' ) ?>
                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
 
<?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>            
 
            </div><!-- #content -->

        </div><!-- #container -->
 
<?php get_footer(); ?>