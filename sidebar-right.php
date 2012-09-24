<?php if ( is_sidebar_active('right_sidebar_widget_area') ) : ?>
        <div id="sidebar" class="widget-area" role="complementary">
            <ul class="xoxo">
                <?php dynamic_sidebar('right_sidebar_widget_area'); ?>
            </ul>
        </div><!-- #right #sidebar .widget-area -->

<?php endif; ?>