<?php
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahViewRegistrationHtml extends ComOhanahViewHtml
{
	public function display() 
	{
		$params = JComponentHelper::getParams('com_ohanah');

		$event = $this->getService('com://site/ohanah.model.events')->id(KRequest::get('get.ohanah_event_id', 'int'))->getItem();
		
		$output = '';

		if ($event->who_can_register == '0' || ($event->who_can_register == '1' && !JFactory::getUser()->guest)) {
				
			JFactory::getDocument()->setTitle(JText::sprintf('OHANAH_REGISTRATION_TO_THE_EVENT', $event->title));
			JFactory::getDocument()->setDescription($event->description ? strip_tags($event->description) : $event->title);

			$output = parent::display();

			$this->getService('com://site/ohanah.template.filter.chrome', array(
				'title' => $event->title, 
				'class' => array($params->get('moduleclass_sfx')), 
				'styles' => array($params->get('module_chrome'))))
				->write($output);
		}

		return $output;
	}
}