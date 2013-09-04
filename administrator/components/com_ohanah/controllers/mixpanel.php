<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerMixpanel extends ComDefaultControllerResource
{
    public function ohstats($event, $properties=array()) 
    {
		if (!JComponentHelper::getParams('com_ohanah')->get('localEnvironment', 0)) {
	        $params = array('event' => $event, 'properties' => $properties);
	        $params['properties']['token'] = '41aca88360ef6164533944b503484055';
		    $params['properties']['ip'] = $_SERVER['REMOTE_ADDR'];
		    $params['properties']['ohanah_version'] = '2.0.20';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, '//api.mixpanel.com/track/?data=' . base64_encode(json_encode($params)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
			curl_close ($ch);
		}
    }
}