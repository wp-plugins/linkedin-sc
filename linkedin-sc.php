<?php

/*
Plugin Name: LinkedIn SC
Plugin URI: http://www.viguierjust.com
Description: Display your LinkedIn CV on one of your Wordpress pages or post using Shortcodes
Version: 1.1.6
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

/** Whether to use LinkedIn API **/
$linkedin_sc_use_api = FALSE;
$linkedin_sc_api_key = get_option('linkedin_sc_api_key');
$linkedin_sc_secret_key = get_option('linkedin_sc_secret_key');
if (!empty($linkedin_sc_api_key) && !empty($linkedin_sc_secret_key)) {
	$linkedin_sc_use_api = TRUE;
}

/** Shortcodes **/
define('LINKEDIN_SC_PATH', WP_PLUGIN_URL.'/linkedin-sc/');
add_shortcode('linkedinsc', 'linkedin_sc_handler');

$linkedin_sc_profile = null;

function linkedin_sc_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	global $linkedin_sc_use_api;
	global $post;
	if ($linkedin_sc_use_api && linkedin_sc_api_authorized()) {
		// Add required shortcodes
		require_once(dirname(__FILE__).'/inc/linkedin-sc-certifications.php');
		require_once(dirname(__FILE__).'/inc/linkedin-sc-languages.php');
		require_once(dirname(__FILE__).'/inc/linkedin-sc-patents.php');
		require_once(dirname(__FILE__).'/inc/linkedin-sc-publications.php');
		require_once(dirname(__FILE__).'/inc/linkedin-sc-skills.php');
		// We can use linkedin API
		require_once(dirname(__FILE__).'/lib/linkedin_profile/linkedin_api_profile.php');
		/*$cache = get_user_meta($post->post_author, 'linkedin_sc_cache', TRUE);
		if ($cache) {
			$linkedin_sc_profile = new LinkedInAPIProfile($cache, 'en', NULL, TRUE);
		}
		else {*/
			$oauth_config = linkedin_sc_api_get_config();
			$linkedin_sc_profile = new LinkedInAPIProfile($oauth_config, $atts['lang']);
		//}
	}
	else {
		require_once(dirname(__FILE__).'/lib/linkedin_profile/linkedin_public_profile.php');
		$linkedin_sc_profile = new LinkedInPublicProfile($atts['profile'], $atts['lang']);
	}
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
	// Convert & to &amp; to validate XHTML and avoid XSS attacks
	$out = htmlentities($text, ENT_QUOTES, 'UTF-8');
	// Allow br tags
	$out = str_replace('&lt;br /&gt;', '<br />', $out);
	return trim($text);
}

require_once(dirname(__FILE__).'/inc/linkedin-sc-header.php');
require_once(dirname(__FILE__).'/inc/linkedin-sc-experiences.php');
require_once(dirname(__FILE__).'/inc/linkedin-sc-education.php');
if ($linkedin_sc_use_api) {
	require_once(dirname(__FILE__).'/inc/linkedin-sc-api.php');
}

/* Company shortcodes */
add_shortcode('linkedinsc_company', 'linkedin_sc_company_handler');

$linkedin_sc_company = null;

function linkedin_sc_company_handler($atts, $content = null) {
	global $linkedin_sc_company;
	require_once(dirname(__FILE__).'/inc/linkedin-sc-companies.php');
	require_once(dirname(__FILE__).'/lib/linkedin_profile/linkedin_company_public_profile.php');
	$linkedin_sc_company = new LinkedInCompanyPublicProfile($atts['id']);
	return do_shortcode($content);
}


/** Admin **/
add_action('admin_menu', 'linkedin_sc_menu');

function linkedin_sc_menu() {
	add_options_page('LinkedIn SC', 'LinkedIn SC', 'manage_options', 'linkedin_sc', 'linkedin_sc_options');
	add_action('admin_init', 'linkedin_sc_register_settings');
}

function linkedin_sc_register_settings() {
	register_setting('linkedin_sc_settings', 'linkedin_sc_date_format');
	register_setting('linkedin_sc_settings', 'linkedin_sc_api_key');
	register_setting('linkedin_sc_settings', 'linkedin_sc_secret_key');
	$roles = get_editable_roles();
	foreach ($roles as $role => $detail) {
		register_setting('linkedin_sc_settings', 'linkedin_sc_roles_'.$role);
		register_setting('linkedin_sc_settings', 'linkedin_sc_company_roles_'.$role);
	}
	register_setting('linkedin_sc_settings', 'linkedin_sc_profile_template');
	register_setting('linkedin_sc_settings', 'linkedin_sc_company_template');
}

function linkedin_sc_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	$roles = get_editable_roles();
	$role_checkboxes = '';
	$company_role_checkboxes = '';
	foreach ($roles as $role => $detail) {
		$name = translate_user_role($detail['name']);
		$checked = '';
		if (get_option('linkedin_sc_roles_'.$role)) {
			$checked = 'checked="checked"';
		}
		$company_checked = '';
		if (get_option('linkedin_sc_company_roles_'.$role)) {
			$company_checked ='checked="checked"';
		}
		$role_checkboxes .= '<input type="checkbox" '.$checked.' name="linkedin_sc_roles_'.$role.'" />'.$name.'<br />';
		$company_role_checkboxes .= '<input type="checkbox" '.$company_checked.' name="linkedin_sc_company_roles_'.$role.'" />'.$name.'<br />';
	}
	
