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

/**
 * LinkedIn public profile
 * 
 * Parses a public profile page and sets the attributes of the object
 * 
 * @author Guillaume Viguier-Just <guillaume@viguierjust.com>
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */

class LinkedInPublicProfile extends LinkedInProfile {
	/**
	 * LinkedIn default URL
	 * @var string
	 */
	protected $_url = 'http://www.linkedin.com/in/';
  
  /**
	 * Language required
	 * @var string
	 */
	protected $_language = '';
	
	/**
	 * Profile name
	 * @var string
	 */
	protected $_username = '';
	
	/**
	 * SimpleXML element
	 * @var SimpleXML
	 */
	protected $_xml = null;
  
	/**
	 * Constructor
	 * 
	 * @param string Name of the user whose profile is to be parsed or full URL to user profile
	 * @param string Language, set to en by default
	 */
	public function __construct($username, $language = 'en') {
		$profile_url = "";
		if (strpos($username, "http://") !== FALSE) {
			// Username is a URL
			$profile_url = $username;
			$profile_url = trim($profile_url, '/').'/'.$language;
		}
		else {
			$this->_username = $username;
			$profile_url = $this->_url.$this->_username.'/'.$language;
		}
		$this->_language = $language;
		$this->parse($profile_url);
	}
	
	/**
	 * Searches through the document with xpath and assigns to the right value
	 * 
	 * @param string Element to be searched
	 * @param string Class to be searched
	 * @param string Variable name to be assigned
	 */
	protected function search_and_assign($element, $class, $name) {
		foreach ($this->_xml->xpath('//'.$element.'[@class="'.$class.'"]') as $value) {
			$this->$name = $this->subXML($value->asXML());
		}
	}
	
	/**
	 * Getting $content of formatted expression
	 * "<tag attributes>$content</tag>". Tag will
	 * automatically determined.
	 *
	 * @return content of the tag
	 */
	protected function subXML($s){
		// Position of the first enclosure >
		$pos_first = strpos($s, '>');
		// Position of the last opening <
		$pos_last = strrpos($s, '<');
		return substr($s, $pos_first + 1, $pos_last - $pos_first - 1);
	}

	
	/**
	 * Parses a linkedIn profile URL using SimpleXML
	 * 
	 * @param string Profile URL
	 */
	protected function parse($profile_url) {
		// Create a stream
		$opts = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: ".$this->_language."\r\n"
			)
		);
		$context = stream_context_create($opts);
		$html_string = file_get_contents($profile_url, false, $context);
		$this->_response = $html_string;
		// Import the HTML into DOM before giving it to simpleXML
		$doc = new DOMDocument('1.0');
		@$doc->loadHTML($html_string);
		$this->_xml = simplexml_import_dom($doc);
		if($this->_xml) {
			$elements = array(
				array('span', 'given-name', 'first_name'),
				array('span', 'family-name', 'last_name'),
				array('p', 'title', 'headline'),
				array('dd', 'locality', 'location'),
				array('p', 'null', 'specialties'),
				//array('p', 'summary', 'summary'),
				array('p', '', 'interests'),
				//array('p', " ''", 'honors'),
				//array('p', 'groups', 'groups')
			);
			
			foreach($elements as $element) {
				$this->search_and_assign($element[0], $element[1], $element[2]);
			}
			
			// Reassigning location
			$location = $this->location;
			$this->location = new stdClass();
			$this->location->name = $location;
			
			// See http://wordpress.org/support/topic/plugin-linkedin-sc-missing-headline-title
			if(empty($this->headline)) {
				$this->search_and_assign('p', 'headline title', 'headline');
			}
			
			// Get profile picture if any
			foreach($this->_xml->xpath('//img[@class="photo"]') as $photo) {
				$this->picture_url = $photo['src'];
			}
			
			// Get positions
			$this->positions = array();
			foreach($this->_xml->xpath('//div[@class="position  first experience vevent vcard current-position"]') as $experience) {
				$exp = $this->fill_position($experience);
				$this->positions[] = $exp;
			}
			foreach($this->_xml->xpath('//div[@class="position   experience vevent vcard current-position"]') as $experience) {
				$exp = $this->fill_position($experience);
				$this->positions[] = $exp;
			}
			foreach($this->_xml->xpath('//div[@class="position   experience vevent vcard past-position"]') as $experience) {
				$exp = $this->fill_position($experience);
				$this->positions[] = $exp;
			}
			
			// Get education
			$this->educations = array();
			foreach($this->_xml->xpath('//div[@class="position  first education vevent vcard"]') as $education) {
				$ed = $this->fill_education($education);
				$this->educations[] = $ed;
			}
			foreach($this->_xml->xpath('//div[@class="position  education vevent vcard"]') as $education) {
				$ed = $this->fill_education($education);
				$this->educations[] = $ed;
			}
		}
	}
	
	private function fill_position($experience) {
		$exp = new stdClass();
		$exp->title = trim($experience->div->h3->span);
		$exp->company = new stdClass();
		if($experience->div->h4->strong->a) {
			$exp->company->name = trim($experience->div->h4->strong->a->span);
			$exp->company->link = $experience->div->h4->strong->a['href'];
		} else {
			$exp->company->name = trim($experience->div->h4->strong->span);
		}
		foreach($experience->xpath('.//p[@class="orgstats organization-details"]') as $sector) {
			$exp->company->industry = trim(strtr($sector, '()', '  '));
		}
		foreach($experience->xpath('.//abbr[@class="dtstart"]') as $start) {
			$exp->start_date = $start['title'];
		}
		foreach($experience->xpath('.//abbr[@class="dtend"]') as $end) {
			$exp->end_date = $end['title'];
		}
		foreach($experience->xpath('.//p[@class=" desc"]') as $description) {
			$exp->summary = $this->subXML($description->asXML());
		}
		return $exp;
	}
	
	private function fill_education($education) {
		$ed = new stdClass();
		$ed->school_name = trim($education->h3);
		foreach($education->xpath('.//span[@class="degree"]') as $degree) {
			$ed->degree = $degree;
		}
		foreach($education->xpath('.//span[@class="major"]') as $major) {
			$ed->field_of_study = $major;
		}
		foreach($education->xpath('.//abbr[@class="dtstart"]') as $start) {
			$ed->start_date = $start['title'];
		}
		foreach($education->xpath('.//abbr[@class="dtend"]') as $end) {
			$ed->end_date = $end['title'];
		}
		foreach($education->xpath('.//p[@class=" desc"]') as $notes) {
			$ed->notes = $this->subXML($notes->asXML());
		}
		return $ed;
	}
}
