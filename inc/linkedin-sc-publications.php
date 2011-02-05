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
 
add_shortcode('linkedinsc_publications', 'linkedin_sc_publications_handler');
add_shortcode('linkedinsc_publication_title', 'linkedin_sc_publication_title_handler');
add_shortcode('linkedinsc_publication_publisher_name', 'linkedin_sc_publication_publisher_name_handler');
add_shortcode('linkedinsc_publication_authors_name', 'linkedin_sc_publication_authors_name_handler');
add_shortcode('linkedinsc_publication_date', 'linkedin_sc_publication_date_handler');
add_shortcode('linkedinsc_publication_url', 'linkedin_sc_publication_url_handler');
add_shortcode('linkedinsc_publication_summary', 'linkedin_sc_publication_summary_handler');

$linkedin_sc_publications_num = 0;

function linkedin_sc_publications_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	global $linkedin_sc_publications_num;
	$publications = $linkedin_sc_profile->publications;
	$out = '';
	// Making sure the counter is set to 0. See http://wordpress.org/support/topic/plugin-linkedin-sc-regarding-linkedin_sc_exp_num-and-linkedin_sc_edu_num
	$linkedin_sc_publications_num = 0;
	foreach($publications as $publication) {
		$out .= do_shortcode($content);
		$linkedin_sc_publications_num++;
	}
	return $out;
}

function _linkedin_sc_get_publication() {
	global $linkedin_sc_profile;
	global $linkedin_sc_publications_num;
	$publications = $linkedin_sc_profile->publications;
	return $publications[$linkedin_sc_publications_num];
}

function linkedin_sc_publication_title_handler($atts) {
	$pub = _linkedin_sc_get_publication();
	return _linkedin_sc_format_text($pub->title);
}

function linkedin_sc_publication_publisher_name_handler($atts) {
	$pub = _linkedin_sc_get_publication();
	return _linkedin_sc_format_text($pub->publisher->name);
}

function linkedin_sc_publication_authors_name_handler($atts) {
	$pub = _linkedin_sc_get_publication();
	return _linkedin_sc_format_text($pub->authors->name);
}

function linkedin_sc_publication_date_handler($atts) {
	$pub = _linkedin_sc_get_publication();
	return _linkedin_sc_format_date($pub->date);
}

function linkedin_sc_publication_url_handler($atts) {
	$pub = _linkedin_sc_get_publication();
	return _linkedin_sc_format_text($pub->url);
}

function linkedin_sc_publication_summary_handler($atts) {
	$pub = _linkedin_sc_get_publication();
	return _linkedin_sc_format_text($pub->summary);
}