?>
	<div class="wrap">
		<h2>LinkedIn SC</h2>
		<form method="post" action="options.php">
		<?php settings_fields('linkedin_sc_settings') ?> 
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Date format') ?></th>
				<td><input type="text" name="linkedin_sc_date_format" value="<?php echo get_option('linkedin_sc_date_format', 'M Y') ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('LinkedIn API key') ?></th>
				<td><input type="text" name="linkedin_sc_api_key" value="<?php echo get_option('linkedin_sc_api_key') ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('LinkedIn secret key') ?></th>
				<td><input type="text" name="linkedin_sc_secret_key" value="<?php echo get_option('linkedin_sc_secret_key') ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Show LinkedIn profile on the profile page for the following roles') ?></th>
				<td><?php echo $role_checkboxes; ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Use the following template to display the LinkedIn CV on the profile page') ?></th>
				<td><textarea name="linkedin_sc_profile_template" rows="20" cols="80"><?php echo get_option('linkedin_sc_profile_template') ?></textarea></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Allow the following roles to display their LinkedIn company on their profile page') ?></th>
				<td><?php echo $company_role_checkboxes; ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Use the following template to display the LinkedIn companies on the profile page') ?></th>
				<td><textarea name="linkedin_sc_company_template" rows="20" cols="80"><?php echo get_option('linkedin_sc_company_template') ?></textarea></td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
	</div>
<?php
}

/** Handling company display on profiles **/
add_action('profile_personal_options', 'linkedin_sc_company_profile');

function linkedin_sc_company_profile($user) {
	$role = array_shift($user->roles);
	
	if (get_option('linkedin_sc_company_roles_'.$role)) {
	?>
		<table class="form-table">
			<tr>
				<th><label><?php _e('LinkedIn Company URL') ?></label></th>
				<td><input type="text" name="linkedin_sc_company_url" value="<?php echo get_user_meta($user->ID, 'linkedin_sc_company_url', TRUE); ?>" /></td>
			</tr>
			<tr>
				<th><label><?php _e('LinkedIn Company') ?></label></th>
				<td><?php $c_url = get_user_meta($user->ID, 'linkedin_sc_company_url', TRUE); if ($c_url) { echo do_shortcode(_linkedin_sc_add_company_url($c_url, get_option('linkedin_sc_company_template'))); } else { _e('Enter the URL of the company you would like to display in the box above and click on Update profile'); } ?></td>
			</tr>
		</table>
	<?php
	}
}

add_action('personal_options_update', 'linkedin_sc_company_profile_save');

function linkedin_sc_company_profile_save($user_id) {
	if (!current_user_can('edit_user', $user_id)) {
		return FALSE;
	} else {
		update_user_meta($user_id, 'linkedin_sc_company_url', $_POST['linkedin_sc_company_url']);
	}
}

function _linkedin_sc_add_company_url($url, $content) {
	return str_replace('[linkedinsc_company]', '[linkedinsc_company id="'.$url.'"]', $content);
}

/** User profile **/
// Add these actions on user profile only if an API and secret keys were registered
if ($linkedin_sc_use_api) {
	
function linkedin_sc_api_init() {
	wp_register_script('linkedin_sc', plugins_url('js/linkedin_sc.js', __FILE__));
	wp_enqueue_script('linkedin_sc');
}

add_action('init', 'linkedin_sc_api_init');
add_action('wp_ajax_linkedin_sc_api_oauth', 'linkedin_sc_api_oauth');
function linkedin_sc_api_oauth() {
	global $linkedin_sc_api_key;
	// Read cookie and save it in tmp file
	$cookie_name = "linkedin_oauth_${linkedin_sc_api_key}";
	// This stripslashes shouldn't be here, but for some reason the cookie arrives with 
	// slashes in front of the apostrophes
	$credentials_json = stripslashes($_COOKIE[$cookie_name]);
	$credentials = json_decode($credentials_json);
	// Verify signature
	if (linkedin_sc_api_validate_signature($credentials)) {
		// Exchange tokens
		$response = linkedin_sc_api_exchange_token($credentials->access_token);
		// Save tokens
		linkedin_sc_api_save_tokens($response);
	}
	die();
}

add_action('profile_personal_options', 'linkedin_sc_user_profile');

function linkedin_sc_user_profile($user) {
	$api_config = linkedin_sc_api_get_config();
?>
	<script type="text/javascript" src="http://platform.linkedin.com/in.js">
    api_key: <?php echo $api_config['consumer_key']."\n"; ?>
    credentials_cookie: true
  </script>
	<table class="form-table">
		<tr>
			<th><label><?php _e('LinkedIn API') ?></label></th>
			<td><script type="in/login" data-onAuth="onLinkedInAuth"></script><div id="linkedin_sc_profile"></div></td>
		</tr>

	</table>
	<?php
	$capabilities = $user->wp_capabilities;
	$authorize = FALSE;
	foreach ($capabilities as $role => $capability) {
		if ($capability == 1 && get_option('linkedin_sc_roles_'.$role)) {
			$authorize = TRUE;
		}
	}
	
	if ($authorize) {
	?>
		<table class="form-table">
			<tr>
				<th><label><?php _e('LinkedIn Profile') ?></label></th>
				<td><?php if (linkedin_sc_api_authorized()) { echo do_shortcode(get_option('linkedin_sc_profile_template')); } else { _e('You first need to sign in with LinkedIn and refresh this page before your profile can be displayed'); } ?></td>
			</tr>
		</table>
	<?php
	}
	?>

<?php
}


}
?>
