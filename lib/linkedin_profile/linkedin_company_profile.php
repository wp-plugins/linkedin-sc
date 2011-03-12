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
 * LinkedIn company profile
 * 
 * Abstract class for parsing company profiles
 * 
 * @author Guillaume Viguier-Just <guillaume@viguierjust.com>
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */
abstract class LinkedInCompanyProfile {
	
	/**
	 * Name
	 * @var string
	 */
	public $name = '';
	
	/**
	 * Logo
	 * @var string
	 */
	public $logo = '';
	
	/**
	 * Description
	 * @var string
	 */
	public $description = '';
	
	/**
	 * Specialties
	 * @var string
	 */
	public $specialties = '';
	
	/**
	 * Type
	 * @var string
	 */
	public $type = '';
	
	/**
	 * Size
	 * @var string
	 */
	public $size = '';
	
	/**
	 * Website
	 * @var string
	 */
	public $website = '';
	
	/**
	 * Industry
	 * @var string
	 */
	public $industry = '';
	
	/**
	 * Founded
	 * @var string
	 */
	public $founded = '';
	
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
