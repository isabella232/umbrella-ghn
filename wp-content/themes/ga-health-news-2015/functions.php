<?php

	//require_once(get_template_directory() . '/core/' . 'init.php');	//initialize framework
    require_once(get_stylesheet_directory() . '/core/' . 'init.php');	//initialize Child theme framework customizations;
	require_once(PLSH_THEME_PATH . 'theme-functions.php');	//initialize theme

/*--------------------------- CUSTOM FUNCTIONS --------------------------*/
/*	Add your custom functions below											 */
/*-----------------------------------------------------------------------*/

    if ( ! isset( $content_width ) )
    {
        $content_width = 680;
    }


/*
/* Custom Mosaic for Home Page
/*
*/

// - Initial layout and state

function sc_mosaic( $atts, $content ) {
    ob_start();

    extract( shortcode_atts( array(
        'category' => NULL,
        'tag'   => NULL,
        'page' => 1,
        'max' => 5
    ), $atts ) );

    $max = intval($max);
    if($max < 1) $max = 1;

    $args = array(
        'category_name' => $category,
        'tag' => $tag
    );

    $items = plsh_get_post_collection($args, 3, $page);
    if(!empty($items))
    {
        global $post;
        ?>
    <!-- Mosaic -->
    <div class="container mosaic" data-category="<?php echo esc_attr($category); ?>" data-tag="<?php echo esc_attr($tag); ?>" data-page="1" data-max="<?php echo esc_attr($max); ?>">
        <?php
                foreach($items as $key => $post)
                {
                    setup_postdata($post);
                    if($key == 0)
                    {
                        get_template_part('theme/templates/mosaic-item-large');
                    }
                    else
                    {
                        get_template_part('theme/templates/mosaic-item-small');
                    }
                    ?>
            <?php
                }
            ?>

                <?php
                $items = plsh_get_post_collection($args, 3, 2);
                if(!empty($items) && $max > 1)
                {
                    ?>
                    <button type="button" class="btn btn-default center-block"><span><?php _e('Load more feature stories', 'goliath') ?></span></button>
                    <?php
                }
            ?>
    </div>
    <?php
    }

    ?>
        <?php
    $return = ob_get_contents();
    ob_end_clean();
    wp_reset_postdata();
    return $return;
}

// - Load more stories AJAX callback

    function plsh_mosaic_callback()
    {
        global $post;
        ob_start();
        $page = $_POST['page'];
        $last_page = false;

        $args = array(
            'category_name' => $_POST['category'],
            'tag' => $_POST['tag']
        );

        $items = plsh_get_post_collection($args, 3, $page);

        foreach($items as $key => $post)
        {
            setup_postdata($post);
            if($page % 2 == 0)
            {
                if($key == 1)
                {
                    get_template_part( 'theme/templates/mosaic-item-large');
                }
                else
                {
                    get_template_part( 'theme/templates/mosaic-item-small');
                }
            }
            else
            {
                if($key == 0)
                {
                    get_template_part( 'theme/templates/mosaic-item-large');
                }
                else
                {
                    get_template_part( 'theme/templates/mosaic-item-small');
                }
            }

            ?>
            <?php
        }

        $items = plsh_get_post_collection($args, 3, $page+1);
        if(empty($items))
        {
            $last_page = true;
        }

        $data = ob_get_contents();
        ob_end_clean();

        die(json_encode(array('html'=>$data, 'last'=>$last_page)));
    }

/**
 * Custom Excerpt for Pulse section on Home Page (GHN-33)
 *
 * @param string $content WP Post content object
 * @param int $characterCount (optional) Number of characters returned
 * @return string Content without images, shortcodes, etc.
 */
function pulse_featured_excerpt($content, $wordCount = NULL){
    if ($content == '')
	{
		$content = get_the_content('');
        $content = strip_shortcodes( $content );
        $content = apply_filters('the_content', $content);
        $content = strip_tags($content, '<p><a><br><em>');
        $content = str_replace(']]>', ']]>', $content);
        $words = explode(' ', $content, $wordCount + 1);
		if (count($words) > $wordCount) {
			array_pop($words);
			array_push($words, '... ');
			$content = implode(' ', $words);
		}
    }
        $content = substr($content, 0);

    return $content;
}


/**
 * Filter the except length to 250 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 250;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

/*
/* Custom Theme Excerpt Lengths
/*
*/

// function plsh_excerpt($limit=250)
//     {
// 		$excerpt = explode(' ', get_the_excerpt(), $limit);
// 		if (count($excerpt)>=$limit)
// 		{
//             array_pop($excerpt);
//             $excerpt = implode(" ",$excerpt).'...';
// 		}
// 		else
// 		{
//             $excerpt = implode(" ",$excerpt);
// 		}

// 		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
// 		$excerpt = strip_tags($excerpt);
// 		return $excerpt;
//     }

// function that will give double weight to posts published within one month and half weight to posts older than that. relevanssi plugin
add_filter( 'relevanssi_match', 'date_weights' );
function date_weights( $match ) {
	$post_date = strtotime( get_the_time( 'Y-m-d', $match->doc ) );
	if ( time() - $post_date < 60 * 60 * 24 * 30 ) {
 		$match->weight = $match->weight * 2;
	} else {
		$match->weight = $match->weight / 2;
	}
	return $match;
}

/**
 * Returns a Twitter username (without the @ symbol)
 *
 * @param  string	$url a twitter url
 * @return string	the twitter username extracted from the input string
 * @since  Largo 0.3
 * @link   https://github.com/INN/largo/blob/v0.7-prerelease1/inc/helpers.php#L83-L104
 */
function largo_twitter_url_to_username( $url ) {
	$urlParts = explode( '/', $url );
	if ( end( $urlParts ) == '' ) {
		// URL has a trailing slash
		$urlParts = array_slice( $urlParts, 0 , -1 );
	}
	$username = preg_replace( '/@/', '', end( $urlParts ) );
	// strip the ?&# URL parameters if they're present
	// this will let through all other characters
	preg_match( '/[^\?&#]+/', $username, $matches );
	if ( isset( $matches[0] ) ){
		$username = $matches[0];
	}
	return $username;
}

/**
 * Dequeue the 'sharrre' script and its stylesheet
 *
 * The script is broken; without the script there's no need for the styles.
 *
 * @link https://github.com/INN/umbrella-ghn/issues/9
 */
add_action( 'wp_enqueue_scripts', 'ga_dequeue_sharrre', 20 );
function ga_dequeue_sharrre() {
	wp_dequeue_style( 'plsh-sharrre' );
	wp_dequeue_script( 'plsh-sharrre' );
}
