<?php
/**
 * Plugin Name:       Lightweight Developer Social Share Buttons
 * Description:       Social sharing buttons WordPress plugin built with performance, accessibility & privacy in mind. Use it to share current post/page on Twitter, Facebook & LinkedIn.

 * Version:           1.0
 * Author:            Szymon Kądzielawa
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ldssb
 * GitHub Plugin URI: https://github.com/skadzielawa/lightweight-developer-social-share-buttons
 * GitHub Branch:     master
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define the plugin version.
 */
if ( ! defined( 'LDSSB_VERSION' ) ) {
	define( 'LDSSB_VERSION', '1.0' );
}

add_shortcode( 'ldssb', 'ldssb_shortcode' );
/**
 * The social buttons shortcode.
 *
 * @param array $atts User defined attributes in shortcode tag.
 * @return string
 */
function ldssb_shortcode( $atts = array() ) {
	// normalize attribute keys, lowercase.
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );

	// Set shortcode defaults.
	$a = shortcode_atts(
		array(
			'facebook'    => 'true',
			'twitter'     => 'true',
			'linkedin'    => 'true',
			'icons-style' => 'default',
			'disable-css' => 'false',
		),
		$atts
	);

	$icon_facebook = '';
	$icon_twitter  = '';
	$icon_linkedin = '';

	switch ( esc_attr( $a['icons-style'] ) ) {
		case 'round':
			$icon_facebook = '<svg class="ldssb__icon" enable-background="new 0 0 32 32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m16 0c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zm4.2 10.7h-1.5c-1.2 0-1.4.6-1.4 1.4v1.8h2.8l-.4 2.8h-2.4v7.3h-2.9v-7.3h-2.5v-2.8h2.5v-2.1c-.1-2.5 1.4-3.8 3.6-3.8 1 0 1.9.1 2.2.1z"/></svg>';
			$icon_twitter  = '<svg class="ldssb__icon" enable-background="new 0 0 32 32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m16 0c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zm6.4 12.7v.4c0 4.3-3.3 9.3-9.3 9.3-1.9 0-3.6-.5-5-1.5h.8c1.5 0 3-.5 4.1-1.4-1.4 0-2.6-1-3.1-2.3.2 0 .4.1.6.1.3 0 .6 0 .9-.1-1.5-.3-2.6-1.6-2.6-3.2.4.2.9.4 1.5.4-.9-.6-1.5-1.6-1.5-2.7 0-.6.2-1.2.4-1.7 1.6 2 4 3.3 6.8 3.4-.1-.2-.1-.5-.1-.7 0-1.8 1.5-3.3 3.3-3.3.9 0 1.8.4 2.4 1 .7-.1 1.5-.4 2.1-.8-.2.8-.8 1.4-1.4 1.8.7-.1 1.3-.3 1.9-.5-.6.8-1.2 1.4-1.8 1.8z"/></svg>';
			$icon_linkedin = '<svg class="ldssb__icon" enable-background="new 0 0 32 32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m16 0c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zm-4.4 24h-3.3v-10.7h3.3zm-1.7-12.1c-1 0-1.9-.9-1.9-2 0-1 .9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9 0 1.1-.8 2-1.9 2zm14.1 12.1h-3.3v-5.2c0-1.2 0-2.8-1.7-2.8s-2 1.3-2 2.7v5.3h-3.3v-10.7h3.2v1.5c.4-.8 1.5-1.7 3.1-1.7 3.4 0 4 2.2 4 5.1z"/></svg>';
			break;

		case 'square':
			$icon_facebook = '<svg class="ldssb__icon" enable-background="new 0 0 32 32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m0 0v32h32v-32zm20.2 10.7h-1.5c-1.2 0-1.4.6-1.4 1.4v1.8h2.8l-.4 2.8h-2.4v7.3h-2.9v-7.3h-2.5v-2.8h2.5v-2.1c-.1-2.5 1.4-3.8 3.6-3.8 1 0 1.9.1 2.2.1z"/></svg>';
			$icon_twitter  = '<svg class="ldssb__icon" enable-background="new 0 0 32 32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m0 0v32h32v-32zm22.4 12.7v.4c0 4.3-3.3 9.3-9.3 9.3-1.9 0-3.6-.5-5-1.5h.8c1.5 0 3-.5 4.1-1.4-1.4 0-2.6-1-3.1-2.3.2 0 .4.1.6.1.3 0 .6 0 .9-.1-1.5-.3-2.6-1.6-2.6-3.2.4.2.9.4 1.5.4-.9-.6-1.5-1.6-1.5-2.7 0-.6.2-1.2.4-1.7 1.6 2 4 3.3 6.8 3.4-.1-.2-.1-.5-.1-.7 0-1.8 1.5-3.3 3.3-3.3.9 0 1.8.4 2.4 1 .7-.1 1.5-.4 2.1-.8-.2.8-.8 1.4-1.4 1.8.7-.1 1.3-.3 1.9-.5-.6.8-1.2 1.4-1.8 1.8z"/></svg>';
			$icon_linkedin = '<svg class="ldssb__icon" enable-background="new 0 0 32 32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m0 0v32h32v-32zm11.6 24h-3.3v-10.7h3.3zm-1.7-12.1c-1 0-1.9-.9-1.9-2 0-1 .9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9 0 1.1-.8 2-1.9 2zm14.1 12.1h-3.3v-5.2c0-1.2 0-2.8-1.7-2.8s-2 1.3-2 2.7v5.3h-3.3v-10.7h3.2v1.5c.4-.8 1.5-1.7 3.1-1.7 3.4 0 4 2.2 4 5.1z"/></svg>';
			break;

		default:
			$icon_facebook = '<svg class="ldssb__icon" enable-background="new 0 0 32 32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m30.7 0h-29.4c-.7 0-1.3.6-1.3 1.3v29.3c0 .8.6 1.4 1.3 1.4h15.7v-12h-4v-5h4v-4c0-4.1 2.6-6.2 6.3-6.2 1.8 0 3.3.2 3.7.2v4.3h-2.6c-2 0-2.5 1-2.5 2.4v3.3h5l-1 5h-4l.1 12h8.6c.7 0 1.3-.6 1.3-1.3v-29.4c.1-.7-.5-1.3-1.2-1.3z"/></svg>';
			$icon_twitter  = '<svg class="ldssb__icon" enable-background="new 0 0 32 32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m32 6.1c-1.2.5-2.4.9-3.8 1 1.4-.8 2.4-2.1 2.9-3.6-1.3.8-2.7 1.3-4.2 1.6-1.2-1.3-2.9-2.1-4.7-2.1-3.6 0-6.6 2.9-6.6 6.6 0 .5.1 1 .2 1.5-5.5-.3-10.3-2.9-13.6-6.9-.6 1-.9 2.1-.9 3.3 0 2.3 1.2 4.3 2.9 5.5-1.1 0-2.1-.3-3-.8v.1c0 3.2 2.3 5.8 5.3 6.4-.6.1-1.1.2-1.7.2-.4 0-.8 0-1.2-.1.8 2.6 3.3 4.5 6.1 4.6-2.2 1.8-5.1 2.8-8.2 2.8-.5 0-1.1 0-1.6-.1 3 1.8 6.5 2.9 10.2 2.9 12.1 0 18.7-10 18.7-18.7 0-.3 0-.6 0-.8 1.2-1 2.3-2.1 3.2-3.4z"/></svg>';
			$icon_linkedin = '<svg class="ldssb__icon" enable-background="new 0 0 32 32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m30.7 0h-29.4c-.7 0-1.3.6-1.3 1.3v29.3c0 .8.6 1.4 1.3 1.4h29.3c.7 0 1.3-.6 1.3-1.3v-29.4c.1-.7-.5-1.3-1.2-1.3zm-21.2 27.3h-4.8v-15.3h4.8zm-2.4-17.4c-1.5 0-2.8-1.2-2.8-2.8 0-1.5 1.2-2.8 2.8-2.8 1.5 0 2.8 1.2 2.8 2.8s-1.3 2.8-2.8 2.8zm20.2 17.4h-4.7v-7.4c0-1.8 0-4-2.5-4s-2.8 1.9-2.8 3.9v7.6h-4.7v-15.4h4.4v2.1h.1c.6-1.2 2.2-2.5 4.5-2.5 4.8 0 5.7 3.2 5.7 7.3z"/></svg>';
			break;
	}

	$output = '';

	if ( 'false' === $a['facebook'] &&
		'false' === $a['twitter'] &&
		'false' === $a['linkedin']
		) {

		// No services added to the shortcode - inform the user about it.
		$output .= ldssb_print_info_box();

		// Enqueue Error CSS.
		wp_enqueue_style( 'ldssb-box', plugins_url( 'css/ldssb-box.css', __FILE__ ), array(), LDSSB_VERSION, 'all' );

	} else {
		// Starting to build the <ul> list with share buttons.
		$output .= '<ul class="ldssb">';

		foreach ( $a as $key => $value ) {

			switch ( esc_attr( $key ) ) {
				case 'facebook':
					if ( 'true' === $value ) {
						$sharer  = 'http://www.facebook.com/sharer.php?u=' . esc_url( rawurlencode( get_the_permalink() ) );
						$icon    = apply_filters( 'ldssb_icon_facebook', $icon_facebook );
						$output .= ldssb_item_generator( $sharer, $icon, __( 'Facebook', 'ldssb' ) );
					}
					break;
				case 'twitter':
					if ( 'true' === $value ) {
						$sharer  = 'https://twitter.com/intent/tweet?url=' . esc_url( rawurlencode( get_the_permalink() ) ) . '&text=' . get_the_title();
						$icon    = apply_filters( 'ldssb_icon_twitter', $icon_twitter );
						$output .= ldssb_item_generator( $sharer, $icon, __( 'Twitter', 'ldssb' ) );
					}
					break;
				case 'linkedin':
					if ( 'true' === $value ) {
						$sharer  = 'https://www.linkedin.com/sharing/share-offsite/?url=' . esc_url( rawurlencode( get_the_permalink() ) );
						$icon    = apply_filters( 'ldssb_icon_linkedin', $icon_linkedin );
						$output .= ldssb_item_generator( $sharer, $icon, __( 'LinkedIn', 'ldssb' ) );
					}
					break;
			}
		}

		$output .= '</ul>';

		// Enqueue Share Buttons CSS unless there is a parameter disable-css="true" within the shortcode.
		if ( 'true' !== $a['disable-css'] ) {
			wp_enqueue_style( 'ldssb', plugins_url( 'css/ldssb.css', __FILE__ ), array(), LDSSB_VERSION, 'all' );
		}
	}

	return $output;
}

