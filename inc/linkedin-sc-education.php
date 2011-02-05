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
add_shortcode('linkedinsc_edu', 'linkedin_sc_educations_handler');
add_shortcode('linkedinsc_edu_title', 'linkedin_sc_education_school_name_handler');
add_shortcode('linkedinsc_edu_degree', 'linkedin_sc_education_degree_handler');
add_shortcode('linkedinsc_edu_major', 'linkedin_sc_education_field_of_study_handler');
add_shortcode('linkedinsc_edu_start', 'linkedin_sc_education_start_date_handler');
add_shortcode('linkedinsc_edu_end', 'linkedin_sc_education_end_date_handler');
add_shortcode('linkedinsc_edu_notes', 'linkedin_sc_education_notes_handler');

/**
 * The following shortcodes should be used
 */
add_shortcode('linkedinsc_educations', 'linkedin_sc_educations_handler');
add_shortcode('linkedinsc_education_school_name', 'linkedin_sc_education_school_name_handler');
add_shortcode('linkedinsc_education_degree', 'linkedin_sc_education_degree_handler');
add_shortcode('linkedinsc_education_field_of_study', 'linkedin_sc_education_field_of_study_handler');
add_shortcode('linkedinsc_education_start_date', 'linkedin_sc_education_start_date_handler');
add_shortcode('linkedinsc_education_end_date', 'linkedin_sc_education_end_date_handler');
add_shortcode('linkedinsc_education_notes', 'linkedin_sc_education_notes_handler');

$linkedin_sc_edu_num = 0;

function _linkedin_sc_get_edu() {
	global $linkedin_sc_profile;
	global $linkedin_sc_edu_num;
	$educations = $linkedin_sc_profile->educations;
	return $educations[$linkedin_sc_edu_num];
}

function linkedin_sc_educations_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	global $linkedin_sc_edu_num;
	$educations = $linkedin_sc_profile->educations;
	$out = '';
	// Making sure the counter is set to 0. See http://wordpress.org/support/topic/plugin-linkedin-sc-regarding-linkedin_sc_exp_num-and-linkedin_sc_edu_num
	$linkedin_sc_edu_num = 0;
	foreach($educations as $education) {
		$out .= do_shortcode($content);
		$linkedin_sc_edu_num++;
	}
	return $out;
}

function linkedin_sc_education_school_name_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_text($edu->school_name);
}

function linkedin_sc_education_degree_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_text($edu->degree);
}

function linkedin_sc_education_field_of_study_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_text($edu->field_of_study);
}

function linkedin_sc_education_start_date_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_date($edu->start_date);
}

function linkedin_sc_education_end_date_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_date($edu->end_date);
}

function linkedin_sc_education_notes_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_text($edu->notes);
}
