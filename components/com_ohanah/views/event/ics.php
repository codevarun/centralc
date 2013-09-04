<?php
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ComOhanahViewEventIcs extends KViewFile
{
	public function display()
	{
		$event = $this->getModel()->getItem();

  		header('Content-Description: File Transfer');
  		header('Content-Disposition: attachment; filename="'.$event->title.'.ics"');
  		header('Content-Transfer-Encoding: binary');
 		header('Content-type: text/calendar');
 		
  		$date = new KDate();
  		$crlf = "\r\n";

		$eventStartDate = new KDate(new KConfig(array('date' => $event->date.'T'.$event->start_time)));
		$eventEndDate = new KDate(new KConfig(array('date' => $event->end_date.'T'.$event->end_time)));

		$eventStartDate->addHours(-$event->timezone); 
		$eventEndDate->addHours(-$event->timezone);

		if (JFactory::getApplication()->getPageParameters('com_ohanah')->get('dst') == '1') {
			$eventStartDate->addHours(-1); 
			$eventEndDate->addHours(-1); 
		}

		// url link to article
		$params = JComponentHelper::getParams('com_ohanah');
		if ($params->get('itemid')) $itemid = '&Itemid='.$params->get('itemid'); else $itemid = '';

		$link = 'http://'.$_SERVER['HTTP_HOST'].$this->createRoute('format=html&view=event&id='.$event->id.$itemid);

		$desc = str_replace("\r\n",'\\n',$event->description);
		$desc = str_replace("\n",'\\n',$desc);
		$desc = str_replace("</li>",'</li>\\n',$desc);
		$desc = strip_tags($desc);

		$geo = '';
		ob_start();
		$venue = $this->getService('com://admin/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem();
		if ($venue['latitude'] && $venue['longitude']) {
			$geo = $venue['latitude'].';'.$venue['longitude'];
		}
		ob_end_clean();

		$event_ical = $crlf.'BEGIN:VEVENT'.
			$crlf.'DTSTAMP:'.$date->getDate(DATE_FORMAT_ISO_BASIC).'Z'.
			$crlf.'DTSTART:'.$eventStartDate->getDate('%Y%m%dT').str_replace(':', '', $eventStartDate->getDate('%H:%M:%S')).'Z'.
			$crlf.'DTEND:'.$eventEndDate->getDate('%Y%m%dT').str_replace(':', '', $eventEndDate->getDate('%H:%M:%S')).'Z'.
			$crlf.'TRANSP:TRANSPARENT'.
			$crlf.'UID:'.$event->id.$event->date.
			$crlf.'SUMMARY:'.$event->title.
			$crlf.'DESCRIPTION:'.$desc.
			$crlf.'URL:'.$link.
			$crlf.'CATEGORIES:'.$this->getService('com://site/ohanah.model.categories')->id($event->ohanah_category_id)->getItem()->title.
			$crlf.'GEO:'.$geo.
			$crlf.'LOCATION:'.$this->getService('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title.
			$crlf.'END:VEVENT';


		$ical = 'BEGIN:VCALENDAR'.
			$crlf.'PRODID:-//Feedo Feed//NONSGML v1.0//EN'.
			$crlf.'VERSION:2.0'.
			$crlf.'CALSCALE:GREGORIAN'.
			$crlf.'METHOD:PUBLISH'.
			$crlf.'X-WR-CALNAME:'.$event->title.
			$crlf.'X-WR-CALDESC:'.$desc.
			$crlf.'X-MS-OLK-FORCEINSPECTOROPEN:TRUE'.
			$event_ical.
			$crlf.'END:VCALENDAR';

		echo $ical;
		exit();
	}	
}