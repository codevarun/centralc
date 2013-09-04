<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerCategory extends ComOhanahControllerCommon 
{
	protected function _actionEdit(KCommandContext $context) 
	{ 			
		$data = $context->data;
		$row = parent::_actionEdit($context);
		$this->_processImages('temp_category', $data->random_id, $row->id);

		if ($context->data['enabled'] == "0") {
			$events = $this->getService('com://admin/ohanah.model.events')
								->set('ohanah_category_id', $row->id)
								->set('enabled', 1)
								->getList();

			foreach ($events as $event) {
				$event->enabled = 0;
				$event->save();
			}
		}
		
		$this->_message = JText::_('OHANAH_CATEGORY_SETTINGS_SAVED');

		return $row;
	}
	

	protected function _actionAdd(KCommandContext $context) 
	{
		$data = $context->data;

		$context->data = $data;
		$this->_message = JText::_('OHANAH_CATEGORY_SAVED');
		$row = parent::_actionAdd($context);

		$this->_processImages('temp_category', $data->random_id, $row->id);
	}
	
	protected function _actionDelete(KCommandContext $context) 
	{
		$canDelete = true; 
		$numberOfCategoriesToDelete = count(KRequest::get('get.id', 'int'));

		foreach (KRequest::get('get.id', 'int') as $category_id) {
			$number_of_events = $this->getService('com://admin/ohanah.model.events')->ohanah_category_id($category_id)->getTotal();
			if ($number_of_events) {
				$canDelete = false; 
				break;
			}
		}		

		if (!$canDelete) {
			if ($numberOfCategoriesToDelete == 1) {
				$this->_message = JText::_('OHANAH_CANT_DELETE_CATEGORY');
			} else {
				$this->_message = JText::_('OHANAH_CANT_DELETE_CATEGORIES');
			}
		} else {
			parent::_actionDelete($context);
			if ($numberOfCategoriesToDelete == 1) {
				$this->_message = JText::_('OHANAH_CATEGORY_DELETED');
			} else {
				$this->_message = JText::_('OHANAH_CATEGORIES_DELETED');
			}
		}
	}

	public function getRedirect()
	{
		$action = KRequest::get('post.action', 'string');
		if ($action == "cancel" || $action == "save") 
		{
			$url = 'index.php?option=com_ohanah&view=categories';
			
			return $result = array(
				'url' 			=> JRoute::_($url, false),
				'message' 		=> $this->_message,
				'messageType' 	=> $this->_messageType,
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
					'messageType' 	=> $this->_messageType,
				);
			}
			
			return $result;
		}
	}
	
}