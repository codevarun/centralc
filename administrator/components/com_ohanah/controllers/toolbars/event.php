<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarEvent extends ComOhanahControllerToolbarDefault
{
    public function getCommands()
    {        
	    $this->reset()
        	->addSave()
        	->addApply()
            ->addSeparator()
            ->addCancel()
            ->setIcon('ohanah');

		if (KRequest::get('get.id', 'int'))
		{
			$event = $this->getService('com://site/ohanah.model.event')->set('id', KRequest::get('get.id', 'int'))->getItem();
			if ($event->enabled) {
				$this->setTitle(JText::sprintf('OHANAH_EDIT_EVENT', $event->title), 'dashboard');
			} else {
				$this->setTitle(JText::sprintf('OHANAH_EDIT_DRAFT_EVENT', $event->title), 'dashboard');	
			}
		}
		else
		{
			$this->setTitle('OHANAH_ADD_NEW_EVENT', 'dashboard');
		}	
	        
        return parent::getCommands();
    }

    protected function _commandCancel(KControllerToolbarCommand $command)
    {
        $command->label = 'OHANAH_BUTTON_CLOSE';
        $command->append(array('attribs' => array('href' =>  JRoute::_('index.php?option=com_ohanah&view=events'))));
    }
}