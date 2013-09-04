<?php
/**
 * @package		mod_sidebar
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanaheventsHtml extends ModDefaultHtml
{
	public function __construct(KConfig $config)
    {
        parent::__construct($config);
        $this->params  = $config->params;
    }
    
	public function display()
	{
		JFactory::getLanguage()->load('com_ohanah'); 
      	JFactory::getDocument()->addStyleSheet(JURI::root(1).'/media/com_ohanah/css/screen.css');
		
		$filterEvents = 'all';
		
		if ($this->params->get('list_type') == 'notpast')
			$filterEvents = 'notpast';
		else if ($this->params->get('list_type') == 'past')
			$filterEvents = 'past';

		$sort = 'date, start_time';
		$direction = $this->params->get('direction');
		
		$model = $this->getService('com://site/ohanah.model.events');
		
		if ($this->params->get('showOnlyACategory') == '1') {
			$model->set('ohanah_category_id', $this->params->get('showOnlyCategoryId'));
		}
		
		$model->set('filterEvents', $filterEvents)
			->set('sort', $sort)
			->set('enabled', 1)
			->set('direction', $direction)
			->set('limit', $this->params->get('list_max_number'));
		
		$model->set('featured', $this->params->get('showOnlyFeatured'));
		
		$this->assign('events', $model->getList());
		$this->assign('displayStyle', $this->params->get('displayStyle'));
		$this->assign('user', JFactory::getUser());
		
		return parent::display();	
	}
}
