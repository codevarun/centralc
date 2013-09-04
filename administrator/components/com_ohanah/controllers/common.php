<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

jimport('joomla.filesystem.file');

class ComOhanahControllerCommon extends ComDefaultControllerDefault
{
	public function setMessage(KCommandContext $context)
	{}

	protected function _processImages($target_type, $temp_id, $real_id)
	{
		$images = KService::get('com://admin/ohanah.model.attachments')->set('target_type', $target_type)->set('target_id', $temp_id)->getList();

		foreach ($images as $image) {
			$image->target_type = str_replace('temp_', '', $image->target_type);
			$image->target_id = $real_id;
			$image->save();
		}
	}	
	
	public function reverseGeocode($data)
	{ 
		$latlng = KRequest::get('post.latlng', 'string');
		if (!$latlng && KRequest::get('post.latitude', 'string') && KRequest::get('post.longitude', 'string')) $latlng = KRequest::get('post.latitude', 'string').','.KRequest::get('post.longitude', 'string');

		if ($latlng) 
		{
			$config =& JFactory::getConfig();
			$language = $config->getValue('config.language');
			
			$languagesSupportedByGoogleMaps = array('ar', 'bg', 'bn', 'ca', 'cs', 'da', 'de', 'el', 'en', 'en-AU', 'en-GB', 'es', 'eu', 'fa', 'fi', 'fi', 'fr', 'gl', 'gu', 'hi', 'hr', 'hu', 'id', 'it', 'iw', 'ja', 'kn', 'ko', 'lt', 'lv', 'ml', 'mr', 'nl', 'nn', 'no', 'or', 'pl', 'pt', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl', 'sr', 'sv', 'tl', 'ta', 'te', 'th', 'tr', 'uk', 'vi', 'zh-CN', 'zh-TW');
			
			if (!in_array($language, $languagesSupportedByGoogleMaps)) {
				$language = substr($language, 0, 2);
			}
			
			if (!in_array($language, $languagesSupportedByGoogleMaps)) {
				$language = 'en';
			}
			
			//Geocode city and country
			$param = 'latlng='.$latlng.'&sensor=false&language='.$language;
			
			//get the url
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json' . '?' . $param);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			curl_close($ch);
			
			$json = @json_decode($response,true);
			
			$results = ($json['results'][0]['address_components']);
			
			if ($results) foreach ($results as $result)
			{
				if ($result['types'][0] == 'locality')
				{
					$data['geolocated_city'] = $result['long_name'];
				}
				if ($result['types'][0] == 'country')
				{
					$data['geolocated_country'] = $result['long_name'];
				}
				if ($result['types'][0] == 'administrative_area_level_1') 
				{ 
					$data['geolocated_state'] = $result['long_name'];
				}
			}
		}

		return $data;
	}
	
	protected function _processVenue($data)
	{
		$data['venue'] = trim($data['venue']);
		if ($data['venue'])
		{	
			if (!$this->getService('com://admin/ohanah.model.venues')->set('title', $data['venue'])->getTotal()) {

				$this->getService('com://admin/ohanah.model.venues')
					->getItem()
					->set('title', $data['venue'])
					->set('address', $data['address'])
					->set('latitude', $data['latitude'])
					->set('longitude', $data['longitude'])
					->set('timezone', $data['timezone'])
					->set('geolocated_city', $data['geolocated_city'])
					->set('geolocated_country', $data['geolocated_country'])
					->save();
			}

			$venue = reset($this->getService('com://admin/ohanah.model.venues')->set('title', $data['venue'])->getList()->getData());
			$data['ohanah_venue_id'] = $venue['id'];
		}

		return $data;
	}
	
	protected function _actionDeleteheader(KCommandContext $context) 
	{
		$data = $context->data;
		$data['header'] = '0';
		$context->data = $data;
		$row = parent::_actionEdit($context);
	}

	protected function _processTime($data) {
		// start time processing
		$sh = $data['start_time_h'];
		$sampm = $data['start_time_ampm'];
		if (isset($sampm)) {
			if ($sampm == "AM") { // if it's AM, then only conversion is that 12:30 AM is 00:30 in 24h format
				if ($sh == "12") {
					$sh = "00";
				}
			} else { // it's PM
				if (intval($sh) < 12) { // if it's 12, we leave 12, but if anything else, we add 12 so we get 13, 14... 
					$sh = strval(intval($sh) + 12);
				}
			}
		}
		$data['start_time'] = strval($sh).":".$data['start_time_m'];

		// end time processing
		$eh = $data['end_time_h'];
		$eampm = $data['end_time_ampm'];
		if (isset($eampm)) {
			if ($eampm == "AM") { // if it's AM, then only conversion is that 12:30 AM is 00:30 in 24h format
				if ($eh == "12") {
					$eh = "00";
				}
			} else { // it's PM
				if (intval($eh) < 12) { // if it's 12, we leave 12, but if anything else, we add 12 so we get 13, 14... 
					$eh = strval(intval($eh) + 12);
				}
			}
		}
		$data['end_time'] = strval($eh).":".$data['end_time_m'];
		


		return $data;


	}
}