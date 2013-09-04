<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahControllerVenue extends KControllerResource 
{	
	public function __construct(KConfig $config)
	{
		if (KRequest::get('get.view', 'string') == 'venue' && !KRequest::get('get.id', 'int')) {
			if (KRequest::get('get.title', 'string')) {
				$venues = KService::get('com://admin/ohanah.model.venues')->set('title', KRequest::get('get.title', 'string'))->getList();
				$venue = reset($venues->getData());
				$config->request->id = $venue['id'];
			}
		}

		parent::__construct($config);
	}	
}