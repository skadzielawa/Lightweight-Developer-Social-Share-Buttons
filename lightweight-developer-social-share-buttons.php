<?php
/**
 * Plugin Name:       Lightweight Developer Social Share Buttons
 * Description:       Social sharing buttons plugin built with performance and privacy in mind (no tracking code added by the plugin).
 * Version:           1.0
 * Author:            Szymon Kądzielawa
 * License:           GPLv2
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ldssb
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_shortcode( 'ldssb', 'ldssb_shortcode' );
/**
 * The social buttons shortcode.
 *
 * @param array $atts User defined attributes in shortcode tag.
 * @return string
 */
function ldssb_shortcode( $atts ) {
	$output = '';

	if ( ! empty( $atts ) ) {
		// Starting to build the <ul> list with share buttons.
		$output .= '<ul class="ldssb__list">';

		foreach ( $atts as $key => $value ) {

			switch ( $key ) {
				case 'facebook':
					if ( 'true' === $value ) {
						$sharer  = 'http://www.facebook.com/sharer.php?u=' . esc_url( rawurlencode( get_the_permalink() ) );
						$icon    = esc_url( plugins_url( '/icons/logo-facebook.svg', __FILE__ ) );
						$output .= ldssb_item_generator( $sharer, $icon );
					}
					break;
				case 'twitter':
					if ( 'true' === $value ) {
						$sharer  = 'https://twitter.com/intent/tweet?url=' . esc_url( rawurlencode( get_the_permalink() ) ) . '&text=' . get_the_title();
						$icon    = esc_url( plugins_url( '/icons/logo-twitter.svg', __FILE__ ) );
						$output .= ldssb_item_generator( $sharer, $icon );
					}
					break;
				case 'linkedin':
					if ( 'true' === $value ) {
						$sharer  = 'https://www.linkedin.com/sharing/share-offsite/?url=' . esc_url( rawurlencode( get_the_permalink() ) );
						$icon    = esc_url( plugins_url( '/icons/logo-linkedin.svg', __FILE__ ) );
						$output .= ldssb_item_generator( $sharer, $icon );
					}
					break;
			}
		}

		$output .= '</ul>';
	} else {
		// No services added to the shortcode - inform the user about it.
		$output .= '<div class="ldssb__info-box">';
		$output .= wpautop(
			sprintf(
				/* translators: %s: Shortcode structure sample */
				__( 'No sharing services added to the shortcode. Use %s. to add buttons.', 'ldssb' ),
				'<strong>[[ldssb facebook="true" twitter="true" linkedin="true"]]</strong>'
			)
		);
		$output .= wpautop( __( 'Tip: You can configure the buttons order by changing the shortcode parameters order.', 'ldssb' ) );
		$output .= '</div>';
	}

	return $output;
}

/**
 * Helper function to generate the share button code.
 *
 * @param string $sharer_url URL for the sharing service.
 * @param string $icon_url Share icon URL.
 * @return string
 */
function ldssb_item_generator( $sharer_url, $icon_url ) {
	return '<li class="ldssb__item">
				<a target="_blank" rel="noopener noreferrer" href="' . $sharer_url . '" class="ldssb__link">
					<img src="' . $icon_url . '" alt="" class="ldssb__icon">
				</a>
			</li>';
}
