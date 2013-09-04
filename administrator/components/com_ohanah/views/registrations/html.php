<?php
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined('_JEXEC') or die('Restricted access');

class ComOhanahViewRegistrationsHtml extends ComOhanahViewHtml
{
	public function display()
	{
		$event = $this->getService('com://admin/ohanah.model.event')->set('id', KRequest::get('get.ohanah_event_id', 'int'))->getItem();

		if ($event->id)
		{
			return parent::display();
		}
		else
		{
			$message = JText::_('THE_EVENT_YOU_ARE_SEARCHING_DOES_NOT_EXIST');
			JError::raiseWarning(0, $message);
		}
	}
}