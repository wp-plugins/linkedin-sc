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

require_once(dirname(__FILE__).'/linkedin_company_profile.php');

/**
 * LinkedIn company public profile
 * 
 * Parses a company public profile page and sets the attributes of the object
 * 
 * @author Guillaume Viguier-Just <guillaume@viguierjust.com>
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */

class LinkedInCompanyPublicProfile extends LinkedInCompanyProfile {
	/**
	 * LinkedIn default URL
	 * @var string
	 */
	protected $_url = 'http://www.linkedin.com/company/';
	
	/**
	 * Company id
	 * @var string
	 */
	protected $_id = '';
	
	/**
	 * SimpleXML element
	 * @var SimpleXML
	 */
	protected $_xml = null;
  
	/**
	 * Constructor
	 * 
	 * @param string Company id to be parsed
	 */
	public function __construct($id) {
		$url = "";
		if (strpos($id, "http://") !== FALSE) {
			// id is a URL
			$url = $id;
		}
		else {
			$this->_id = $id;
			$url = $this->_url.$id;
		}
		$this->parse($url);
	}

	
	/**
	 * Parses a company profile URL using SimpleXML
	 * 
	 * @param string Profile URL
	 */
	protected function parse($url) {
		$html_string = file_get_contents($url);
		$this->_response = $html_string;
		// Import the HTML into DOM before giving it to simpleXML
		$doc = new DOMDocument('1.0');
		@$doc->loadHTML($html_string);
		$this->_xml = simplexml_import_dom($doc);
		if($this->_xml) {
			
			// Get logo and name
			foreach($this->_xml->xpath('//img[@class="logo"]') as $logo) {
        $this->name = $logo['alt'];
				$this->logo = $logo['src'];
			}
			
			// Get description
			foreach($this->_xml->xpath('//div[@class="text-logo"]') as $text_logo) {
				$this->description = $text_logo->p;
        $this->specialties = $text_logo->p[1];
			}
      
      // Get other information
      foreach($this->_xml->xpath('//div[@class="content inner-mod"]') as $information) {
        $dl = $information->dl;
        $i = 0;
        $dd = $dl->dd[$i];
        while($dd) {
          switch($i) {
            case 0:
              $this->type = $dd;
              break;
            case 1:
              $this->size = $dd;
              break;
            case 2:
              $this->website = $dd->a;
              break;
            case 3:
              $this->industry = $dd;
              break;
            case 4:
              $this->founded = $dd;
              break;
          }
          $i++;
          $dd = $dl->dd[$i];
        }
      }
    }
	}
}
