    </div><!-- #main -->
     <div id="footer" class="site-footer" role="contentinfo">
        <div id="colophon"> 
            <div id="site-info">
              <ul>
                <li>Copyright &copy; <?php echo date("Y") ?> <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></li>
                <li>Powered by <a href="<?php $my_theme = wp_get_theme(); echo $my_theme->{'Author URI'};?>" ><?php echo $my_theme->{'Name'};?></a>Theme</li>
                <li>Running on <a href="http://www.wordpress.org">WordPress</a></li>
                <li><a href="#header">Back to top</a></li>					
              </ul>	
            </div><!-- #site-info -->
        </div><!-- #colophon -->
    </div><!-- #footer -->
</div><!-- #wrapper -->
<?php wp_footer(); ?>
</body>
</html>