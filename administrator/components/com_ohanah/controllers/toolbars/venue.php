<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarVenue extends ComOhanahControllerToolbarDefault
{
    public function getCommands()
    {
        $this->reset()
        	 ->addSave()
        	 ->addApply()
             ->addSeparator()
             ->addCancel();

		$this->setIcon('ohanah');

		if (KRequest::get('get.id', 'int'))
		{
			$venue = $this->getService('com://admin/ohanah.model.venues')->set('id', KRequest::get('get.id', 'int'))->getItem();
			$this->setTitle(JText::sprintf('OHANAH_EDIT_VENUE', $venue->title), 'dashboard');
		}
		else
		{
			$this->setTitle('OHANAH_ADD_NEW_VENUE','dashboard');
		}	

        return parent::getCommands();
    }

    protected function _commandCancel(KControllerToolbarCommand $command)
    {
        $command->label = 'OHANAH_BUTTON_CLOSE';
        $command->append(array('attribs' => array('href' =>  JRoute::_('index.php?option=com_ohanah&view=venues'))));
    }
}