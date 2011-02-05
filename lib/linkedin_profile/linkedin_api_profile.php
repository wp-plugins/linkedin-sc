<?php
/**
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

require_once(dirname(__FILE__).'/linkedin_profile.php');
require_once(dirname(__FILE__).'/linkedin_3.0.1.class.php');

/**
 * LinkedIn API profile
 * 
 * Parses a profile using LinkedIn API.
 * 
 * Please note that this will work only if you have a valid OAuth 2 bearer token.
 * 
 * @author Guillaume Viguier-Just <guillaume@viguierjust.com>
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */

class LinkedInAPIProfile extends LinkedInProfile {
  
  /**
   * LinkedIn API
   * @var LinkedIn
   */
  protected $_api = null;
  
  /**
   * LinkedIn profile url
   */
  const profile_url = 'https://api.linkedin.com/v1/people/';

	
	/**
	 * SimpleXML element
	 * @var SimpleXML
	 */
	protected $_xml = null;
  
  /**
   * Fields to retrieve
   * 
   * @var array
   */
  protected $_fields = array(
    'id',
    'first-name',
    'last-name',
    'headline',
    'location',
    'industry',
    'current-status',
    'summary',
    'specialties',
    'proposal-comments',
    'associations',
    'honors',
    'interests',
    'positions',
    'publications:(id,title,publisher,authors,date,url,summary)',
    'patents:(id,title,summary,number,status,office,inventors,date,url)',
    'languages:(id,language,proficiency)',
    'skills:(id,skill,proficiency,years)',
    'certifications:(id,name,authority,number,start-date,end-date)',
    'educations',
    'picture-url',
  );
  
	/**
	 * Constructor
	 * 
   * @param string OAuth 2 bearer token
   * @param array List of fields to retrieve
	 */
	public function __construct($oauth_token, $language = 'en', $fields = NULL, $build_from_cache = FALSE) {
    if ($build_from_cache == FALSE) {
      if ($fields != NULL) {
        $this->_fields = $fields;
      }
      $url = $this->build_url($oauth_token);
      $locale = $this->convert_locale($language);
      $response = $this->fetch($url, $locale);
      $this->_response = $response;
    }
    else {
      $this->_response = $oauth_token;
    }
    $this->parse();
	}
  
