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
 
add_shortcode('linkedinsc_firstname', 'linkedin_sc_firstname_handler');
add_shortcode('linkedinsc_lastname', 'linkedin_sc_lastname_handler');
add_shortcode('linkedinsc_locality', 'linkedin_sc_locality_handler');
add_shortcode('linkedinsc_status', 'linkedin_sc_status_handler');
add_shortcode('linkedinsc_skills', 'linkedin_sc_skills_handler');
add_shortcode('linkedinsc_interests', 'linkedin_sc_interests_handler');
add_shortcode('linkedinsc_photo', 'linkedin_sc_photo_handler');
add_shortcode('linkedinsc_summary', 'linkedin_sc_summary_handler');

function linkedin_sc_firstname_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->firstname);
}

function linkedin_sc_lastname_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->lastname);
}

function linkedin_sc_locality_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->current_locality);
}

function linkedin_sc_status_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->current_status);
}

function linkedin_sc_skills_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->skills);
}

function linkedin_sc_interests_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->interests);
}

function linkedin_sc_photo_handler($atts) {
	global $linkedin_sc_profile;
	return _linkedin_sc_format_text($linkedin_sc_profile->photo);
}

function linkedin_sc_summary_handler($atts) {
       global $linkedin_sc_profile;
       return _linkedin_sc_format_text($linkedin_sc_profile->summary);
}
