<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarDashboard extends ComOhanahControllerToolbarDefault
{
    public function getCommands()
    {
        $this->reset()
			 ->setTitle('OHANAH_DASHBOARD')
        	 ->addUpdates()
			 ->setIcon('ohanah');

        return parent::getCommands();
    }

    protected function _commandUpdates(KControllerToolbarCommand $command)
    {
        $command->label = 'OHANAH_CHECK_FOR_UPDATES';
        $command->append(array('attribs' => array('href' =>  '#')));
    }
}