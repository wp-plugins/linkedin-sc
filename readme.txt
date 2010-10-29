=== Plugin Name ===
Contributors: guillaumev
Donate link: http://www.viguierjust.com
Tags: linkedIn, resume, CV, curriculum, vitae
Requires at least: 2.7
Tested up to: 3.0.1
Stable tag: 1.0.4

Parses your linkedIn resume and allows you to display it using Shortcodes.

== Description ==

This plugin will parse your linkedIn profile and allow you to display it on any page or post using shortcodes, therefore allowing you to customize
the display.

Here is a list of the shortcodes you can use:
<ul>
	<li>[linkedinsc profile="guillaumev" lang="en"]: main shortcode, give here your profile name and the language you want your CV to be displayed in</li>
	<li>[linkedinsc_firstname]: displays your firstname</li>
	<li>[linkedinsc_lastname]: displays your lastname</li>
	<li>[linkedinsc_locality]: displays your current locality</li>
	<li>[linkedinsc_status]: displays your current status</li>
	<li>[linkedinsc_skills]: displays your skills</li>
	<li>[linkedinsc_summary]: displays your summary</li>
	<li>[linkedinsc_interests]: displays your interests</li>
	<li>[linkedinsc_photo]: displays the link to your profile picture (to be included in the src attribute of an img tag)</li>
	<li>[linkedinsc_exp]: each experience will be displayed according to the format given in the content of this shortcode</li>
	<li>[linkedinsc_exp_title]: title of the experience</li>
	<li>[linkedinsc_org_link]: link to the organization of the experience</li>
	<li>[linkedinsc_org_name]: name of the organization</li>
	<li>[linkedinsc_org_full_link]: will display a link to the organization if there is one, and only the name of the organization if the link is empty</li>
	<li>[linkedinsc_org_sector]: sector of the organization</li>
	<li>[linkedinsc_exp_start]: start date of the experience</li>
	<li>[linkedinsc_exp_end]: end date of the experience</li>
	<li>[linkedinsc_exp_description]: description of the experience</li>
	<li>[linkedinsc_edu]: each education will be displayed according to the format given in the content of this shortcode</li>
	<li>[linkedinsc_edu_title]: title of the university/school</li>
	<li>[linkedinsc_edu_degree]: degree</li>
	<li>[linkedinsc_edu_major]: major</li>
	<li>[linkedinsc_edu_start]: start date of the formation</li>
	<li>[linkedinsc_edu_end]: end date of the formation</li>
	<li>[linkedinsc_edu_notes]: description of the formation</li>
</ul>

Here is an example of how you could format your CV using those shortcodes:

<pre>
[linkedinsc profile="guillaumev" lang="en"]
&lt;h2 style="text-align: center;"&gt;[linkedinsc_status]&lt;/h2&gt;

&lt;h3&gt;Experiences&lt;/h3&gt;
[linkedinsc_exp]
&lt;div style="float: left; width: 150px;"&gt;[linkedinsc_exp_start] - [linkedinsc_exp_end]&lt;/div&gt;
&lt;div style="margin-left: 150px;"&gt;
&lt;b&gt;[linkedinsc_exp_title]&lt;/b&gt;, &lt;a href="[linkedinsc_org_link]"&gt;[linkedinsc_org_name]&lt;/a&gt;
&lt;em&gt;[linkedinsc_org_sector]&lt;/em&gt;
[linkedinsc_exp_description]
&lt;/div&gt;
[/linkedinsc_exp]
&lt;h3&gt;Education&lt;/h3&gt;
[linkedinsc_edu]
&lt;div style="float: left; width: 150px;"&gt;[linkedinsc_edu_start] - [linkedinsc_edu_end]&lt;/div&gt;
&lt;div style="margin-left: 150px;"&gt;
&lt;b&gt;[linkedinsc_edu_title]&lt;/b&gt;
&lt;em&gt;[linkedinsc_edu_degree] in [linkedinsc_edu_major]&lt;/em&gt;
[linkedinsc_edu_notes]
&lt;/div&gt;
[/linkedinsc_edu]
&lt;h3&gt;Computer skills and languages&lt;/h3&gt;
&lt;div style="margin-left: 150px;"&gt;
[linkedinsc_skills]
&lt;/div&gt;
&lt;h3&gt;Personal interests&lt;/h3&gt;
&lt;div style="margin-left: 150px;"&gt;
[linkedinsc_interests]
&lt;/div&gt;
[/linkedinsc]
</pre>

Finally, note that you can set the format of the date in the plugin settings page.

== Installation ==

1. Download it
2. Install it
3. Follow the instructions in the Description section

== Changelog ==

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

