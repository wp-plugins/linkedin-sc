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

add_shortcode('linkedinsc_company_name', 'linkedin_sc_company_name_handler');
add_shortcode('linkedinsc_company_logo', 'linkedin_sc_company_logo_handler');
add_shortcode('linkedinsc_company_description', 'linkedin_sc_company_description_handler');
add_shortcode('linkedinsc_company_specialties', 'linkedin_sc_company_specialties_handler');
add_shortcode('linkedinsc_company_type', 'linkedin_sc_company_type_handler');
add_shortcode('linkedinsc_company_size', 'linkedin_sc_company_size_handler');
add_shortcode('linkedinsc_company_website', 'linkedin_sc_company_website_handler');
add_shortcode('linkedinsc_company_industry', 'linkedin_sc_company_industry_handler');
add_shortcode('linkedinsc_company_founded', 'linkedin_sc_company_founded_handler');

function linkedin_sc_company_name_handler($atts) {
	global $linkedin_sc_company;
	return _linkedin_sc_format_text($linkedin_sc_company->name);
}

function linkedin_sc_company_logo_handler($atts) {
	global $linkedin_sc_company;
	return $linkedin_sc_company->logo;
}

function linkedin_sc_company_description_handler($atts) {
	global $linkedin_sc_company;
	return _linkedin_sc_format_text($linkedin_sc_company->description);
}

function linkedin_sc_company_specialties_handler($atts) {
	global $linkedin_sc_company;
	return _linkedin_sc_format_text($linkedin_sc_company->specialties);
}

function linkedin_sc_company_type_handler($atts) {
	global $linkedin_sc_company;
	return _linkedin_sc_format_text($linkedin_sc_company->type);
}

function linkedin_sc_company_size_handler($atts) {
	global $linkedin_sc_company;
	return _linkedin_sc_format_text($linkedin_sc_company->size);
}

function linkedin_sc_company_website_handler($atts) {
	global $linkedin_sc_company;
	return $linkedin_sc_company->website;
}

function linkedin_sc_company_industry_handler($atts) {
	global $linkedin_sc_company;
	return _linkedin_sc_format_text($linkedin_sc_company->industry);
}

function linkedin_sc_company_founded_handler($atts) {
	global $linkedin_sc_company;
	return _linkedin_sc_format_text($linkedin_sc_company->founded);
}
