<?php
/**
 * Plugin Name:       Lightweight Developer Social Share Buttons
 * Description:       Social sharing buttons WordPress plugin built with performance, accessibility & privacy in mind. Use it to share current post/page on Twitter, Facebook & LinkedIn.

 * Version:           1.1.0
 * Author:            Szymon Kądzielawa
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ldssb
 * GitHub Plugin URI: https://github.com/skadzielawa/lightweight-developer-social-share-buttons
 * GitHub Branch:     master
 *
 *  @package ldssb
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define the plugin version.
 */
if ( ! defined( 'LDSSB_VERSION' ) ) {
	define( 'LDSSB_VERSION', '1.1.0' );
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
			'facebook' => 'true',
			'twitter'  => 'true',
			'linkedin' => 'true',
		),
		$atts
	);

	$output = '';

	if ( 'false' === $a['facebook'] &&
		'false' === $a['twitter'] &&
		'false' === $a['linkedin']
		) {

		// No services added to the shortcode - inform the user about it.
		$output .= ldssb_print_info_box();

		// Enqueue Error CSS.
		if ( 'yes' !== get_option( 'disable_css' ) ) {
			wp_enqueue_style( 'ldssb-box', plugins_url( 'css/ldssb-box.css', __FILE__ ), array(), LDSSB_VERSION, 'all' );
		}
	} else {
		// Starting to build the <ul> list with share buttons.
		$output .= '<ul class="ldssb">';

		foreach ( $a as $key => $value ) {

			switch ( esc_attr( $key ) ) {
				case 'facebook':
					if ( 'true' === $value ) {
						$sharer        = 'http://www.facebook.com/sharer.php?u=' . esc_url( rawurlencode( get_the_permalink() ) );
						$icon_facebook = get_option( 'ldssb_facebook_icon_id' );
						$output       .= ldssb_item_generator( $sharer, $icon_facebook, __( 'Facebook', 'ldssb' ) );
					}
					break;
				case 'twitter':
					if ( 'true' === $value ) {
						$sharer       = 'https://twitter.com/intent/tweet?url=' . esc_url( rawurlencode( get_the_permalink() ) ) . '&text=' . get_the_title();
						$icon_twitter = get_option( 'ldssb_twitter_icon_id' );
						$output      .= ldssb_item_generator( $sharer, $icon_twitter, __( 'Twitter', 'ldssb' ) );
					}
					break;
				case 'linkedin':
					if ( 'true' === $value ) {
						$sharer        = 'https://www.linkedin.com/sharing/share-offsite/?url=' . esc_url( rawurlencode( get_the_permalink() ) );
						$icon_linkedin = get_option( 'ldssb_linkedin_icon_id' );
						$output       .= ldssb_item_generator( $sharer, $icon_linkedin, __( 'LinkedIn', 'ldssb' ) );
					}
					break;
			}
		}

		$output .= '</ul>';

		// Enqueue Share Buttons CSS unless there is a settings not to do it.
		if ( 'yes' !== get_option( 'disable_css' ) ) {
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
				'<strong>[[ldssb facebook="true" twitter="true" linkedin="true"]]</strong>'
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
 * @param string $icon_id Share icon attachment id.
 * @param string $service_name Name of the sharing service for screen readers.
 * @return string
 */
function ldssb_item_generator( $sharer_url, $icon_id, $service_name ) {
	return '<li class="ldssb__item">
				<a target="_blank" rel="noopener noreferrer" href="' . $sharer_url . '" class="ldssb__link">' .
				wp_get_attachment_image( $icon_id, 'full', true, array( 'class' => 'ldssb__icon' ) ) .
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

add_action( 'admin_menu', 'ldssb_submenu_page' );

/**
 * Add new submenu page under the Settings
 *
 * @return void
 */
function ldssb_submenu_page() {
	add_options_page(
		'Leightweight Developer Social Share Buttons',
		'Social Share Buttons',
		'manage_options',
		'options-ldssb',
		'ldssb_submenu_page_callback'
	);
}

/**
 * Submenu page content
 *
 * @return void
 */
function ldssb_submenu_page_callback() {
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'ldssb_settings_group' );
			do_settings_sections( 'options-ldssb' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

add_action( 'admin_init', 'ldssb_settings_fields' );
/**
 * Create settings fields
 *
 * @return void
 */
function ldssb_settings_fields() {
	$page_slug    = 'options-ldssb';
	$option_group = 'ldssb_settings_group';

	// Create section.
	add_settings_section(
		'ldssb_section_id',
		'',
		'',
		$page_slug
	);

	// Register Fields.
	register_setting( $option_group, 'disable_css', 'ldssb_sanitize_checkbox' );
	register_setting( $option_group, 'ldssb_facebook_icon_id', 'absint' );
	register_setting( $option_group, 'ldssb_twitter_icon_id', 'absint' );
	register_setting( $option_group, 'ldssb_linkedin_icon_id', 'absint' );

	// Add fields.
	add_settings_field(
		'disable_css',
		esc_html__( "Don't enqueue plugin CSS", 'ldssb' ),
		'ldssb_disable_css_callback',
		$page_slug,
		'ldssb_section_id'
	);

	add_settings_field(
		'ldssb_facebook_icon_id',
		esc_html__( 'Facebook icon', 'ldssb' ),
		'ldssb_facebook_icon_id_callback',
		$page_slug,
		'ldssb_section_id'
	);

	add_settings_field(
		'ldssb_twitter_icon_id',
		esc_html__( 'Twitter icon', 'ldssb' ),
		'ldssb_twitter_icon_id_callback',
		$page_slug,
		'ldssb_section_id'
	);

	add_settings_field(
		'ldssb_linkedin_icon_id',
		esc_html__( 'LinkedIn icon', 'ldssb' ),
		'ldssb_linkedin_icon_id_callback',
		$page_slug,
		'ldssb_section_id'
	);
}

/**
 * Custom callback function to print disable CSS checkbox field HTML
 *
 * @return void
 */
function ldssb_disable_css_callback() {
	$value = get_option( 'disable_css' );
	?>
	<label>
		<input type="checkbox" name="disable_css" <?php checked( $value, 'yes' ); ?> />
		<?php esc_html_e( 'Remove plugin CSS', 'ldssb' ); ?>
	</label>
	<?php
}

/**
 * Checkbox sanitisation function
 *
 * @param string $value Checkbox value.
 * @return string
 */
function ldssb_sanitize_checkbox( $value ) {
	return 'on' === $value ? 'yes' : 'no';
}

/**
 * Helper function to build media uploader field in settings
 *
 * @param string $option_key get_option() key name.
 * @return void
 */
function ldssb_build_media_uploader_field( $option_key ) {
	$image_id = get_option( esc_attr( $option_key ) );
	$image    = wp_get_attachment_image_url( $image_id, 'medium' );

	if ( $image ) :
		?>
		<a href="#" class="ldssb-upload">
			<img src="<?php echo esc_url( $image ); ?>" />
		</a>
		<a href="#" class="ldssb-remove">Remove image</a>
		<input type="hidden" name=<?php echo esc_attr( $option_key ); ?> value="<?php echo absint( $image_id ); ?>">
	<?php else : ?>
		<a href="#" class="button ldssb-upload">Upload image</a>
		<a href="#" class="ldssb-remove" style="display:none">Remove image</a>
		<input type="hidden" name=<?php echo esc_attr( $option_key ); ?> value="">
		<?php
	endif;
}

/**
 * Custom callback function to print upload Facebook icon image field
 *
 * @return void
 */
function ldssb_facebook_icon_id_callback() {
	ldssb_build_media_uploader_field( 'ldssb_facebook_icon_id' );
}

/**
 * Custom callback function to print upload Twitter icon image field
 *
 * @return void
 */
function ldssb_twitter_icon_id_callback() {
	ldssb_build_media_uploader_field( 'ldssb_twitter_icon_id' );
}

/**
 * Custom callback function to print upload LinkedIn icon image field
 *
 * @return void
 */
function ldssb_linkedin_icon_id_callback() {
	ldssb_build_media_uploader_field( 'ldssb_linkedin_icon_id' );
}


add_action( 'admin_enqueue_scripts', 'ldssb_enqueue_media_uplaoder_js' );
/**
 * Enqueue JS file needed for media uploader in settings
 *
 * @return void
 */
function ldssb_enqueue_media_uplaoder_js() {
	if ( isset( $_GET['page'] ) && 'options-ldssb' === $_GET['page'] ) {
		// WordPress media uploader scripts.
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		// Custom JS for media upload.
		wp_enqueue_script( 'ldssb-media-uploader', plugins_url( 'js/ldssb-media-uploader.js', __FILE__ ), array( 'jquery' ), LDSSB_VERSION, false );
	}
}


