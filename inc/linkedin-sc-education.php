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
 
add_shortcode('linkedinsc_edu', 'linkedin_sc_edu_handler');
add_shortcode('linkedinsc_edu_title', 'linkedin_sc_edu_title_handler');
add_shortcode('linkedinsc_edu_degree', 'linkedin_sc_edu_degree_handler');
add_shortcode('linkedinsc_edu_major', 'linkedin_sc_edu_major_handler');
add_shortcode('linkedinsc_edu_start', 'linkedin_sc_edu_start_handler');
add_shortcode('linkedinsc_edu_end', 'linkedin_sc_edu_end_handler');
add_shortcode('linkedinsc_edu_notes', 'linkedin_sc_edu_notes_handler');

$linkedin_sc_edu_num = 0;

function _linkedin_sc_get_edu() {
	global $linkedin_sc_profile;
	global $linkedin_sc_edu_num;
	$educations = $linkedin_sc_profile->education;
	return $educations[$linkedin_sc_edu_num];
}

function linkedin_sc_edu_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	global $linkedin_sc_edu_num;
	$educations = $linkedin_sc_profile->education;
	$out = '';
	foreach($educations as $education) {
		$out .= do_shortcode($content);
		$linkedin_sc_edu_num++;
	}
	return $out;
}

function linkedin_sc_edu_title_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_text($edu->title);
}

function linkedin_sc_edu_degree_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_text($edu->degree);
}

function linkedin_sc_edu_major_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_text($edu->major);
}

function linkedin_sc_edu_start_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_date($edu->period->start);
}

function linkedin_sc_edu_end_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_date($edu->period->end);
}

function linkedin_sc_edu_notes_handler($atts) {
	$edu = _linkedin_sc_get_edu();
	return _linkedin_sc_format_text($edu->notes);
}
