<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahDatabaseRowEvent extends KDatabaseRowDefault
{ 
	public function isRecurring()
	{
		if ($this->id) {	
			if ($this->recurringParent) return (bool) ($this->getService('com://site/ohanah.model.events')->set('id', $this->recurringParent)->getTotal());
			else return (bool) ($this->getService('com://site/ohanah.model.events')->set('recurringParent', $this->id)->getTotal());	
		} else return false;
	}
	
	public function isPast()
	{
		$return = false; 
		$startDateEvent = new KDate(new KConfig(array('date' => $this->date)));
		$endDateEvent = new KDate(new KConfig(array('date' => $this->end_date)));
		$dateNow = new KDate();
			
		if ($this->end_date == '0000-00-00') {
			if ($startDateEvent->toDays() < $dateNow->toDays())
			{
				$return = true;
			}
		}
		else {
			if ($endDateEvent->toDays() < $dateNow->toDays()) {
				$return = true;	
			}
		}

		return $return;
	}
	
	public function getCreator()
	{
		return JFactory::getUser($this->created_by);
	}
	
	public function countAttendees()
	{
		$total = 0;

		$registrations = $this->getService('com://admin/ohanah.model.registrations')->set('ohanah_event_id', $this->id)->limit(null)->getList();
		
		foreach ($registrations as $registration) {
			$total += $registration->number_of_tickets;
		}

		return $total;
	}
	
	public function getAttendees()
	{		
		return $this->getService('com://admin/ohanah.model.registrations')
			->set('ohanah_event_id', $this->id)
			->limit(null)
			->getList();
	}
}