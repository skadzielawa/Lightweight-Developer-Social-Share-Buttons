<?php
/**
 * Plugin Name:       Dev Share Buttons
 * Description:       Lightweight Social sharing buttons WordPress plugin built with performance, accessibility & privacy in mind. Use it to share current post/page on Twitter, Facebook & LinkedIn.
 * Version:           1.1.0
 * Author:            Szymon Kądzielawa
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dsb
 * GitHub Plugin URI: https://github.com/skadzielawa/lightweight-developer-social-share-buttons
 * GitHub Branch:     master
 *
 *  @package dsb
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define the plugin version.
 */
if ( ! defined( 'DSB_VERSION' ) ) {
	define( 'DSB_VERSION', '1.1.0' );
}

add_shortcode( 'dsb', 'dsb_shortcode' );
/**
 * The social buttons shortcode.
 *
 * @param array $atts User defined attributes in shortcode tag.
 * @return string
 */
function dsb_shortcode( $atts = array() ) {
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
		$output .= dsb_print_info_box();

		// Enqueue Error CSS.
		if ( 'yes' !== get_option( 'disable_css' ) ) {
			wp_enqueue_style( 'dsb-box', plugins_url( 'css/dsb-box.css', __FILE__ ), array(), DSB_VERSION, 'all' );
		}
	} else {
		// Starting to build the <ul> list with share buttons.
		$output .= '<ul class="dsb">';

		foreach ( $a as $key => $value ) {

			switch ( esc_attr( $key ) ) {
				case 'facebook':
					if ( 'true' === $value ) {
						$sharer        = 'http://www.facebook.com/sharer.php?u=' . esc_url( rawurlencode( get_the_permalink() ) );
						$icon_facebook = get_option( 'dsb_facebook_icon_id' );
						$output       .= dsb_item_generator( $sharer, $icon_facebook, __( 'Facebook', 'dsb' ) );
					}
					break;
				case 'twitter':
					if ( 'true' === $value ) {
						$sharer       = 'https://twitter.com/intent/tweet?url=' . esc_url( rawurlencode( get_the_permalink() ) ) . '&text=' . get_the_title();
						$icon_twitter = get_option( 'dsb_twitter_icon_id' );
						$output      .= dsb_item_generator( $sharer, $icon_twitter, __( 'Twitter', 'dsb' ) );
					}
					break;
				case 'linkedin':
					if ( 'true' === $value ) {
						$sharer        = 'https://www.linkedin.com/sharing/share-offsite/?url=' . esc_url( rawurlencode( get_the_permalink() ) );
						$icon_linkedin = get_option( 'dsb_linkedin_icon_id' );
						$output       .= dsb_item_generator( $sharer, $icon_linkedin, __( 'LinkedIn', 'dsb' ) );
					}
					break;
			}
		}

		$output .= '</ul>';

		// Enqueue Share Buttons CSS unless there is a settings not to do it.
		if ( 'yes' !== get_option( 'disable_css' ) ) {
			wp_enqueue_style( 'dsb', plugins_url( 'css/dsb.css', __FILE__ ), array(), DSB_VERSION, 'all' );
		}
	}

	return $output;
}

/**
 * Helper function to print info box, when there are all sharing services disabled.
 *
 * @return string
 */
