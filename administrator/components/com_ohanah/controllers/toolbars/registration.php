<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarRegistration extends ComOhanahControllerToolbarDefault
{
    public function getCommands()
    {    
		if (KRequest::get('get.id', 'int'))
		{
			$this->reset()
				->addSave()				
				->addApply()				
				->addSeparator()
				->addCancel()
				->setIcon('ohanah')
	    		->setTitle(JText::sprintf('OHANAH_REGISTRATION_TO_THE_EVENT', $this->getService('com://admin/ohanah.model.event')->set('id', ($this->getService('com://admin/ohanah.model.registrations')->id(KRequest::get('get.id', 'int'))->getItem()->ohanah_event_id))->getItem()->title), 'dashboard');
		}
		else
		{
			$this->reset()
				->addSave()
				->addSeparator()
				->addCancel()
				->setIcon('ohanah')
	    		->setTitle(JText::sprintf('OHANAH_NEW_REGISTRATION_TO_THE_EVENT', $this->getService('com://admin/ohanah.model.event')->set('id', KRequest::get('get.ohanah_event_id', 'int'))->getItem()->title), 'dashboard');
		} 
	        
        return parent::getCommands();
    }

    protected function _commandCancel(KControllerToolbarCommand $command)
    {
		if (KRequest::get('get.id', 'int'))
		{
			$event_id = $this->getService('com://admin/ohanah.model.registrations')->id(KRequest::get('get.id', 'int'))->getItem()->ohanah_event_id;
		} else {
			$event_id = KRequest::get('get.ohanah_event_id', 'int');
		}
		
        $command->label = 'OHANAH_BUTTON_CLOSE';	
        $command->append(array('attribs' => array('href' =>  JRoute::_('index.php?option=com_ohanah&view=registrations&ohanah_event_id='.$event_id))));
    }
}