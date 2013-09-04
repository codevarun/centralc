<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

jimport('joomla.filesystem.file');

class ComOhanahControllerVenue extends ComOhanahControllerCommon 
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

	private function _ifDisablingDisableAllEventsInThisVenue($id, $data) 
	{
		if ($data['enabled'] == "0") {
			$events = $this->getService('com://admin/ohanah.model.events')
								->set('ohanah_venue_id', $id)
								->set('enabled', 1)
								->getList();

			foreach ($events as $event) {
				$event->enabled = 0;
				$event->save();
			}
		}
	}
	
	protected function _actionEdit(KCommandContext $context) 
	{ 	
		if (KRequest::get('get.view', 'string') == 'venue') {
			$context->data = $this->reverseGeocode($context->data);
		}

		$row = parent::_actionEdit($context);
		$this->_ifDisablingDisableAllEventsInThisVenue($row->id, $context->data);

		$data = reset($row->getData());

		if (is_numeric($data))
			KRequest::set('get.id', $data);
		else 
			KRequest::set('get.id', $data['id']);

		$this->_message = JText::_('OHANAH_SAVED_CHANGES');
		return $row;
	}
	
	public function unlockRow(KCommandContext $context) {}
		
	protected function _actionAdd(KCommandContext $context) 
	{
		$data = $context->data;
		$data = $this->reverseGeocode($data);
		
		if (!$data['ohanah_category_id']) {
			$data['ohanah_category_id'] = 1;
		}

		$context->data = $data;
		$this->_message = JText::_('OHANAH_SAVED_CHANGES');
		$row = parent::_actionAdd($context);

		$this->_processImages('temp_venue', $data->random_id, $row->id);
	}

	protected function _actionDelete(KCommandContext $context) 
	{
		$canDelete = true; 
		$numberOfVenuesToDelete = count(KRequest::get('get.id', 'int'));

		foreach (KRequest::get('get.id', 'int') as $venue_id) {
			$number_of_events = $this->getService('com://admin/ohanah.model.events')->ohanah_venue_id($venue_id)->getTotal();
			if ($number_of_events) {
				$canDelete = false; 
				break;
			}
		}		

		if (!$canDelete) {
			if ($numberOfVenuesToDelete == 1) {
				$this->_message = JText::_('OHANAH_CANT_DELETE_VENUE');
			} else {
				$this->_message = JText::_('OHANAH_CANT_DELETE_VENUES');
			}
		} else {
			parent::_actionDelete($context);
			if ($numberOfVenuesToDelete == 1) {
				$this->_message = JText::_('OHANAH_VENUE_DELETED');
			} else {
				$this->_message = JText::_('OHANAH_VENUES_DELETED');
			}
		}
	}


	public function getRedirect()
	{
		$action = KRequest::get('post.action', 'string');
		
		if ($action == "cancel" || $action == "save") 
		{
			$url = 'index.php?option=com_ohanah&view=venues';
			
			return $result = array(
				'url' 			=> JRoute::_($url, false),
				'message' 		=> $this->_message,
				'messageType' 	=> $this->_messageType
			);
		} 
		else 
		{			
			$result = array();
			
			if(!empty($this->_redirect))
			{
				$url = $this->_redirect;
			
				//Create the url if no full URL was passed
				if(strrpos($url, '?') === false) 
				{
					$url = 'index.php?option=com_'.$this->getIdentifier()->package.'&'.$url;
				}
			
				$result = array(
					'url' 			=> JRoute::_($url, false),
					'message' 		=> $this->_message,
					'messageType' 	=> $this->_messageType
				);
			}
			
			return $result;
		}
	}
}