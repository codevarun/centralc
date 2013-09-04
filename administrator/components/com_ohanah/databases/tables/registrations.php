<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahDatabaseTableRegistrations extends KDatabaseTableAbstract
{
	public function _initialize(KConfig $config)
    {
        $config->append(array('behaviors'  => array('creatable')));

        parent::_initialize($config);
    }
}