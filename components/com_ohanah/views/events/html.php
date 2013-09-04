<?php
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahViewEventsHtml extends ComOhanahViewHtml
{
	public function display() 
	{
		if (KRequest::get('get.layout', 'string') == 'yours' && JFactory::getUser()->guest) {
			$output = 'Private area. You need to login';
		} else {
			$params = JComponentHelper::getParams('com_ohanah');
			$pageParameters = JFactory::getApplication()->getPageParameters();

			$this->assign('params', $params);
			$this->assign('pageParameters', $pageParameters);
			$output = parent::display();

			$title = $this->_generateTitle();

			// if user is set browser page title, we should respect that, otherwise, use generated title
			if ($pageParameters->get('page_title')) {
				JFactory::getDocument()->setTitle($pageParameters->get('page_title'));
			} else {
				JFactory::getDocument()->setTitle($title);
			}
			
			JFactory::getDocument()->setDescription($title);

			$this->getService('com://site/ohanah.template.filter.chrome', array(
				'title' => $title, 
				'class' => array($params->get('moduleclass_sfx')), 
				'styles' => array($params->get('module_chrome'))))
				->write($output);
		}
		
		return $output;
	}

	protected function _generateTitle() {

		if (KRequest::get('get.layout', 'string') == 'yours') {
			$return = 'Your events';
		} else {

			$params = JComponentHelper::getParams('com_ohanah');
			$pageParameters = JFactory::getApplication()->getPageParameters();

			$return = '';

			// if user set's it's own page heading, we should respect that
			if ($pageParameters->get('show_page_heading') && $pageParameters->get('page_heading')) {
				return $pageParameters->get('page_heading');
			}

			if (KRequest::get('get.calendar_start_date', 'string') && KRequest::get('get.calendar_end_date', 'string')) {
				$return = JText::_('OHANAH_EVENTS_ON_DAY').' '.KRequest::get('get.calendar_start_date', 'string');
				return $return;
			}

			$eventsTiming = null;

			if (KRequest::get('get.filterEvents', 'string')) {
				$eventsTiming = KRequest::get('get.filterEvents', 'string');
			} else {
				if ($pageParameters->get('list_type')) {
					$eventsTiming = $pageParameters->get('list_type');
				}
			}

			if (!$eventsTiming) $eventsTiming = 'notpast';
			
			if ($eventsTiming) {
				if ($eventsTiming == 'all') $return .= JText::_('OHANAH_ALL_EVENTS');
				if ($eventsTiming == 'past') $return .= JText::_('OHANAH_PAST_EVENTS');
				if ($eventsTiming == 'notpast') $return .= JText::_('OHANAH_UPCOMING_EVENTS');
			}
			
			$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
					
			if ($this->getModel()->ohanah_category_id) {
				$category_title = $this->getService('com://site/ohanah.model.categories')->id($this->getModel()->ohanah_category_id)->getItem()->title;
				if ($category_title)
					$return .= ', '.JText::_('OHANAH_CATEGORY').' '.$category_title;
			} 
			
			if ($this->getModel()->ohanah_venue_id) {
				$venue_title = $this->getService('com://site/ohanah.model.venues')->id($this->getModel()->ohanah_venue_id)->getItem()->title;
				if ($venue_title)
					$return .= ', @ '.$venue_title;
			} 
			
			if ($this->getModel()->recurringParent) {
				$serie_title = $this->getService('com://site/ohanah.model.events')->id($this->getModel()->recurringParent)->getItem()->title;
				if ($serie_title)
					$return .= ', serie '.$serie_title;
			} 
		
			if ($geolocated_city = $this->getModel()->geolocated_city) {
				$return .= ', '.JText::_('OHANAH_IN').' '.$geolocated_city;
			} elseif ($geolocated_state = $this->getModel()->geolocated_state) {
				$return .= ', '.JText::_('OHANAH_IN').' '.$geolocated_state;
			} elseif ($geolocated_country = $this->getModel()->geolocated_country) {
				$return .= ', '.JText::_('OHANAH_IN').' '.$geolocated_country;
			} 
			
		}

		return $return;
	}
}