<?php
/**
 * Settings page registration and rendering.
 *
 * @package Auto_Image_Link_Maker
 */

namespace Auto_Image_Link_Maker;

defined( 'ABSPATH' ) || die();

/**
 * Handles the plugin settings page via the WordPress Settings API.
 *
 * @since 0.2.0
 */
class Settings {

	/**
	 * The settings page slug.
	 *
	 * @var string
	 */
	private string $page_slug = 'ailm-settings';

	/**
	 * The option group name.
	 *
	 * @var string
	 */
	private string $option_group = 'ailm_options';

	/**
	 * Register hooks for the settings page.
	 *
	 * @since 0.2.0
	 *
	 * @return void
	 */
	public function register_hooks(): void {
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Add the settings page under the Settings menu.
	 *
	 * @since 0.2.0
	 *
	 * @return void
	 */
	public function add_menu_page(): void {
		add_options_page(
			__( 'Auto Image Link Maker', 'auto-image-link-maker' ),
			__( 'Image Link Maker', 'auto-image-link-maker' ),
			'manage_options',
			$this->page_slug,
			array( $this, 'render_page' )
		);
	}

	/**
	 * Register settings, sections, and fields.
	 *
	 * @since 0.2.0
	 *
	 * @return void
	 */
	public function register_settings(): void {
		register_setting(
			$this->option_group,
			OPT_CSS_SELECTORS,
			array(
				'type'              => 'string',
				'sanitize_callback' => array( $this, 'sanitize_css_selectors' ),
				'default'           => DEF_CSS_SELECTORS,
			)
		);

		register_setting(
			$this->option_group,
			OPT_PAGE_TYPES,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_page_types' ),
				'default'           => DEF_PAGE_TYPES,
			)
		);

		add_settings_section(
			'ailm_selectors_section',
			__( 'CSS Selectors', 'auto-image-link-maker' ),
			array( $this, 'render_selectors_section' ),
			$this->page_slug
		);

		add_settings_field(
			'ailm_css_selectors_field',
			__( 'Image Selectors', 'auto-image-link-maker' ),
			array( $this, 'render_css_selectors_field' ),
			$this->page_slug,
			'ailm_selectors_section'
		);

		add_settings_section(
			'ailm_page_types_section',
			__( 'Page Types', 'auto-image-link-maker' ),
			array( $this, 'render_page_types_section' ),
			$this->page_slug
		);

		add_settings_field(
			'ailm_page_types_field',
			__( 'Enable on', 'auto-image-link-maker' ),
			array( $this, 'render_page_types_field' ),
			$this->page_slug,
			'ailm_page_types_section'
		);
	}

	/**
	 * Render the settings page.
	 *
	 * @since 0.2.0
	 *
	 * @return void
	 */
	public function render_page(): void {
		include \AILM_PLUGIN_DIR . 'admin-templates/settings-page.php';
	}

	/**
	 * Render the CSS selectors section description.
	 *
	 * @since 0.2.0
	 *
	 * @return void
	 */
	public function render_selectors_section(): void {
		printf(
			'<p>%s</p>',
			esc_html__( 'Enter CSS selectors to identify images that should be made clickable. One selector per line.', 'auto-image-link-maker' )
		);
	}

	/**
	 * Render the CSS selectors textarea field.
	 *
	 * @since 0.2.0
	 *
	 * @return void
	 */
	public function render_css_selectors_field(): void {
		$value = get_option( OPT_CSS_SELECTORS, DEF_CSS_SELECTORS );

		printf(
			'<textarea name="%s" id="%s" rows="6" cols="50" class="large-text code">%s</textarea><p class="description">%s</p>',
			esc_attr( OPT_CSS_SELECTORS ),
			esc_attr( OPT_CSS_SELECTORS ),
			esc_textarea( $value ),
			esc_html__( 'Example: #main img, .entry-content img, .wp-block-table img', 'auto-image-link-maker' )
		);
	}

	/**
	 * Render the page types section description.
	 *
	 * @since 0.2.0
	 *
	 * @return void
	 */
	public function render_page_types_section(): void {
		printf(
			'<p>%s</p>',
			esc_html__( 'Choose which types of pages the plugin should run on.', 'auto-image-link-maker' )
		);
	}

	/**
	 * Render the page types checkbox fields.
	 *
	 * @since 0.2.0
	 *
	 * @return void
	 */
	public function render_page_types_field(): void {
		$saved_types = get_option( OPT_PAGE_TYPES, DEF_PAGE_TYPES );
		$output      = '<fieldset>';

		foreach ( PAGE_TYPE_LABELS as $key => $label ) {
			$checked = ! empty( $saved_types[ $key ] ) && (bool) filter_var( $saved_types[ $key ], FILTER_VALIDATE_BOOLEAN );

			$output .= sprintf(
				'<label><input type="checkbox" name="%s[%s]" value="1" %s /> %s</label><br>',
				esc_attr( OPT_PAGE_TYPES ),
				esc_attr( $key ),
				checked( $checked, true, false ),
				esc_html( $label )
			);
		}

		$output .= '</fieldset>';

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- All values escaped above.
	}

	/**
	 * Sanitize the CSS selectors textarea input.
	 *
	 * @since 0.2.0
	 *
	 * @param mixed $input Raw input from the form.
	 *
	 * @return string Sanitized selectors, one per line.
	 */
	public function sanitize_css_selectors( mixed $input ): string {
		$lines     = explode( "\n", (string) $input );
		$sanitized = array();

		foreach ( $lines as $line ) {
			$line = sanitize_text_field( $line );
			if ( '' !== $line ) {
				$sanitized[] = $line;
			}
		}

		return implode( "\n", $sanitized );
	}

	/**
	 * Sanitize the page types checkbox input.
	 *
	 * @since 0.2.0
	 *
	 * @param mixed $input Raw input from the form.
	 *
	 * @return array<string, bool> Sanitized page types.
	 */
	public function sanitize_page_types( mixed $input ): array {
		$sanitized = array();

		foreach ( array_keys( PAGE_TYPE_LABELS ) as $key ) {
			$sanitized[ $key ] = ! empty( $input[ $key ] );
		}

		return $sanitized;
	}
}
