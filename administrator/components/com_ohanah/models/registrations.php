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
		 	 ->insert('hasPaid', 'string')
		 	 ->insert('notes', 'string');
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		$state = $this->getState();
				
		if ($state->ohanah_event_id) 
			$query->where('ohanah_event_id', '=', $state->ohanah_event_id);

		if ($state->hasPaid) {
			if ($state->hasPaid == 'false')
				$query->where('paid', '=',  '0');
			if ($state->hasPaid == 'true')
				$query->where('paid', '=',  '1');
		}
		
		parent::_buildQueryWhere($query);
	}
}