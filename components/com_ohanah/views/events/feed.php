<?php
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahViewEventsFeed extends KViewAbstract
{
	public function display()
	{	
		//Set the document link
		$this->_document->link = $this->createRoute('format=html&view=events');

		//Get the list of events
		$events = KService::get($this->getModel())->set('sort', 'created_on')->set('direction', 'DESC')->set('enabled', 1)->getList();

		foreach ( $events as $event )
		{
			// strip html from feed item title
			$title = html_entity_decode( $event->title );

			// url link to article
			$params = JComponentHelper::getParams('com_ohanah');
			if ($params->get('itemid')) $itemid = '&Itemid='.$params->get('itemid'); else $itemid = '';

			$link = $this->createRoute('format=html&view=event&id='.$event->id.$itemid);

			// generate the description as a hcard
			$description = strftime('%d', strtotime($event->date)).' '.JText::_(substr(strftime('%B', strtotime($event->date)),0,3)).' '.strftime('%Y', strtotime($event->date));
			
			if ($event->end_time_enabled && ($event->date != $event->end_date)) {
				$description .= ' - '.strftime('%d', strtotime($event->end_date)).' '.JText::_(substr(strftime('%B', strtotime($event->end_date)),0,3)).' '.strftime('%Y', strtotime($event->end_date));
			}
				

			$description .= '<br /><br />'.$event->description;

			// load individual item creator class
			$item = new JFeedItem();
			$item->title 		= $title;
			$item->link 		= $link;
			$item->description 	= $description;
			$item->date			= date( 'r', strtotime($event->created_on) );
			$item->category   	= '';

			// loads item info into rss array
			$doc =& JFactory::getDocument();
			$doc->addItem($item);
		}
	}
}