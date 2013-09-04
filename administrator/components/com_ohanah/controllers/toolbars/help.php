<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarHelp extends ComOhanahControllerToolbarDefault
{
    public function getCommands()
    {    
		$this->reset()
			->addCancel()
    		->setTitle('HELP')
			->setIcon('ohanah');

        return parent::getCommands();
    }

    protected function _commandCancel(KControllerToolbarCommand $command)
    {
        $command->label = 'OHANAH_BUTTON_CLOSE';
        $command->append(array('attribs' => array('href' =>  JRoute::_('index.php?option=com_ohanah&view=events'))));
    }
}

