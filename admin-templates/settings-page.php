<?php
/**
 * Admin settings page template.
 *
 * @package Auto_Image_Link_Maker
 */

defined( 'ABSPATH' ) || die();

printf(
	'<div class="wrap"><h1>%s</h1><form method="post" action="options.php">',
	esc_html( get_admin_page_title() )
);

settings_fields( 'ailm_options' );
do_settings_sections( 'ailm-settings' );
submit_button();

echo '</form></div>';
