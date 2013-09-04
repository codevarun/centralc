<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahModelAttachments extends KModelTable
{
    public function __construct(KConfig $config) 
	{
		parent::__construct($config);
		
		$this->getState()
		 	 ->insert('target_id', 'int')
		 	 ->insert('target_type', 'string')
			 ->insert('name', 'string');
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		$state = $this->getState();
				
		if ($state->target_id) 
			$query->where('target_id', '=',  $state->target_id);
			
		if ($state->target_type) 
			$query->where('target_type', '=',  $state->target_type);
			
		if ($state->name) 
			$query->where('name', '=',  $state->name);

		parent::_buildQueryWhere($query);
	}
}