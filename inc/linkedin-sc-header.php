<?php

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

/**
 * These shortcodes are now deprecated but are left (for now) for compatibility reasons
 */
add_shortcode('linkedinsc_firstname', 'linkedin_sc_first_name_handler');
add_shortcode('linkedinsc_lastname', 'linkedin_sc_last_name_handler');
add_shortcode('linkedinsc_locality', 'linkedin_sc_location_name_handler');
add_shortcode('linkedinsc_status', 'linkedin_sc_headline_handler');
add_shortcode('linkedinsc_interests', 'linkedin_sc_interests_handler');
add_shortcode('linkedinsc_honors', 'linkedin_sc_honors_handler');
add_shortcode('linkedinsc_photo', 'linkedin_sc_picture_url_handler');
add_shortcode('linkedinsc_summary', 'linkedin_sc_summary_handler');
add_shortcode('linkedinsc_groups', 'linkedin_sc_groups_handler');

/**
 * The following shortcodes should be used
 * 
 */
add_shortcode('linkedinsc_first_name', 'linkedin_sc_first_name_handler');
add_shortcode('linkedinsc_last_name', 'linkedin_sc_last_name_handler');
add_shortcode('linkedinsc_headline', 'linkedin_sc_headline_handler');
add_shortcode('linkedinsc_location_name', 'linkedin_sc_location_name_handler');
add_shortcode('linkedinsc_industry', 'linkedin_sc_industry_handler');
add_shortcode('linkedinsc_summary', 'linkedin_sc_summary_handler');
add_shortcode('linkedinsc_current_status', 'linkedin_sc_current_status_handler');
add_shortcode('linkedinsc_proposal_comments', 'linkedin_sc_proposal_comments_handler');
add_shortcode('linkedinsc_specialties', 'linkedin_sc_specialties_handler');
add_shortcode('linkedinsc_associations', 'linkedin_sc_associations_handler');
add_shortcode('linkedinsc_honors', 'linkedin_sc_honors_handler');
add_shortcode('linkedinsc_interests', 'linkedin_sc_interests_handler');
add_shortcode('linkedinsc_picture_url', 'linkedin_sc_picture_url_handler');
add_shortcode('linkedinsc_groups', 'linkedin_sc_groups_handler');

function linkedin_sc_first_name_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->first_name);
}

function linkedin_sc_last_name_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->last_name);
}

function linkedin_sc_headline_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->headline);
}

function linkedin_sc_location_name_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->location->name);
}

function linkedin_sc_industry_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->industry);
}

function linkedin_sc_current_status_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->current_status);
}

function linkedin_sc_summary_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->summary);
}

function linkedin_sc_specialties_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->specialties);
}

function linkedin_sc_proposal_comments_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->proposal_comments);
}

function linkedin_sc_associations_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->associations);
}

function linkedin_sc_honors_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->honors);
}

function linkedin_sc_interests_handler($atts) {
	global $linkedin_sc_profile;
  // Converts line breaks to br because linkedIn does not do add br to this field
	return nl2br(_linkedin_sc_format_text($linkedin_sc_profile->interests));
}

function linkedin_sc_picture_url_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->picture_url);
}

function linkedin_sc_groups_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->groups);
}
