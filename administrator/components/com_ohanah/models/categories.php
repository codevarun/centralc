<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahModelCategories extends KModelTable
{
    public function __construct(KConfig $config) 
	{
		parent::__construct($config);
		
		$this->getState()
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
				
		if ($state->enabled) 
			$query->where('enabled', '=', $state->enabled);

		if ($state->published) {
			if ($state->published == 'false')
				$query->where('enabled', '=',  '0');
			if ($state->published == 'true')
				$query->where('enabled', '=',  '1');
		}

		parent::_buildQueryWhere($query);
	}
}