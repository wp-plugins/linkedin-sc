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
 
add_shortcode('linkedinsc_certifications', 'linkedin_sc_certifications_handler');
add_shortcode('linkedinsc_certification_name', 'linkedin_sc_certification_name_handler');
add_shortcode('linkedinsc_certification_authority_name', 'linkedin_sc_certification_authority_name_handler');
add_shortcode('linkedinsc_certification_number', 'linkedin_sc_certification_number_handler');
add_shortcode('linkedinsc_certification_start_date', 'linkedin_sc_certification_start_date_handler');
add_shortcode('linkedinsc_certification_end_date', 'linkedin_sc_certification_end_date_handler');

$linkedin_sc_certifications_num = 0;

function linkedin_sc_certifications_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	global $linkedin_sc_certifications_num;
	$certifications = $linkedin_sc_profile->certifications;
	$out = '';
	// Making sure the counter is set to 0. See http://wordpress.org/support/topic/plugin-linkedin-sc-regarding-linkedin_sc_exp_num-and-linkedin_sc_edu_num
	$linkedin_sc_certifications_num = 0;
	foreach($certifications as $certification) {
		$out .= do_shortcode($content);
		$linkedin_sc_certifications_num++;
	}
	return $out;
}

function _linkedin_sc_get_certification() {
	global $linkedin_sc_profile;
	global $linkedin_sc_certifications_num;
	$certifications = $linkedin_sc_profile->certifications;
	return $certifications[$linkedin_sc_certifications_num];
}

function linkedin_sc_certification_name_handler($atts) {
	$pub = _linkedin_sc_get_certification();
	return _linkedin_sc_format_text($pub->name);
}

function linkedin_sc_certification_authority_name_handler($atts) {
	$pub = _linkedin_sc_get_certification();
	return _linkedin_sc_format_text($pub->authority->name);
}

function linkedin_sc_certification_number_handler($atts) {
	$pub = _linkedin_sc_get_certification();
	return _linkedin_sc_format_text($pub->number);
}

function linkedin_sc_certification_start_date_handler($atts) {
	$pub = _linkedin_sc_get_certification();
	return _linkedin_sc_format_date($pub->start_date);
}

function linkedin_sc_certification_end_date_handler($atts) {
	$pub = _linkedin_sc_get_certification();
	return _linkedin_sc_format_date($pub->end_date);
}

