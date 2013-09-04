<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarVenues extends ComOhanahControllerToolbarDefault
{
    public function getCommands()
    {
        $this->addSeparator()
        	->addPublish()
        	->addUnpublish()
			->setTitle('OHANAH_EVENT_VENUES', 'dashboard')
			->setIcon('ohanah');	

        return parent::getCommands();
    }
}