=== LinkedIn SC ===
Contributors: guillaumev
Donate link: http://www.viguierjust.com
Tags: linkedIn, resume, CV, curriculum, vitae
Requires at least: 2.7
Tested up to: 3.0.5
Stable tag: 1.1.3

Parses your linkedIn resume and allows you to display it using Shortcodes.

== Description ==

This plugin will parse your linkedIn profile and allow you to display it on any page or post using shortcodes, therefore allowing you to customize
the display. You can choose to parse your LinkedIn public profile or use the LinkedIn API to parse your private profile fields.

Here is a list of the shortcodes you can use (see http://developer.linkedin.com/docs/DOC-1061 for reference):
<ul>
	<li>[linkedinsc profile="guillaumev" lang="en"]: main shortcode, give here your profile name and the language you want your CV to be displayed in. Note that you can also use a full profile URL instead of your username</li>
	<li>[linkedinsc_first_name]: displays your firstname</li>
	<li>[linkedinsc_last_name]: displays your lastname</li>
	<li>[linkedinsc_headline]: displays your headline</li>
	<li>[linkedinsc_location_name]: displays your current location</li>
	<li>[linkedinsc_industry]: displays your industry (only available if using LinkedIn API)</li>
	<li>[linkedinsc_summary]: displays your summary</li>
	<li>[linkedinsc_current_status]: displays your current_status (only available if using LinkedIn API)</li>
	<li>[linkedinsc_proposal_comments]: displays your proposal comments (only available if using LinkedIn API)</li>
	<li>[linkedinsc_specialties]: displays your specialties</li>
	<li>[linkedinsc_associations]: displays your associations (only available if using LinkedIn API)</li>
	<li>[linkedinsc_honors]: displays your distinctions</li>
	<li>[linkedinsc_interests]: displays your interests</li>
	<li>[linkedinsc_picture_url]: displays the link to your profile picture (to be included in the src attribute of an img tag)</li>
	<li>[linkedinsc_groups]: displays your linkedin groups</li>
	<li>[linkedinsc_certifications]: each certification will be displayed according to the format given in the content of this shortcode (only available if using LinkedIn API)</li>
	<li>[linkedinsc_certification_name]: name of the certification (only available if using LinkedIn API)</li>
	<li>[linkedinsc_certification_authority]: name of the authority of the certification (only available if using LinkedIn API)</li>
	<li>[linkedinsc_certification_number]: number of the certification (only available if using LinkedIn API)</li>
	<li>[linkedinsc_certification_start_date]: start date of the certification (only available if using LinkedIn API)</li>
	<li>[linkedinsc_certification_end_date]: end date of the certification (only available if using LinkedIn API)</li>
	<li>[linkedinsc_educations]: each education will be displayed according to the format given in the content of this shortcode</li>
	<li>[linkedinsc_education_school_name]: school name</li>
	<li>[linkedinsc_education_degree]: degree</li>
	<li>[linkedinsc_education_field_of_study]: field of study</li>
	<li>[linkedinsc_education_start_date]: start date of the formation</li>
	<li>[linkedinsc_education_end_date]: end date of the formation</li>
	<li>[linkedinsc_education_notes]: description of the formation</li>
	<li>[linkedinsc_positions]: each position will be displayed according to the format given in the content of this shortcode</li>
	<li>[linkedinsc_position_title]: title of the position</li>
	<li>[linkedinsc_position_company_link]: link to the company of the position (available only if using LinkedIn public profile)</li>
	<li>[linkedinsc_position_company_name]: name of the company</li>
	<li>[linkedinsc_position_company_full_link]: will display a link to the company if there is one, and only the name of the company if the link is empty</li>
	<li>[linkedinsc_position_company_industry]: industry of the organization</li>
	<li>[linkedinsc_position_start_date]: start date of the position</li>
	<li>[linkedinsc_position_end_date]: end date of the position</li>
	<li>[linkedinsc_position_summary]: summary of the position</li>
	<li>[linkedinsc_languages]: each language will be displayed according to the format given in the content of this shortcode (only available if using LinkedIn API)</li>
	<li>[linkedinsc_language_name]: name of the language (only available if using LinkedIn API)</li>
	<li>[linkedinsc_language_proficiency_level]: proficiency level of the language (only available if using LinkedIn API)</li>
	<li>[linkedinsc_language_proficiency_name]: proficiency name of the language (only available if using LinkedIn API)</li>
	<li>[linkedinsc_patents]: each patent will be displayed according to the format given in the content of this shortcode (only available if using LinkedIn API)</li>
	<li>[linkedinsc_patent_title]: title of the patent (only available if using LinkedIn API)</li>
	<li>[linkedinsc_patent_summary]: summary of the patent (only available if using LinkedIn API)</li>
	<li>[linkedinsc_patent_number]: number of the patent (only available if using LinkedIn API)</li>
	<li>[linkedinsc_patent_status_name]: status name of the patent (only available if using LinkedIn API)</li>
	<li>[linkedinsc_patent_office_name]: office name of the patent (only available if using LinkedIn API)</li>
	<li>[linkedinsc_patent_inventors_name]: name of the inventors of the patent (only available if using LinkedIn API)</li>
	<li>[linkedinsc_patent_date]: date of the patent (only available if using LinkedIn API)</li>
	<li>[linkedinsc_patent_url]: url of the patent (only available if using LinkedIn API)</li>
	<li>[linkedinsc_publications]: each publication will be displayed according to the format given in the content of this shortcode (only available if using LinkedIn API)</li>
	<li>[linkedinsc_publication_title]: title of the publication (only available if using LinkedIn API)</li>
	<li>[linkedinsc_publication_publisher_name]: name of the publication (only available if using LinkedIn API)</li>
	<li>[linkedinsc_publication_authors_name]: name of the authors of the publication (only available if using LinkedIn API)</li>
	<li>[linkedinsc_publication_date]: date of the publication (only available if using LinkedIn API)</li>
	<li>[linkedinsc_publication_url]: url of the publication (only available if using LinkedIn API)</li>
	<li>[linkedinsc_publication_summary]: summary of the publication (only available if using LinkedIn API)</li>
	<li>[linkedinsc_skills]: each skill will be displayed according to the format given in the content of this shortcode (only available if using LinkedIn API)</li>
	<li>[linkedinsc_skill_name]: name of the skill (only available if using LinkedIn API)</li>
	<li>[linkedinsc_skill_proficiency_level]: proficiency level of the skill (only available if using LinkedIn API)</li>
	<li>[linkedinsc_skill_proficiency_name]: name of the proficiency of the skill (only available if using LinkedIn API)</li>
	<li>[linkedinsc_skill_years_name]: number of years of experience (only available if using LinkedIn API)</li>
</ul>

Here is an example of how you could format your CV using those shortcodes:

<pre>
[linkedinsc profile="guillaumev" lang="en"]
&lt;h2 style="text-align: center;"&gt;[linkedinsc_headline]&lt;/h2&gt;
&lt;h3&gt;Experiences&lt;/h3&gt;
[linkedinsc_positions]
&lt;div style="float: left; width: 150px;"&gt;[linkedinsc_position_start_date] - [linkedinsc_position_end_date]&lt;/div&gt;
&lt;div style="margin-left: 150px;"&gt;
&lt;b&gt;[linkedinsc_position_title]&lt;/b&gt;, [linkedinsc_position_company_name]&lt;br /&gt;
&lt;em&gt;[linkedinsc_position_company_industry]&lt;/em&gt;&lt;br /&gt;
[linkedinsc_position_summary]&lt;br /&gt;&lt;br /&gt;
&lt;/div&gt;
[/linkedinsc_positions]
&lt;h3&gt;Education&lt;/h3&gt;
[linkedinsc_educations]
&lt;div style="float: left; width: 150px;"&gt;[linkedinsc_education_start_date] - [linkedinsc_education_end_date]&lt;/div&gt;
&lt;div style="margin-left: 150px;"&gt;
&lt;b&gt;[linkedinsc_education_school_name]&lt;/b&gt;&lt;br /&gt;
&lt;em&gt;[linkedinsc_education_degree] en [linkedinsc_education_field_of_study]&lt;/em&gt;&lt;br /&gt;
[linkedinsc_education_notes]&lt;br /&gt;&lt;br /&gt;
&lt;/div&gt;
[/linkedinsc_educations]
&lt;h3&gt;Computer skills&lt;/h3&gt;
&lt;div style="margin-left: 150px;"&gt;
[linkedinsc_skills]
[linkedinsc_skill_name]: [linkedinsc_skill_years_name] années d'expérience
[/linkedinsc_skills]
&lt;/div&gt;
&lt;h3&gt;Languages&lt;/h3&gt;
&lt;div style="margin-left: 150px;"&gt;
[linkedinsc_languages]
[linkedinsc_language_name]: [linkedinsc_language_proficiency_name]
[/linkedinsc_languages]
&lt;/div&gt;
&lt;h3&gt;Certifications&lt;/h3&gt;
&lt;div style="margin-left: 150px;"&gt;
[linkedinsc_certifications]
[linkedinsc_certification_name]
[/linkedinsc_certifications]
&lt;/div&gt;
&lt;h3&gt;Personal interests&lt;/h3&gt;
&lt;div style="margin-left: 150px;"&gt;
[linkedinsc_interests]
&lt;/div&gt;
[/linkedinsc]
</pre>

Finally, note that you can set the format of the date in the plugin settings page.

**The LinkedIn API part is for now considered as experimental**

**In order to use LinkedIn API, you NEED to have SSL enabled for your admin backend. Set FORCE_SSL_ADMIN to true in your configuration: http://codex.wordpress.org/Administration_Over_SSL**

This plugin was sponsored by <a href="http://www.csrjobs.nl">CSRJobs</a>.

== Installation ==

1. Download it
2. Install it
3. Follow the instructions in the Description section
4. A detailed configuration process to use LinkedIn API is available here: http://www.viguierjust.com/en/2011/02/07/using-linkedin-sc-with-linkedin-api/

== Changelog ==

= 1.1.3 =
 * Updated public profile parsing due to LinkedIn public profile's HTML change

= 1.1.2 =
 * Fixed T_PAAMAYIM_NEKUDOTAYIM bug
 * Implemented LinkedIn exchange API: http://developer.linkedin.com/docs/DOC-1252
 * You can now parse any profile (including non-english profiles) using LinkedIn API
 
= 1.1.1 =
 * Fixed critical bug for use with LinkedIn API

= 1.1.0 =
 * Major changes
 * It is now possible to parse private fields using LinkedIn API
 * Various shortcodes added (see full list in plugin's instructions)
 * Older shortcodes are now deprecated but left for compatibility reasons
 
= 1.0.6 =
 * Added [linkedinsc_honors] shortcode
 * Added [linkedinsc_groups] shortcode

= 1.0.5 =
 * Supporting all types of public profiles (see http://wordpress.org/support/topic/plugin-linkedin-sc-please-support-all-types-of-public-profiles)

= 1.0.4 =
 * Fixing bug with Simple Facebook Connect module (see http://wordpress.org/support/topic/plugin-linkedin-sc-regarding-linkedin_sc_exp_num-and-linkedin_sc_edu_num)

= 1.0.3 =
 * Fixed a bug in the support for br tags (see http://wordpress.org/support/topic/plugin-linkedin-sc-all-the-line-breaks-are-gone)

= 1.0.2 =
 * Fixed the missing headline title bug (see http://wordpress.org/support/topic/plugin-linkedin-sc-missing-headline-title)
 * Added support for br tags (see http://wordpress.org/support/topic/plugin-linkedin-sc-all-the-line-breaks-are-gone)

= 1.0.1 =
 * Added the [linkeinsc_org_full_link] shortcode
 * Added the [linkedinsc_summary] shortcode

= 1.0 =
 * First version

== Upgrade Notice ==

= 1.1.0 =
Please note that older shortcodes are now deprecated. They have been left in the plugin for compatibility reasons but will be removed in the future. Think about updating your shortcodes ! The 
full list of the new shortcodes is available on the plugin description page.
