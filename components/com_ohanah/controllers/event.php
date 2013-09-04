<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

KLoader::loadIdentifier('com://admin/ohanah.controller.common');

class ComOhanahControllerEvent extends ComOhanahControllerCommon
{
	public function __construct(KConfig $config)
	{
		$pageParameters = JFactory::getApplication()->getPageParameters();
		
		if (!KRequest::get('get.id', 'int')) { //I'm not seeing a single event, so I can safely add to the state this variable

			if ($eventsTiming = KRequest::get('get.filterEvents', 'string')) {
				$config->request->append(array('filterEvents' => $eventsTiming));
			} else {
				if ($eventsTiming = $pageParameters->get('list_type')) {			
					$config->request->append(array('filterEvents' => $eventsTiming));
				}
			}
			
			$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
						
			if ($ohanah_category_id = KRequest::get('get.ohanah_category_id', 'int')) {
				$config->request->append(array('ohanah_category_id' => $ohanah_category_id));
			} else {
				if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyACategory')) {
					if ($ohanah_category_id = $pageParameters->get('ohanah_category_id')) {
						$config->request->append(array('ohanah_category_id' => $ohanah_category_id));
					}
				}
			}
			
			if ($ohanah_venue_id = KRequest::get('get.ohanah_venue_id', 'int')) {
				$config->request->append(array('ohanah_venue_id' => $ohanah_venue_id));
			} else {
				if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyAVenue')) {
					if ($ohanah_venue_id = $pageParameters->get('ohanah_venue_id')) {
						$config->request->append(array('ohanah_venue_id' => $ohanah_venue_id));
					}
				}
			}
			
