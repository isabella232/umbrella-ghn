<?php
/**
 * Replace the default AJAX-loaded share buttons with plain, functional ones
 *
 * The code for these buttons is largely copied from INN/largo
 *
 * @link https://github.com/INN/umbrella-ghn/issues/9
 * @link https://github.com/INN/largo/blob/v0.6.4/inc/post-social.php#L7-L188
 */

global $post;
?>

<div class="">
	<h2>&#9756;</h2>
	<?php
		$thumb = plsh_get_thumbnail('gallery-large', true, false);
		if(!$thumb) {
			$thumb = '';
		}

		$output = [];

		/*
		 * Facebook
		 */
		$fb_share = '<span class="btn-facebook"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=%1$s"><i class="fa fa-facebook-square"></i> <span class="hidden-phone">%2$s</span></a></span>';
		$output['facebook'] = sprintf(
			$fb_share,
			rawurlencode( get_permalink() ),
			_x( 'Like', 'facebook verb', 'goliath' )
		);

		/*
		 * twitter
		 */
		// q: does this site use CAP? no
		// [ ] remove of_get_option
		$twitter_share = '<span class="btn-twitter"><a target="_blank" href="https://twitter.com/intent/tweet?text=%1$s&url=%2$s%3$s"><i class="fa fa-twitter-square"></i><span class="hidden-phone">%4$s</span></a></span>';

		// By default, don't set a via.
		$via = '';

		// If there are coauthors, use a coauthor twitter handle, otherwise use the normal author twitter handle
		// If there is a custom byline, don't try to use the author byline.
		if ( function_exists( 'coauthors_posts_links' ) ) {
			$coauthors = get_coauthors( $post->ID );
			$author_twitters = array();
			foreach ( $coauthors as $author ) {
				if ( isset( $author->twitter ) ) {
					$author_twitters[] = $author->twitter;
				}
			}
			if ( count( $author_twitters ) == 1 && !empty($author_twitters[0]) ) {
				$via = '&via=' . rawurlencode( largo_twitter_url_to_username( $author_twitters[0] ) );
			}
			// in the event that there are more than one author twitter accounts, we fall back to the org account
			// @link https://github.com/INN/Largo/issues/1088
		} else if ( empty($via) ) {
			// from the Goliath extra user options
			$user = get_the_author_meta( 'twitter' );
			if ( !empty( $user ) ) {
				$via = '&via=' . rawurlencode( largo_twitter_url_to_username( $user ) );
			}
		}

		// Use the site Twitter handle if that exists and there isn't yet a via
		if ( empty( $via ) ) {
			// from the Goliath theme options
			$site = plsh_gs( 'social_twitter' );
			if ( !empty( $site ) ) {
				$via = '&via=' . rawurlencode( largo_twitter_url_to_username( $site ) ) ;
			}
		}

		$output[] = sprintf(
			$twitter_share,
			// Yes, rawurlencode. Otherwise, the link will break. Use html_entity_decode to handle wordpress saving smart quotes as &#1234; entities.
			rawurlencode( html_entity_decode( get_the_title(), ENT_QUOTES, get_option('blog_charset') ) ),
			rawurlencode( get_permalink() ),
			$via,
			__( 'Tweet', 'largo' )
		);

		/*
		 * email
		 */


		/*
		 * implode and echo
		 */
		echo implode( $output, '' );

	?>
	<h2>&#9757;</h2>
	<div
		class="shareme"
		data-image="<?php echo esc_url($thumb); ?>"
		data-url="<?php the_permalink(); ?>"
		data-text="<?php the_title(); ?>"
	></div>
</div>
