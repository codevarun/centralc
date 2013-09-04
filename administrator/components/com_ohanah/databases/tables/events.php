<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahDatabaseTableEvents extends KDatabaseTableAbstract
{
	public function _initialize(KConfig $config)
    {
    	$sluggable = $this->getBehavior('sluggable', array('columns' => array('name')));

        $config->append(array('behaviors'  => array('creatable', 'modifiable', $sluggable)));

        parent::_initialize($config);
    }
}