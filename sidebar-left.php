        <div id="menu" class="widget-area" role="menu">
            <!-- Place the menu on the left sidebar automatically! -->
            <?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu-header' ) ); ?>
            <ul class="xoxo" role="menuitem">
	      <!-- Space for other widgets -->
              <?php dynamic_sidebar('left_sidebar_widget_area'); ?>
            </ul>
        </div><!-- #left #sidebar .widget-area -->