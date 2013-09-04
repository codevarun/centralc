<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahModelEvents extends KModelTable
{	
    public function __construct(KConfig $config) 
	{			 
		parent::__construct($config);
		
		$this->getState()
			->insert('ohanah_category_id', 'int')
			->insert('ohanah_venue_id', 'int')
			->insert('filterEvents', 'string')
			->insert('featured', 'int')
			->insert('date', 'string')
			->insert('end_date', 'string')
			->insert('calendar_start_date', 'string')
			->insert('calendar_end_date', 'string')
			->insert('starting_date', 'string')
			->insert('ending_date', 'string')
			->insert('enabled', 'int')
			->insert('textToSearch', 'string')			 
			->insert('geolocated_city', 'string')
			->insert('geolocated_state', 'string')
			->insert('geolocated_country', 'string')
			->insert('recurringParent', 'string')
			->insert('created_by', 'int');
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		parent::_buildQueryWhere($query);
		
		$state = $this->getState();	
			
		if ($state->ohanah_category_id)
		   	$query->where('ohanah_category_id', '=', $state->ohanah_category_id);
		
		if ($state->ohanah_venue_id)
		   	$query->where('ohanah_venue_id', '=', $state->ohanah_venue_id);
		
		if ($state->geolocated_city) 
			$query->where('geolocated_city', '=',  $state->geolocated_city);
			
		if ($state->geolocated_state) 
			$query->where('geolocated_state', '=',  $state->geolocated_state);
			
		if ($state->geolocated_country) 
			$query->where('geolocated_country', '=',  $state->geolocated_country);

		if ($state->featured)
		   	$query->where('featured', '=', $state->featured);

		if ($state->date)
		   	$query->where('date', '>', $state->date);

		if ($state->end_date)
		   	$query->where('end_date', '<', $state->end_date);
		
		if ($state->calendar_start_date)
		   	$query->where('end_date', '>=', $state->calendar_start_date);

		if ($state->calendar_end_date)
		   	$query->where('date', '<=', $state->calendar_end_date);
		
		if ($state->starting_date)
		   	$query->where('date', '>=', $state->starting_date);

		if ($state->ending_date)
		   	$query->where('end_date', '<=', $state->ending_date);
				
		if ($state->created_by)
		   	$query->where('created_by', '=', $state->created_by);
				
		if ($state->enabled)
		   	$query->where('enabled', '=', $state->enabled);
		
		if ($state->recurringParent)
		   	$query->where('recurringParent', '=', $state->recurringParent);
		
		if ($state->textToSearch)
		   	$query->where('title', 'LIKE', '%'.$state->textToSearch.'%');

		if ($state->filterEvents)
		{
			$date = new KDate();
			
			$dst = '';
			if (JFactory::getApplication()->getPageParameters('com_ohanah')->get('dst') == '1') {
				$dst = '+1';
			}
						
			if ($state->filterEvents == 'past')
			{
				$query->where("SUBTIME(CONCAT_WS(' ', `end_date`,`end_time`), CONCAT_WS('', `timezone`".$dst.",':0:0')) < UTC_TIMESTAMP()");			
			}
			else if ($state->filterEvents == 'notpast')
			{
				$query->where("SUBTIME(CONCAT_WS(' ', `end_date`,`end_time`), CONCAT_WS('', `timezone`".$dst.",':0:0')) > UTC_TIMESTAMP()");			
			}
		}

		if ($state->direction) {
			$query->order("date", $state->direction);	
		} else {
			$query->order("date");	
		}
		
	}
	
	/**
	 * Using the columns function so i can concat the starting date and	time that i need for the view
	 * @see KModelTable::_buildQueryColumns()
	 */
	
	protected function _buildQueryColumns(KDatabaseQuery$query)
	{
		$query->columns[]="tbl.*";
		$query->columns[]=" CONCAT_WS('T',date,start_time) AS start ";
		$query->columns[]=" CONCAT_WS('T',end_date,end_time) AS end ";
	}
}