<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

/**
 * @version		$Id: dashboard.php 1041 2011-05-22 17:40:00Z stian $
 * @package		Ninja
 * @copyright	Copyright (C) 2011 NinjaForge. All rights reserved.
 * @license 	GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link     	http://ninjaforge.com
 */

jimport('joomla.filesystem.file');

class ComOhanahControllerDashboard extends ComDefaultControllerResource 
{	
	protected function _initialize(KConfig $config) 
	{	
		$config->append(array(
			'request' => array('layout' => 'default'),
		));

		parent::_initialize($config);
	}
}