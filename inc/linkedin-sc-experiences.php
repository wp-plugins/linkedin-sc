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
add_shortcode('linkedinsc_exp', 'linkedin_sc_positions_handler');
add_shortcode('linkedinsc_exp_title', 'linkedin_sc_position_title_handler');
add_shortcode('linkedinsc_org_link', 'linkedin_sc_position_company_link_handler');
add_shortcode('linkedinsc_org_name', 'linkedin_sc_position_company_name_handler');
add_shortcode('linkedinsc_org_full_link', 'linkedin_sc_position_company_full_link_handler');
add_shortcode('linkedinsc_org_sector', 'linkedin_sc_position_company_industry_handler');
add_shortcode('linkedinsc_exp_start', 'linkedin_sc_position_start_date_handler');
add_shortcode('linkedinsc_exp_end', 'linkedin_sc_position_end_date_handler');
add_shortcode('linkedinsc_exp_description', 'linkedin_sc_position_summary_handler');

/**
 * The following shortcodes should be used
 */
add_shortcode('linkedinsc_positions', 'linkedin_sc_positions_handler');
add_shortcode('linkedinsc_position_title', 'linkedin_sc_position_title_handler');
add_shortcode('linkedinsc_position_company_link', 'linkedin_sc_position_company_link_handler');
add_shortcode('linkedinsc_position_company_name', 'linkedin_sc_position_company_name_handler');
add_shortcode('linkedinsc_position_company_full_link', 'linkedin_sc_position_company_full_link_handler');
add_shortcode('linkedinsc_position_company_industry', 'linkedin_sc_position_company_industry_handler');
add_shortcode('linkedinsc_position_start_date', 'linkedin_sc_position_start_date_handler');
add_shortcode('linkedinsc_position_end_date', 'linkedin_sc_position_end_date_handler');
add_shortcode('linkedinsc_position_summary', 'linkedin_sc_position_summary_handler');

$linkedin_sc_exp_num = 0;

function linkedin_sc_positions_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	global $linkedin_sc_exp_num;
	$experiences = $linkedin_sc_profile->positions;
	$out = '';
	// Making sure the counter is set to 0. See http://wordpress.org/support/topic/plugin-linkedin-sc-regarding-linkedin_sc_exp_num-and-linkedin_sc_edu_num
	$linkedin_sc_exp_num = 0;
	foreach($experiences as $experience) {
		$out .= do_shortcode($content);
		$linkedin_sc_exp_num++;
	}
	return $out;
}

function _linkedin_sc_get_exp() {
	global $linkedin_sc_profile;
	global $linkedin_sc_exp_num;
	$experiences = $linkedin_sc_profile->positions;
	return $experiences[$linkedin_sc_exp_num];
}

function linkedin_sc_position_title_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->title);
}

function linkedin_sc_position_company_link_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->company->link);
}

function linkedin_sc_position_company_name_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->company->name);
}

function linkedin_sc_position_company_industry_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->company->industry);
}


function linkedin_sc_position_start_date_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_date($exp->start_date);
}

function linkedin_sc_position_end_date_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_date($exp->end_date);
}

function linkedin_sc_position_summary_handler($atts) {
	$exp = _linkedin_sc_get_exp();
	return _linkedin_sc_format_text($exp->summary);
}

function linkedin_sc_position_company_full_link_handler($atts) {
       $exp = _linkedin_sc_get_exp();
       if($exp->organization->link == '') {
              return _linkedin_sc_format_text($exp->company->name);
       } else {
              return '<a href="'._linkedin_sc_format_text($exp->company->link).'">'._linkedin_sc_format_text($exp->company->name).'</a>';
       }
}
