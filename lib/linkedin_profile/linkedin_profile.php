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


/**
 * LinkedIn profile
 * 
 * Parses a profile page and sets the attributes of the object
 * 
 * @author Guillaume Viguier-Just <guillaume@viguierjust.com>
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */
abstract class LinkedInProfile {
	
	/**
	 * First name
	 * @var string
	 */
	public $first_name = '';
	
	/**
	 * Last name
	 * @var string
	 */
	public $last_name = '';
	
	/**
	 * Headline
	 * @var string
	 */
	public $headline = '';
	
	/**
	 * Current locality
	 * @var string
	 */
	public $location = NULL;
	
	/**
	 * Industry
	 * @var string
	 */
	public $industry = '';
	
	/**
	 * Current status
	 * @var string
	 */
	public $current_status = '';
  
	/**
	 * Summary
	 * @var string
	 */
	public $summary = '';
	
	/**
	 * Specialties
	 * @var string
	 */
	public $specialties = '';
	
	/**
	 * Proposal comments
	 * @var string
	 */
	public $proposal_comments = '';
	
	/**
	 * Associations
	 * @var string
	 */
	public $associations = '';
	
	/**
	 * Honors
	 * @var string
	 */
	public $honors = '';
	
	/**
	 * Interests
	 * @var string
	 */
	public $interests = '';
	
	/**
	 * Positions
	 * @var array
	 */
	public $positions = array();
	
	/**
	 * Publications
	 * @var array
	 */
	public $publications = array();
	
	/**
	 * Patents
	 * @var array
	 */
	public $patents = array();
	
	/**
	 * Languages
	 * @var array
	 */
	public $languages = array();
	
	/**
	 * Skills
	 * @var array
	 */
	public $skills = array();
	
	/**
	 * Certifications
	 * @var array
	 */
	public $certifications = array();
	
	/**
	 * Educations
	 * @var array
	 */
	public $educations = array();
	
	/**
	 * Picture URL
	 * @var string
	 */
	public $picture_url = '';
	
	/**
	 * XML or HTML response
	 * @var string
	 */
	protected $_response = null;
	
	/**
	 * Returns the XML or HTML response
	 * 
	 * @return string Response
	 */
	public function getResponse() {
		return $this->_response;
	}
	
}