			if ($geolocated_country = KRequest::get('get.geolocated_country', 'string')) {
				$config->request->append(array('geolocated_country' => $geolocated_country));
			} else {
				if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyACountry')) {
					if ($geolocated_country = $pageParameters->get('geolocated_country')) {
						$config->request->append(array('geolocated_country' => $geolocated_country));
					}
				}
			}
			if ($geolocated_state = KRequest::get('get.geolocated_state', 'string')) {
				$config->request->append(array('geolocated_state' => $geolocated_state));
			} else {
				if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyAState')) {
					if ($geolocated_state = $pageParameters->get('geolocated_state')) {
						$config->request->append(array('geolocated_state' => $geolocated_state));
					}
				}
			}
			if ($geolocated_city = KRequest::get('get.geolocated_city', 'string')) {
				$config->request->append(array('geolocated_city' => $geolocated_city));
			} else {
				if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyACity')) {
					if ($geolocated_city = $pageParameters->get('geolocated_city')) {
						$config->request->append(array('geolocated_city' => $geolocated_city));
					}
				}
			}
			if ($recurringParent = KRequest::get('get.recurringParent', 'string')) {
				$config->request->append(array('recurringParent' => $recurringParent));
			} else {
				if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyARecurringSerie')) {
					if ($recurringParent = $pageParameters->get('recurringParent')) {
						$config->request->append(array('recurringParent' => $recurringParent));
					}
				}
			}
		}

		$config->request->append(array(
		    'sort' => array('date', 'start_time'),
		));

		if (KRequest::get('get.layout', 'string') != 'yours' && KRequest::get('get.layout', 'string') != 'form') {
			$config->request->append(array(
			    'enabled' => 1
			));
		}

		if (!JFactory::getApplication()->getPageParameters()->get('usePagination', 1)) {
			$config->request->append(array(
			    'limit' => 10000000
			));
		}

		if (JFactory::getApplication()->getPageParameters()->get('usePagination')) {
			$config->request->append(array('limit' => $pageParameters->get('eventsPerPage')));			
		}

		$config->request->append(array('direction' => $pageParameters->get('direction')));			
		
		parent::__construct($config);

		if (JComponentHelper::getParams('com_ohanah')->get('enable_frontend')) {
			$this->registerCallback('after.add', array($this, 'sendNotifications'));	
		}

		$this->registerCallback('before.add', array($this, 'fixEmptySlugs'));
	}

	public function fixEmptySlugs() {
		$db = JFactory::getDBO();
		$db->setQuery('SELECT * FROM '.$db->getPrefix().'ohanah_events WHERE slug = ""');
		foreach ($db->loadObjectList() as $event) {
			$slug = $this->_createSlug($event->title);
			$db->setQuery('UPDATE '.$db->getPrefix().'ohanah_events SET slug = "'.$slug.'" WHERE ohanah_event_id = '.$event->ohanah_event_id);
			$db->query();
		}
	}

   	protected function _createSlug($title)
    {
        $slug = $this->getService('com://admin/ohanah.filter.slug')->sanitize($title);
        return $this->_canonicalizeSlug($slug);
    }
    
    protected function _canonicalizeSlug($slug)
    {
        $table = $this->getModel()->getTable();        

        $db    = $table->getDatabase();
        $query = $db->getQuery()
                    ->select('slug')
                    ->where('slug', 'LIKE', $slug.'-%');
        
        $slugs = $table->select($query, KDatabase::FETCH_FIELD_LIST);
        
        $i = 1;
        while(in_array($slug.'-'.$i, $slugs)) {
            $i++;
        }
        
        $slug = $slug.'-'.$i;

        return $slug;
    }

	public function sendNotifications($params) {

		if (JComponentHelper::getParams('com_ohanah')->get('enableEmailNewEventFrontend')) 
		{
			$subject = JComponentHelper::getParams('com_ohanah')->get('subject_mail_new_event');
			$message = JComponentHelper::getParams('com_ohanah')->get('text_mail_new_event');

			$date = new KDate(new KConfig(array('date' => KRequest::get('post.date', 'string'))));
			$date = $date->day." ".JText::_($date->getDate("%B"))." ".$date->year;


			$subject = str_replace('{NAME}', KRequest::get('post.created_by_name', 'string'), $subject);
			$subject = str_replace('{EMAIL}', KRequest::get('post.created_by_email', 'string'), $subject);
			$subject = str_replace('{EVENT_TITLE}', KRequest::get('post.title', 'string'), $subject);
			$subject = str_replace('{START_DATE}', $date, $subject);
			$subject = str_replace('{EVENT_LINK}', '', $subject);

			$message = str_replace('{NAME}', KRequest::get('post.created_by_name', 'string'), $message);
			$message = str_replace('{EMAIL}', KRequest::get('post.created_by_email', 'string'), $message);
			$message = str_replace('{EVENT_TITLE}', KRequest::get('post.title', 'string'), $message);
			$message = str_replace('{START_DATE}', $date, $message);

			if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '';
			$message = str_replace('{EVENT_LINK}', 'http://'.$_SERVER['HTTP_HOST'].JRoute::_('index.php?option=com_ohanah&view=event&id='.$this->getModel()->getItem()->id.$itemid), $message);

			$emailAddress = JFactory::getConfig()->getValue('mailfrom');
			if (JComponentHelper::getParams('com_ohanah')->get('destination_email')) {
				$emailAddress = JComponentHelper::getParams('com_ohanah')->get('destination_email');
			}		

			// check to see if there is more then one email and send to all of them
			if (strpos($emailAddress, ";") === FALSE) {
				JUtility::sendMail(JFactory::getConfig()->getValue('mailfrom'), JFactory::getConfig()->getValue('fromname'), $emailAddress, $subject, $message, true);
			} else {
				$mailArray = explode(";", $emailAddress);
				foreach($mailArray as $index => $email) {
					JUtility::sendMail(JFactory::getConfig()->getValue('mailfrom'), JFactory::getConfig()->getValue('fromname'), $email, $subject, $message, true);
				}	
			}
		}
	}

	private function _processData($data) 
	{
		$data = $this->reverseGeocode($data);
		$data = $this->_processVenue($data);
		$data = $this->_processTime($data);
		
		if ($data['end_time_enabled'] != null) $data['end_time_enabled'] = 1; else $data['end_time_enabled'] = 0;

		if ($data['title'] && !$data['ohanah_category_id']) {
			//check that title is there, if not I'm disabling/enabling the event, not editing it
			$data['ohanah_category_id'] = 1;
		}
		
		$data['frontend_submitted'] = 1;

		if (JComponentHelper::getParams('com_ohanah')->get('frontend_editing') == 0 && JComponentHelper::getParams('com_ohanah')->get('moderation')) {
			$data['enabled'] = 0;
		}

		return $data;
	}

	protected function _actionAdd(KCommandContext $context) 
	{
		error_log('add');
		$data = $context->data;
		$context->data = $this->_processData($data);

		$row = parent::_actionAdd($context);

		$this->_processImages('temp_event', $data->random_id, $row->id);
		$this->getService('com://admin/ohanah.controller.mixpanel')->ohstats('event_added', array());
		$this->_message = JText::_('OHANAH_EVENT_ADDED');

		return $row;
	}

	protected function _actionEdit(KCommandContext $context)
	{
		if (KRequest::get('get.view', 'string') == 'event') {
			$data = $context->data; 
			$context->data = $this->_processData($data);			
		}
		$event = $this->getService('com://site/ohanah.model.events')->id($context->data['id'])->getItem();
        $event->setData(KConfig::unbox($context->data));
        $event->save();
	} 


	public function getRedirect()
	{
		
		$result = array();

		if(!empty($this->_redirect))
		{
			$url = $this->_redirect;

			//Create the url if no full URL was passed
			if(strrpos($url, '?') === false) 
			{
				$url = 'index.php?option=com_'.$this->getIdentifier()->package.'&'.$url;
			}

			$result = array(
				'url' 			=> JRoute::_($url, false),
				'message' 		=> $this->_message,
				'messageType' 	=> $this->_messageType,
			);
		}

		return $result;
	}
}