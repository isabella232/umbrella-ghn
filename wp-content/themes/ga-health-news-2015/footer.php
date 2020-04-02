<!-- Pre-Footer -->
<div id="ghn2015-prefooter" class="container" >
    <div class="row">
        <div class="newsletter col-md-6 col-sm-12">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme/assets/images/noun_75684.png" alt="Newsletter Icon" />
                </div>
                <div class="col-md-8">
                    <h3>SIGN UP TO RECEIVE OUR FREE EMAIL ALERTS</h3>
                </div>
            </div>
            <p>
                Stay informed about health care news across Georgia and the nation.
            </p>
            <?php
            //Load plugin dir
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            //Make Sure Contact Form 7 is installed and active
            if(is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php')):
                //Show the desired contact form
                echo do_shortcode('[mc4wp_form]');
            else:
                echo "Error: MailChimp for WP not activated";
            endif;
            ?>

        </div>
        <div class="donations col-md-6 col-sm-12">
            <p>
                Help us pursue our nonprofit mission with a tax-deductible donation.
            </p>
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme/assets/images/credit_cards.png" alt="Credit Cards">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <p class="lead">
                        <strong>EVERY LITTLE BIT HELPS</strong>
                        <br>
                        <a href="<?php echo home_url(); ?>/donate/" class="btn btn-default " role="button">Donations Welcome</a>
                    </p>

                </div>
                <div class="col-md-6 col-sm-12 text-center">
                    <p>
                        <img class="icn-donations" src="<?php echo get_stylesheet_directory_uri(); ?>/theme/assets/images/noun_29964_cc.png" alt="Donate Icon" />
                    </p>
                </div>
            </div>


        </div>
    </div>

</div>

<!-- Footer -->
<footer class="container footer">
    <?php
                dynamic_sidebar('footer');
            ?>
</footer>

<!-- Copyright -->
<div class="container copyright">
    <div class="left">
        <?php echo get_wpml_admin_text_string('copyright'); ?>
    </div>
    <div class="right">
        <ul>
            <?php plsh_language_selector_flags(); ?>
                <?php
                        wp_nav_menu( array(
                            'menu'              => 'footer-menu',
                            'theme_location'    => 'footer-menu',
                            'depth'             => 1,
                            'container'         => false,
                            'container_class'   => '',
                            'container_id'      => '',
                            'menu_class'        => '',
                            'items_wrap'        => '%3$s',
                            'fallback_cb'       => false
                        ));
                    ?>
                    <li>
                        <?php
						if(plsh_gs('show_footer_social') == 'on') {

							if(plsh_gs('social_facebook') != '')
							{
								echo '<a href="' . plsh_gs('social_facebook') . '" target="_blank"><i class="fa fa-facebook-square"></i></a>';
							}
							if(plsh_gs('social_twitter') != '')
							{
								echo '<a href="' . plsh_gs('social_twitter') . '" target="_blank"><i class="fa fa-twitter-square"></i></a>';
							}
							if(plsh_gs('social_youtube') != '')
							{
								echo '<a href="' . plsh_gs('social_youtube') . '" target="_blank"><i class="fa fa-youtube-square"></i></a>';
							}
							if(plsh_gs('social_pinterest') != '')
							{
								echo '<a href="' . plsh_gs('social_pinterest') . '" target="_blank"><i class="fa fa-pinterest-square"></i></a>';
							}
							if(plsh_gs('social_gplus') != '')
							{
								echo '<a href="' . plsh_gs('social_gplus') . '" target="_blank"><i class="fa fa-google-plus-square"></i></a>';
							}
							if(plsh_gs('social_instagram') != '')
							{
								echo '<a href="' . plsh_gs('social_instagram') . '" target="_blank"><i class="fa fa-instagram"></i></a> ';
							}
							if(plsh_gs('social_rss') != '')
							{
								echo '<a href="' . plsh_gs('social_rss') . '" target="_blank"><i class="fa fa-rss-square"></i></a>';
							}

						}
                        ?>
                    </li>
        </ul>
    </div>
</div>

<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

<?php wp_footer();?>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-19557625-1', 'auto');
ga('send', 'pageview');

(function($) {
  $.fn.randomize = function(childElem) {
    return this.each(function() {
        var $this = $(this);
        var elems = $this.children(childElem);

        elems.sort(function() { return (Math.round(Math.random())-0.5); });

        $this.remove(childElem);

        for(var i=0; i < elems.length; i++)
          $(elems[i]).insertAfter(elems[0]);

    });
  }
})(jQuery);

jQuery(function() {
  // Randomize sponsors on home page
  jQuery(".home .wpb_wrapper").randomize('.banner-300x250');
  // Randomize sponsors on sidebar / inner page
  jQuery('.main-sidebar').randomize('.goliath_sidebar_banner');
});
</script>
<!-- END body -->
</body>


<!-- END html -->

</html>