/**
 * Helper function to print info box, when there are all sharing services disabled.
 *
 * @return string
 */
function ldssb_print_info_box() {
	$info_box = '';
	if ( current_user_can( 'manage_options' ) ) {
		// Show the info box for user with proper privileges.
		$info_box .= '<div class="ldssb-box">';
		$info_box .= '<h2 class="ldssb-box__title">' . __( 'Lightweight Developer Social Share Buttons info', 'ldssb' ) . '</h2>';
		$info_box .= wpautop(
			sprintf(
				/* translators: %s: Shortcode structure sample */
				__( 'No sharing services added to the shortcode. Use %s to add buttons.', 'ldssb' ),
				'<strong>[[ldssb facebook="true" twitter="true" linkedin="true" disable-css="false" icons-style=""]]</strong>'
			)
		);
		$info_box .= wpautop( __( 'Tip: You can configure the buttons order by changing the shortcode parameters order.', 'ldssb' ) );
		$info_box .= '</div>';
	}
	return $info_box;
}

/**
 * Helper function to generate the share button code.
 *
 * @param string $sharer_url URL for the sharing service.
 * @param string $icon_url Share icon URL.
 * @param string $service_name Name of the sharing service for screen readers.
 * @return string
 */
function ldssb_item_generator( $sharer_url, $icon_url, $service_name ) {
	return '<li class="ldssb__item">
				<a target="_blank" rel="noopener noreferrer" href="' . $sharer_url . '" class="ldssb__link">' .
					$icon_url .
					'<span class="ldssb__screen-reader-text">' .
						sprintf(
							/* translators: %s: Sharing service name */
							__( 'Share on %s', 'ldssb' ),
							$service_name
						) .
					'</span>' .
				'</a>
			</li>';
}
