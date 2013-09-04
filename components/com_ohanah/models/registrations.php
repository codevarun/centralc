<?php
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahModelRegistrations extends KModelTable
{
	public function __construct(KConfig $config) 
	{				
		parent::__construct($config);
		
		$this->getState()
			 ->insert('ohanah_event_id', 'int')
			 ->insert('number_of_tickets', 'int')
			 ->insert('name', 'string')
		 	 ->insert('email', 'string')
		 	 ->insert('created_by', 'int')
		 	 ->insert('notes', 'string');
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		$state = $this->getState();
				
		if ($state->ohanah_event_id) 
			$query->where('ohanah_event_id', '=', $state->ohanah_event_id);

		if ($state->created_by)
			$query->where('created_by', '=', $state->created_by);
		
		parent::_buildQueryWhere($query);
	}
}