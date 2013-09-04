<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );


class ComOhanahControllerRegistration extends ComDefaultControllerDefault
{
	public function __construct(KConfig $config)
	{
		parent::__construct($config);
		
		if (JComponentHelper::getParams('com_ohanah')->get('enableMailchimp')) {
			$this->registerCallback('after.add', array($this, 'addAttendeToMailchimpList'));
		}
	}
		
	public function addAttendeToMailchimpList() {
		$event = $this->getService('com://site/ohanah.model.events')->id(KRequest::get('post.ohanah_event_id', 'int'))->getItem();

		if ($event->mailchimp_list_id) {
			$registration = $this->getService('com://site/ohanah.model.registrations')->id(KRequest::get('post.ohanah_registration_id', 'int'))->getItem();
			$this->pushOnMailchimp($registration->email, $registration->name, $event->mailchimp_list_id);
		}
	}

	public function pushOnMailchimp($email, $name, $listId)
	{
		$apiKey = JComponentHelper::getParams('com_ohanah')->get('mailchimpApiKey');
		 
		$double_optin=false;
		$update_existing=true;
		$replace_interests=true;
		$send_welcome=false;
		$email_type = 'html';
		
		$merges = array('FNAME'=> $name);
	
		$data = array(
		        'email_address' 	=> $email,
		        'apikey' 			=> $apiKey,
		        'merge_vars' 		=> $merges,
		        'id' 				=> $listId,
		        'double_optin' 		=> $double_optin,
		        'update_existing' 	=> $update_existing,
		        'replace_interests' => $replace_interests,
		        'send_welcome' 		=> $send_welcome,
		        'email_type' 		=> $email_type
		    );
		    
		$payload = json_encode($data);
		 
		$submit_url = 'http://'.substr($apiKey, strlen($apiKey)-3, 3).'.api.mailchimp.com/1.3/?method=listSubscribe';
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $submit_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
		 
		$result = curl_exec($ch);
		curl_close ($ch);
		$data = json_decode($result);
				
		if (isset($data->error)){
		    //error_log($data->code .' : '.$data->error."\n");
		} else {
		    //error_log("success, look for the confirmation message\n");
		}
	}

	public function processParams() {
		$params = 'field_name_person_1='.KRequest::get('post.field_name_person_1', 'string').PHP_EOL;
		$params .= 'field_name_person_2='.KRequest::get('post.field_name_person_2', 'string').PHP_EOL;
		$params .= 'field_name_person_3='.KRequest::get('post.field_name_person_3', 'string').PHP_EOL;
		$params .= 'field_name_person_4='.KRequest::get('post.field_name_person_4', 'string').PHP_EOL;
		$params .= 'field_name_person_5='.KRequest::get('post.field_name_person_5', 'string').PHP_EOL;

		for ($j = 1; $j <= 10; $j++) {
			for ($i = 1; $i <= 5; $i++) {
				$params .= 'custom_field_value_'.$j.'_person_'.$i.'="'.KRequest::get('post.custom_field_value_'.$j.'_person_'.$i, 'string').'"'.PHP_EOL;			
			}
		}
		
		return $params;
	}
	

