<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahModelEvents extends KModelTable
{
    public function __construct(KConfig $config) 
	{
		parent::__construct($config);
		
		$this->getState()
		 	 ->insert('title', 'string')
		 	 ->insert('date', 'string')
			 ->insert('end_date', 'string')
			 ->insert('ohanah_category_id', 'int')
			 ->insert('recurringParent', 'int')
			 ->insert('ohanah_venue_id', 'int')		
			 ->insert('filterEvents', 'string')
			 ->insert('frontend_submitted', 'int')
			 ->insert('emptySlug', 'int')
			 ->insert('enabled', 'int')
			 ->insert('published', 'string');
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		$state = $this->getState();
		
		if ($state->search) {
			$search = '%'.$state->search.'%';
			$query->where('tbl.description', 'LIKE',  $search);
			$query->where('tbl.title', 'LIKE',  $search, 'OR');
		}
		
		if ($state->emptySlug) {
			$query->where('slug', '=', '');
		}

		if ($state->ohanah_category_id) 
			$query->where('ohanah_category_id', '=',  $state->ohanah_category_id);
			
		if ($state->ohanah_venue_id) 
			$query->where('ohanah_venue_id', '=',  $state->ohanah_venue_id);
		
		if ($state->recurringParent) {
			$query->where('recurringParent', '=',  $state->recurringParent);
		}
			
		if ($state->date) 
			$query->where('date', '=',  $state->date);
		
		if ($state->enabled) 
			$query->where('enabled', '=',  $state->enabled);

		if ($state->frontend_submitted) 
			$query->where('frontend_submitted', '=',  $state->frontend_submitted);

		if ($state->published) {
			if ($state->published == 'false')
				$query->where('enabled', '=',  '0');
			if ($state->published == 'true')
				$query->where('enabled', '=',  '1');
		}
			
		if ($state->filterEvents)
		{
			$date = new KDate();
			
			$dst = '';
			if (JComponentHelper::getParams('com_ohanah')->get('dst') == '1') {
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

		parent::_buildQueryWhere($query);
	}
}