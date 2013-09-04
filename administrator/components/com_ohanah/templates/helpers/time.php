<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @version		2.0.12
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

jimport('joomla.filesystem.file');

class ComOhanahTemplateHelperTime extends KTemplateHelperAbstract
{

	/* Function to extract hour from HH:MM format. 
		 $time is in 24hours format
		 Return format is determined from settings
	*/

	public function getHour($config = array()) {

		$config = new KConfig($config);

		$time = $config->time;

		// get hour from string 
		$h = substr($time, 0, 2);

		// if it's 12h format, we must process this
		if (JComponentHelper::getParams('com_ohanah')->get('timeFormat') == '1') {
			if ($h == "00") $h = "12";
			
			if (intval($h) > 12) {
				$h = intval($h) - 12;
			
				if ($h < 10) {
					$h = "0".$h;
				} else {
					$h = strval($h);
				}
			}
		}
		return $h;
	}

}