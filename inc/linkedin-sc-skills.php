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
 
add_shortcode('linkedinsc_skills', 'linkedin_sc_skills_handler');
add_shortcode('linkedinsc_skill_name', 'linkedin_sc_skill_name_handler');
add_shortcode('linkedinsc_skill_proficiency_level', 'linkedin_sc_skill_proficiency_level_handler');
add_shortcode('linkedinsc_skill_proficiency_name', 'linkedin_sc_skill_proficiency_name_handler');
add_shortcode('linkedinsc_skill_years_name', 'linkedin_sc_skill_years_name_handler');

$linkedin_sc_skills_num = 0;

function linkedin_sc_skills_handler($atts, $content = null) {
	global $linkedin_sc_profile;
	global $linkedin_sc_skills_num;
	$skills = $linkedin_sc_profile->skills;
	$out = '';
	// Making sure the counter is set to 0. See http://wordpress.org/support/topic/plugin-linkedin-sc-regarding-linkedin_sc_exp_num-and-linkedin_sc_edu_num
	$linkedin_sc_skills_num = 0;
	foreach($skills as $skill) {
		$out .= do_shortcode($content);
		$linkedin_sc_skills_num++;
	}
	return $out;
}

function _linkedin_sc_get_skill() {
	global $linkedin_sc_profile;
	global $linkedin_sc_skills_num;
	$skills = $linkedin_sc_profile->skills;
	return $skills[$linkedin_sc_skills_num];
}

function linkedin_sc_skill_name_handler($atts) {
	$pub = _linkedin_sc_get_skill();
	return _linkedin_sc_format_text($pub->skill->name);
}

function linkedin_sc_skill_proficiency_level_handler($atts) {
	$pub = _linkedin_sc_get_skill();
	return _linkedin_sc_format_text($pub->proficiency->level);
}

function linkedin_sc_skill_proficiency_name_handler($atts) {
	$pub = _linkedin_sc_get_skill();
	return _linkedin_sc_format_text($pub->proficiency->name);
}

function linkedin_sc_skill_years_name_handler($atts) {
	$pub = _linkedin_sc_get_skill();
	return _linkedin_sc_format_text($pub->years->name);
}

