<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahDatabaseRowRegistration extends KDatabaseRowDefault
{ 
	public function getGravatar() {
		return '<img alt="Avatar" class="gravatar" src="//www.gravatar.com/avatar.php?gravatar_id='.md5(strtolower($this->email)).'&d='.'http://' . $_SERVER['HTTP_HOST'] . str_replace('/administrator', '', KRequest::base()) . '/media/com_ohanah/v2/ohanah_images/no-gravatar.png">';
	}
}