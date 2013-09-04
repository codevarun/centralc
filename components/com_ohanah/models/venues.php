<?php
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahModelVenues extends KModelTable
{
    public function __construct(KConfig $config) 
	{
		parent::__construct($config);
		
		$this->getState()
		 	 ->insert('title', 'string')
		 	 ->insert('address', 'string')
		 	 ->insert('latitude', 'string')
		 	 ->insert('longitude', 'string')
		 	 ->insert('timezone', 'string')
		 	 ->insert('geolocated_city', 'string')
		 	 ->insert('geolocated_country', 'string')
			 ->insert('enabled', 'int')			 
			 ->insert('published', 'string');
	}
	
	protected function _buildQueryOrder(KDatabaseQuery $query)
	{
		$query->order('title', 'ASC');
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		$state = $this->getState();
				
		if ($state->title) 
			$query->where('title', '=', $state->title);

		if ($state->address) 
			$query->where('address', '=', $state->address);

		if ($state->latitude) 
			$query->where('latitude', '=', $state->latitude);

		if ($state->longitude) 
			$query->where('longitude', '=', $state->longitude);

		if ($state->timezone) 
			$query->where('timezone', '=', $state->timezone);

		if ($state->geolocated_city) 
			$query->where('geolocated_city', '=', $state->geolocated_city);
		
		if ($state->geolocated_country) 
			$query->where('geolocated_country', '=', $state->geolocated_country);
		
		if ($state->enabled) 
			$query->where('enabled', '=', $state->enabled);
		
		if ($state->search) {
			$search = '%'.$state->search.'%';
			$query->where('tbl.description', 'LIKE',  $search);
			$query->where('tbl.title', 'LIKE',  $search, 'OR');
		}
		
		if ($state->published) {
			if ($state->published == 'false')
				$query->where('enabled', '=',  '0');
			if ($state->published == 'true')
				$query->where('enabled', '=',  '1');
		}
		
		parent::_buildQueryWhere($query);
	}
}