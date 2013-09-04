<?php
/**b2
 * @package		mod_ohanahvenueinfo
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanahvenueinfoHtml extends ModDefaultHtml
{
	public function __construct(KConfig $config)
    {
        parent::__construct($config);
        $this->params  = $config->params;
    }
    
	public function display()
	{
		if (KRequest::get('get.option', 'string') == 'com_ohanah') {
			if (KRequest::get('get.view', 'string') == 'events') {
				
				$pageparameters =& JFactory::getApplication()->getPageParameters();

				$ohanah_venue_id = $pageparameters->get('ohanah_venue_id');
				if (KRequest::get('get.ohanah_venue_id', 'int')) {
					$ohanah_venue_id = KRequest::get('get.ohanah_venue_id', 'int');
				}

				$venue = $this->getService('com://admin/ohanah.model.venues')->id($ohanah_venue_id)->getItem();

				$this->assign('venue', $venue);
				$this->assign('params', $this->params);
				
				return parent::display();
						
			} else if (KRequest::get('get.view', 'string') == 'event') {
				
				$event = $this->getService('com://site/ohanah.model.events')->id(KRequest::get('get.id', 'int'))->getItem();
				$venue = $this->getService('com://admin/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem();

				$this->assign('venue', $venue);
				$this->assign('params', $this->params);
			
				return parent::display();		
			} 
		}
	}
}
