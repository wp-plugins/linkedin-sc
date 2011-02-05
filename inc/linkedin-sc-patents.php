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
 
add_shortcode('linkedinsc_patents', 'linkedin_sc_patents_handler');
add_shortcode('linkedinsc_patent_title', 'linkedin_sc_patent_title_handler');
add_shortcode('linkedinsc_patent_summary', 'linkedin_sc_patent_summary_handler');
add_shortcode('linkedinsc_patent_number', 'linkedin_sc_patent_number_handler');
add_shortcode('linkedinsc_patent_status_name', 'linkedin_sc_patent_status_name_handler');
add_shortcode('linkedinsc_patent_office_name', 'linkedin_sc_patent_office_name_handler');
add_shortcode('linkedinsc_patent_inventors_name', 'linkedin_sc_patent_inventors_name_handler');
add_shortcode('linkedinsc_patent_date', 'linkedin_sc_patent_date_handler');
add_shortcode('linkedinsc_patent_url', 'linkedin_sc_patent_url_handler');

$linkedin_sc_patents_num = 0;

function linkedin_sc_patents_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	global $linkedin_sc_patents_num;
	$patents = $linkedin_sc_profile->patents;
	$out = '';
	// Making sure the counter is set to 0. See http://wordpress.org/support/topic/plugin-linkedin-sc-regarding-linkedin_sc_exp_num-and-linkedin_sc_edu_num
	$linkedin_sc_patents_num = 0;
	foreach($patents as $patent) {
		$out .= do_shortcode($content);
		$linkedin_sc_patents_num++;
	}
	return $out;
}

function _linkedin_sc_get_patent() {
	global $linkedin_sc_profile;
	global $linkedin_sc_patents_num;
	$patents = $linkedin_sc_profile->patents;
	return $patents[$linkedin_sc_patents_num];
}

function linkedin_sc_patent_title_handler($atts) {
	$pub = _linkedin_sc_get_patent();
	return _linkedin_sc_format_text($pub->title);
}

function linkedin_sc_patent_summary_handler($atts) {
	$pub = _linkedin_sc_get_patent();
	return _linkedin_sc_format_text($pub->summary);
}

function linkedin_sc_patent_number_handler($atts) {
	$pub = _linkedin_sc_get_patent();
	return _linkedin_sc_format_text($pub->number);
}

function linkedin_sc_patent_status_name_handler($atts) {
	$pub = _linkedin_sc_get_patent();
	return _linkedin_sc_format_text($pub->status->name);
}

function linkedin_sc_patent_office_name_handler($atts) {
	$pub = _linkedin_sc_get_patent();
	return _linkedin_sc_format_text($pub->office->name);
}

function linkedin_sc_patent_inventors_name_handler($atts) {
	$pub = _linkedin_sc_get_patent();
	return _linkedin_sc_format_text($pub->inventors->name);
}

function linkedin_sc_patent_date_handler($atts) {
	$pub = _linkedin_sc_get_patent();
	return _linkedin_sc_format_date($pub->date);
}

function linkedin_sc_patent_url_handler($atts) {
	$pub = _linkedin_sc_get_patent();
	return _linkedin_sc_format_text($pub->url);
}

