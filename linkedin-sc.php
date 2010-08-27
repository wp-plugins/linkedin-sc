<?php

/*
Plugin Name: LinkedIn SC
Plugin URI: http://www.viguierjust.com
Description: Display your LinkedIn CV on one of your Wordpress pages or post using Shortcodes
Version: 1.0
Author: Guillaume Viguier-Just
Author URI: http://www.viguierjust.com
Licence: GPL3
*/

/*
 * Copyright 2010 Guillaume Viguier-Just (email: guillaume@viguierjust.com)
 * 
 * This program is free software: you can redistribute it and/or modify 
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/** Internationalization **/
$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain('linkedin_sc', null, $plugin_dir.'/languages');

/** Shortcodes **/
define('LINKEDIN_SC_PATH', WP_PLUGIN_URL.'/linkedin-sc/');
add_shortcode('linkedinsc', 'linkedin_sc_handler');

$linkedin_sc_profile = null;

function linkedin_sc_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	require_once(dirname(__FILE__).'/lib/linkedin_profile/linkedin_profile.php');
	$linkedin_sc_profile = new LinkedInProfile($atts['profile'], $atts['lang']);
	return do_shortcode($content);
}

function _linkedin_sc_format_date($date) {
	if(strpos($date, '-') === FALSE) {
		$date .= '-01';
	}
	// Convert to timestamp
	$timestamp = strtotime($date);
	return date_i18n(get_option('linkedin_sc_date_format', 'M Y'), $timestamp);
}

function _linkedin_sc_format_text($text) {
	// Convert & to &amp; to validate XHTML
	$out = htmlentities($text, ENT_COMPAT, 'UTF-8');
	return nl2br(trim($out));
}

require_once(dirname(__FILE__).'/inc/linkedin-sc-header.php');
require_once(dirname(__FILE__).'/inc/linkedin-sc-experiences.php');
require_once(dirname(__FILE__).'/inc/linkedin-sc-education.php');


/** Admin **/
add_action('admin_menu', 'linkedin_sc_menu');

function linkedin_sc_menu() {
	add_options_page('LinkedIn SC', 'LinkedIn SC', 'manage_options', 'linkedin_sc', 'linkedin_sc_options');
	add_action('admin_init', 'linkedin_sc_register_settings');
}

function linkedin_sc_register_settings() {
	register_setting('linkedin_sc_settings', 'linkedin_sc_date_format');
}

function linkedin_sc_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
?>
	<div class="wrap">
		<h2>LinkedIn SC</h2>
		<form method="post" action="options.php">
		<?php settings_fields('linkedin_sc_settings') ?> 
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Date format') ?></th>
				<td><input type="text" name="linkedin_sc_date_format" value="<?php echo get_option('linkedin_sc_date_format') ?>" /></td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
	</div>
<?php
}