function dsb_print_info_box() {
	$info_box = '';
	if ( current_user_can( 'manage_options' ) ) {
		// Show the info box for user with proper privileges.
		$info_box .= '<div class="dsb-box">';
		$info_box .= '<h2 class="dsb-box__title">' . __( 'Lightweight Developer Social Share Buttons info', 'dsb' ) . '</h2>';
		$info_box .= wpautop(
			sprintf(
				/* translators: %s: Shortcode structure sample */
				__( 'No sharing services added to the shortcode. Use %s to add buttons.', 'dsb' ),
				'<strong>[[dsb facebook="true" twitter="true" linkedin="true"]]</strong>'
			)
		);
		$info_box .= wpautop( __( 'Tip: You can configure the buttons order by changing the shortcode parameters order.', 'dsb' ) );
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
function dsb_item_generator( $sharer_url, $icon_id, $service_name ) {
	if ( $icon_id ) {
		$icon = wp_get_attachment_image( $icon_id, 'full', true, array( 'class' => 'dsb__icon' ) );
	} else {
		$icon = $service_name;
	}
	return '<li class="dsb__item">
				<a target="_blank" rel="noopener noreferrer" href="' . $sharer_url . '" class="dsb__link">' .
					$icon .
					'<span class="dsb__screen-reader-text">' .
						sprintf(
							/* translators: %s: Sharing service name */
							__( 'Share on %s', 'dsb' ),
							$service_name
						) .
					'</span>' .
				'</a>
			</li>';
}

add_action( 'admin_menu', 'dsb_submenu_page' );
/**
 * Add new submenu page under the Settings
 *
 * @return void
 */
function dsb_submenu_page() {
	add_options_page(
		'Leightweight Developer Social Share Buttons',
		'Social Share Buttons',
		'manage_options',
		'options-dsb',
		'dsb_submenu_page_callback'
	);
}

/**
 * Submenu page content
 *
 * @return void
 */
function dsb_submenu_page_callback() {
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'dsb_settings_group' );
			do_settings_sections( 'options-dsb' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

add_action( 'admin_init', 'dsb_settings_fields' );
/**
 * Create settings fields
 *
 * @return void
 */
function dsb_settings_fields() {
	$page_slug    = 'options-dsb';
	$option_group = 'dsb_settings_group';

	// Create section.
	add_settings_section(
		'dsb_section_id',
		'',
		'',
		$page_slug
	);

	// Register Fields.
	register_setting( $option_group, 'disable_css', 'dsb_sanitize_checkbox' );
	register_setting( $option_group, 'dsb_facebook_icon_id', 'absint' );
	register_setting( $option_group, 'dsb_twitter_icon_id', 'absint' );
	register_setting( $option_group, 'dsb_linkedin_icon_id', 'absint' );

	// Add fields.
	add_settings_field(
		'disable_css',
		esc_html__( "Don't enqueue plugin CSS", 'dsb' ),
		'dsb_disable_css_callback',
		$page_slug,
		'dsb_section_id'
	);

	add_settings_field(
		'dsb_facebook_icon_id',
		esc_html__( 'Facebook icon', 'dsb' ),
		'dsb_facebook_icon_id_callback',
		$page_slug,
		'dsb_section_id'
	);

	add_settings_field(
		'dsb_twitter_icon_id',
		esc_html__( 'Twitter icon', 'dsb' ),
		'dsb_twitter_icon_id_callback',
		$page_slug,
		'dsb_section_id'
	);

	add_settings_field(
		'dsb_linkedin_icon_id',
		esc_html__( 'LinkedIn icon', 'dsb' ),
		'dsb_linkedin_icon_id_callback',
		$page_slug,
		'dsb_section_id'
	);
}

/**
 * Custom callback function to print disable CSS checkbox field HTML
 *
 * @return void
 */
function dsb_disable_css_callback() {
	$value = get_option( 'disable_css' );
	?>
	<label>
		<input type="checkbox" name="disable_css" <?php checked( $value, 'yes' ); ?> />
		<?php esc_html_e( 'Remove plugin CSS', 'dsb' ); ?>
	</label>
	<?php
}

/**
 * Checkbox sanitisation function
 *
 * @param string $value Checkbox value.
 * @return string
 */
function dsb_sanitize_checkbox( $value ) {
	return 'on' === $value ? 'yes' : 'no';
}

/**
 * Helper function to build media uploader field in settings
 *
 * @param string $option_key get_option() key name.
 * @return void
 */
function dsb_build_media_uploader_field( $option_key ) {
	$image_id = get_option( esc_attr( $option_key ) );
	$image    = wp_get_attachment_image_url( $image_id, 'medium' );

	if ( $image ) :
		?>
		<a href="#" class="dsb-upload">
			<img src="<?php echo esc_url( $image ); ?>" />
		</a>
		<a href="#" class="dsb-remove">Remove image</a>
		<input type="hidden" name=<?php echo esc_attr( $option_key ); ?> value="<?php echo absint( $image_id ); ?>">
	<?php else : ?>
		<a href="#" class="button dsb-upload">Upload image</a>
		<a href="#" class="dsb-remove" style="display:none">Remove image</a>
		<input type="hidden" name=<?php echo esc_attr( $option_key ); ?> value="">
		<?php
	endif;
}

/**
 * Custom callback function to print upload Facebook icon image field
 *
 * @return void
 */
function dsb_facebook_icon_id_callback() {
	dsb_build_media_uploader_field( 'dsb_facebook_icon_id' );
}

/**
 * Custom callback function to print upload Twitter icon image field
 *
 * @return void
 */
function dsb_twitter_icon_id_callback() {
	dsb_build_media_uploader_field( 'dsb_twitter_icon_id' );
}

/**
 * Custom callback function to print upload LinkedIn icon image field
 *
 * @return void
 */
function dsb_linkedin_icon_id_callback() {
	dsb_build_media_uploader_field( 'dsb_linkedin_icon_id' );
}


add_action( 'admin_enqueue_scripts', 'dsb_enqueue_media_uplaoder_js' );
/**
 * Enqueue JS file needed for media uploader in settings
 *
 * @return void
 */
function dsb_enqueue_media_uplaoder_js() {
	if ( isset( $_GET['page'] ) && 'options-dsb' === $_GET['page'] ) {
		// WordPress media uploader scripts.
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		// Custom JS for media upload.
		wp_enqueue_script( 'dsb-media-uploader', plugins_url( 'js/dsb-media-uploader.js', __FILE__ ), array( 'jquery' ), DSB_VERSION, false );
	}
}


