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

add_shortcode('linkedinsc_exp', 'linkedin_sc_exp_handler');
add_shortcode('linkedinsc_exp_title', 'linkedin_sc_exp_title_handler');
add_shortcode('linkedinsc_org_link', 'linkedin_sc_org_link_handler');
add_shortcode('linkedinsc_org_name', 'linkedin_sc_org_name_handler');
add_shortcode('linkedinsc_org_sector', 'linkedin_sc_org_sector_handler');
add_shortcode('linkedinsc_exp_start', 'linkedin_sc_exp_start_handler');
add_shortcode('linkedinsc_exp_end', 'linkedin_sc_exp_end_handler');
add_shortcode('linkedinsc_exp_description', 'linkedin_sc_exp_description_handler');

$linkedin_sc_exp_num = 0;

function linkedin_sc_exp_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	global $linkedin_sc_exp_num;
	$experiences = $linkedin_sc_profile->experiences;
	$out = '';
	foreach($experiences as $experience) {
		$out .= do_shortcode($content);
		$linkedin_sc_exp_num++;
	}
	return $out;
}

function _linkedin_sc_get_exp() {
	global $linkedin_sc_profile;
	global $linkedin_sc_exp_num;
	$experiences = $linkedin_sc_profile->experiences;
	return $experiences[$linkedin_sc_exp_num];
}

function linkedin_sc_exp_title_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->title);
}

function linkedin_sc_org_link_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->organization->link);
}

function linkedin_sc_org_name_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->organization->name);
}

function linkedin_sc_org_sector_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->organization->sector);
}


function linkedin_sc_exp_start_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_date($exp->period->start);
}

function linkedin_sc_exp_end_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_date($exp->period->end);
}

function linkedin_sc_exp_description_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->description);
}