	protected function _actionAdd(KCommandContext $context)
	{	
		$context->data['params'] = $this->processParams();
		$data = $context->data;

		$created_on = gmdate('Y-m-d H:i:s');

		$database = JFactory::getDBO();
		$database->setQuery("INSERT INTO `#__ohanah_registrations` (`ohanah_event_id`, `name`, `email`, `number_of_tickets`, `text`, `notes`, `created_by`, `created_on`, `paid`, `checked_in`, `params`) VALUES ('".$data->ohanah_event_id."', '".$data->name."', '".$data->email."', '".$data->number_of_tickets."', '".$data->text."', '".$data->notes."', '".JFactory::getUser()->get('id')."', '".$created_on."', 0, 0, '".$data->params."');");
		$database->query();

		$database->setQuery("SELECT ohanah_registration_id FROM `#__ohanah_registrations` WHERE `created_on` = '".$created_on."'");
		$registration_id = $database->loadResult();
		KRequest::set('post.ohanah_registration_id', $registration_id);

		$event = $this->getService('com://site/ohanah.model.events')->id(KRequest::get('post.ohanah_event_id', 'int'))->getItem();

		//$this->getService('com://admin/ohanah.controller.mixpanel')->ohstats('new_registration', array('number_of_tickets'=> KRequest::get('post.number_of_tickets', 'string'), 'ticket_cost' => $event->ticket_cost.' '.JComponentHelper::getParams('com_ohanah')->get('payment_currency')));

		if (JComponentHelper::getParams('com_ohanah')->get('enableEmailNewRegistration')) 
		{
			//Notify the organizer / admin
			$subject = JComponentHelper::getParams('com_ohanah')->get('subject_mail_new_registration_organizer');
			$message = JComponentHelper::getParams('com_ohanah')->get('text_mail_new_registration_organizer');

			// get the event date in proper format
			$date = new KDate(new KConfig(array('date' => $event->date)));
			$date = $date->day." ".JText::_($date->getDate("%B"))." ".$date->year;

			// get custom fields and additional persons info 
			jimport('joomla.html.parameter');
			$active_custom_fields = new JParameter($event->customfields);
			$numPersons = (int) KRequest::get('post.number_of_tickets', 'string');
			$persons = Array();
			for ($p = 1; $p <= $numPersons; $p++) {
				if ($p==1) { // it's registrant
					$person = "<ul class='persons_info' style='list-style-type:none; border-top: 1px dotted gray;'><li><strong>".KRequest::get('post.name', 'string')."</strong></li>";
				} else {
					$person = "<ul class='persons_info' style='list-style-type:none;'><li><strong>".KRequest::get('post.field_name_person_'.$p, 'string')."</li></strong>";
				}
				for ($c = 1; $c <= 10; $c++) {
					if ($active_custom_fields->get('cf'.$c)) {
						$text = KRequest::get('post.custom_field_value_'.$c.'_person_'.$p, 'string');
						$person .= '<li><span style="color: gray;">'.$active_custom_fields->get('custom_field_label_'.$c)."</span>: ".KRequest::get('post.custom_field_value_'.$c.'_person_'.$p, 'string')."</li>";
					}			
				}
				$person .= "</ul>";
				$persons[] = $person;
			}

			$persons_info = "";
			foreach ($persons as $per) {
				$persons_info .= $per;
			}

			$subject = str_replace('{TITLE}', KRequest::get('post.title', 'string'), $subject);
			$subject = str_replace('{NAME}', KRequest::get('post.name', 'string'), $subject);
			$subject = str_replace('{EMAIL}', KRequest::get('post.email', 'string'), $subject);
			$subject = str_replace('{TICKETS}', KRequest::get('post.number_of_tickets', 'string'), $subject);
			$subject = str_replace('{NOTES}', KRequest::get('post.notes', 'string'), $subject);
			$subject = str_replace('{EVENT_TITLE}', $event->title, $subject);
			$subject = str_replace('{START_DATE}', $date, $subject);
			$subject = str_replace('{EVENT_LINK}', '', $subject);
			$subject = str_replace('{PERSONS_INFO}', '', $subject);

			$message = str_replace('{TITLE}', KRequest::get('post.title', 'string'), $message);
			$message = str_replace('{NAME}', KRequest::get('post.name', 'string'), $message);
			$message = str_replace('{EMAIL}', KRequest::get('post.email', 'string'), $message);
			$message = str_replace('{TICKETS}', KRequest::get('post.number_of_tickets', 'string'), $message);
			$message = str_replace('{NOTES}', KRequest::get('post.notes', 'string'), $message);
			$message = str_replace('{EVENT_TITLE}', $event->title, $message);
			$message = str_replace('{START_DATE}', $date, $message);
			$message = str_replace('{PERSONS_INFO}', $persons_info, $message);


			if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '';
			$message = str_replace('{EVENT_LINK}', 'http://'.$_SERVER['HTTP_HOST'].JRoute::_('index.php?option=com_ohanah&view=event&id='.$event->id.$itemid), $message);

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

		if (JComponentHelper::getParams('com_ohanah')->get('enableEmailRegistrationConfirmation')) {
			//Notify the user
			$subject = JComponentHelper::getParams('com_ohanah')->get('subject_mail_new_registration_registrant');
			$message = JComponentHelper::getParams('com_ohanah')->get('text_mail_new_registration_registrant');

			$subject = str_replace('{TITLE}', KRequest::get('post.title', 'string'), $subject);
			$subject = str_replace('{NAME}', KRequest::get('post.name', 'string'), $subject);
			$subject = str_replace('{EMAIL}', KRequest::get('post.email', 'string'), $subject);
			$subject = str_replace('{TICKETS}', KRequest::get('post.number_of_tickets', 'string'), $subject);
			$subject = str_replace('{NOTES}', KRequest::get('post.notes', 'string'), $subject);
			$subject = str_replace('{EVENT_TITLE}', $event->title, $subject);
			$subject = str_replace('{EVENT_LINK}', '', $subject);
			$subject = str_replace('{START_DATE}', $date, $subject);
			$subject = str_replace('{PERSONS_INFO}', '', $subject);

			$message = str_replace('{TITLE}', KRequest::get('post.title', 'string'), $message);
			$message = str_replace('{NAME}', KRequest::get('post.name', 'string'), $message);
			$message = str_replace('{EMAIL}', KRequest::get('post.email', 'string'), $message);
			$message = str_replace('{TICKETS}', KRequest::get('post.number_of_tickets', 'string'), $message);
			$message = str_replace('{NOTES}', KRequest::get('post.notes', 'string'), $message);
			$message = str_replace('{EVENT_TITLE}', $event->title, $message);
			$message = str_replace('{START_DATE}', $date, $message);
			$message = str_replace('{PERSONS_INFO}', $persons_info, $message);

			if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '';
			$message = str_replace('{EVENT_LINK}', 'http://'.$_SERVER['HTTP_HOST'].JRoute::_('index.php?option=com_ohanah&view=event&id='.$event->id.$itemid), $message);

			$emailAddress = KRequest::get('post.email', 'string');

			JUtility::sendMail(JFactory::getConfig()->getValue('mailfrom'), JFactory::getConfig()->getValue('fromname'), $emailAddress, $subject, $message, true);
		}		

		$this->getRedirect();
	}
		
	public function getRedirect()
	{
		$action = KRequest::get('post.action', 'string');

		if ($action == "add") 
		{
			$event = $this->getService('com://site/ohanah.model.events')->id(KRequest::get('post.ohanah_event_id', 'int'))->getItem();
			$url = 'index.php?option=com_ohanah&view=event&id='.$event->id.'&Itemid='.KRequest::get('post.Itemid', 'int');

			if ($event->ticket_cost) 
			{

				if ($event->payment_gateway == 'custom') {	
					$url = $event->custom_payment_url;
				} else if ($event->payment_gateway == 'paypal') {
					$number_of_tickets = KRequest::get('post.number_of_tickets', 'int');
					
					$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick'.
							'&business='.JComponentHelper::getParams('com_ohanah')->get('paypal_email').
							'&email='.KRequest::get('post.email', 'raw').
							'&amount='.$event->ticket_cost.
							'&quantity='.$number_of_tickets.
							'&custom='.KRequest::get('post.ohanah_registration_id', 'int').
							'&currency_code='.JComponentHelper::getParams('com_ohanah')->get('payment_currency').
							'&item_name='.$number_of_tickets.' tickets to '.$event->title.
							'&return='.urlencode('http://'.$_SERVER["HTTP_HOST"].JRoute::_('index.php?option=com_ohanah&view=event&id='.$event->id.'&Itemid='.KRequest::get('post.Itemid', 'int'))).
							'&cancel_return='.urlencode('http://'.$_SERVER["HTTP_HOST"].JRoute::_('index.php?option=com_ohanah&view=event&id='.$event->id.'&Itemid='.KRequest::get('post.Itemid', 'int')));
				}
			}
			
			if (!$this->_message) {
				return $result = array(
					'message' 		=> JText::_('YOU_HAVE_JOINED_THIS_EVENT'),
					'messageType' 	=> 'Notice',
					'url' 			=> JRoute::_($url, false),
				);
			} else {
				return $result = array(
					'message' 		=> $this->_message,
					'messageType' 	=> 'Notice',
					'url' 			=> JRoute::_($url, false),
				);
			}
			
		}
		else 
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
}