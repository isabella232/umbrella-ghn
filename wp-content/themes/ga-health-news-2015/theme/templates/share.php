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


		$fb_share = '<span class="btn-facebook"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=%1$s"><i class="fa fa-facebook-square"></i> <span class="hidden-phone">%2$s</span></a></span>';
		$output['facebook'] = sprintf(
			$fb_share,
			rawurlencode( get_permalink() ),
			_x( 'Like', 'facebook verb', 'goliath' )
		);

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