  /**
   * Fetch profile
   * 
   * @param string URL
   * @param string Language
   * @return string Response
   */
  private function fetch($url, $language) {
    // Create a stream
		$opts = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: ".$language."\r\n"
			)
		);
		$context = stream_context_create($opts);
		$response = file_get_contents($url, false, $context);
    return $response;
  }
  
  /**
   * Convert locales
   * 
   * @param string Locale to be converted
   * @return string Converted locale
   */
  private function convert_locale($in) {
    $out = 'en-US';
    switch ($in) {
      case 'fr':
        $out = 'fr-FR';
        break;
      case 'de':
        $out = 'de-DE';
        break;
      case 'it':
        $out = 'it-IT';
        break;
      case 'pt':
        $out = 'pt-BR';
        break;
      case 'es':
        $out = 'es-ES';
        break;
      default:
        $out = 'en-US';
        break;
    }
    return $out;
  }
  
  /**
   * Builds the url with the OAuth token and the fields to retrieve
   */
  protected function build_url($oauth_token) {
    $url = $this::profile_url;
    $fields = implode(',', $this->_fields);
    $fields = '~:('.$fields.')';
    $url .= $fields.'?oauth_token='.$oauth_token;
    return $url;
  }
	
	/**
   * Parse a the LinkedIn response
   * 
   */
  protected function parse() {
    $xml = new SimpleXMLElement($this->_response);
    $this->first_name = $xml->{'first-name'};
    $this->last_name = $xml->{'last-name'};
    $this->headline = $xml->headline;
    $this->location->name = $xml->location->name;
    $this->location->country = $xml->location->country->code;
    $this->industry = $xml->industry;
    $this->current_status = $xml->{'current-status'};
    $this->summary = $xml->summary;
    $this->specialties = $xml->specialties;
    $this->proposal_comments = $xml->{'proposal-comments'};
    $this->associations = $xml->associations;
    $this->honors = $xml->honors;
    $this->interests = $xml->interests;
    
    if ($xml->positions->position) {
      // Positions
      foreach ($xml->positions->position as $position) {
        $exp = new stdClass();
        $exp->title = $position->title;
        $exp->summary = $position->summary;
        $month = $position->{'start-date'}->month;
        if (strlen($month) == 1) {
          $month = '0'.$month;
        }
        $exp->start_date = $position->{'start-date'}->year.'-'.$month;
        $month = $position->{'end-date'}->month;
        if (strlen($month) == 1) {
          $month = '0'.$month;
        }
        $exp->end_date = $position->{'end-date'}->year.'-'.$month;
        $exp->company = new stdClass();
        $exp->company->name = $position->company->name;
        $exp->company->industry = $position->company->industry;
        $this->positions[] = $exp;
      }
    }
    
    if ($xml->publications->publication) {
      // Publications
      foreach ($xml->publications->publication as $publication) {
        $pub = new stdClass();
        $pub->id = $publication->id;
        $pub->title = $publication->title;
        $pub->publisher->name = $publication->publisher->name;
        $pub->authors->name = $publication->authors->name;
        $pub->date = $publication->date;
        $pub->url = $publication->url;
        $pub->summary = $publication->summary;
        $this->publications[] = $pub;
      }
    }
    
    if ($xml->patents->patent) {
      // Patents
      foreach ($xml->patents->patent as $patent) {
        $pat = new stdClass();
        $pat->id = $patent->id;
        $pat->title = $patent->title;
        $pat->summary = $patent->summary;
        $pat->number = $patent->number;
        $pat->status->id = $patent->status->id;
        $pat->status->name = $patent->status->name;
        $pat->office->name = $patent->office->name;
        $pat->inventors->name = $patent->inventors->name;
        $pat->date = $patent->date;
        $pat->url = $patent->url;
        $this->patents[] = $pat;
      }
    }
    
    
    if ($xml->languages->language) {
      // Languages
      foreach ($xml->languages->language as $language) {
        $lan = new stdClass();
        $lan->id = $language->id;
        $lan->language->name = $language->language->name;
        $lan->proficiency->level = $language->proficiency->level;
        $lan->proficiency->name = $language->proficiency->name;
        $this->languages[] = $lan;
      }
    }
    
    if ($xml->skills->skill) {
      // Skills
      foreach ($xml->skills->skill as $skill) {
        $ski = new stdClass();
        $ski->id = $skill->id;
        $ski->skill->name = $skill->skill->name;
        $ski->proficiency->level = $skill->proficiency->level;
        $ski->proficiency->name = $skill->proficiency->name;
        $ski->years->name = $skill->years->name;
        $this->skills[] = $ski;
      }
    }
    
    if ($xml->certifications->certification) {
      // Certifications
      foreach ($xml->certifications->certification as $certification) {
        $cer = new stdClass();
        $cer->id = $certification->id;
        $cer->name = $certification->name;
        $cer->authority->name = $certification->authority->name;
        $cer->number = $certification->number;
        $cer->start_date = $certification->start_date;
        $cer->end_date = $certification->end_date;
        $this->certifications[] = $cer;
      }
    }
    
    if ($xml->educations->education) {
      // Educations
      foreach ($xml->educations->education as $education) {
        $ed = new stdClass();
        $ed->school_name = $education->{'school-name'};
        $ed->notes = $education->notes;
        $ed->start_date = $education->{'start-date'}->year;
        $ed->end_date = $education->{'end-date'}->year;
        $ed->degree = $education->degree;
        $ed->field_of_study = $education->{'field-of-study'};
        $this->educations[] = $ed;
      }
    }
    
    $this->picture_url = $xml->{'picture-url'};
    
  }
}