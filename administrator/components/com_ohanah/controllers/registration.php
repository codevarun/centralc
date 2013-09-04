<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerRegistration extends ComDefaultControllerDefault 
{
	public function __construct(KConfig $config)
	{
		parent::__construct($config);
		
		if (JComponentHelper::getParams('com_ohanah')->get('enableMailchimp')) {
			$this->registerCallback('after.delete', array($this, 'removeAttendeeFromMailchimpList'));
		}
	}

	protected function _actionComposeMail(KCommandContext $context)
	{
		$redirect_url = 'index.php?option=com_ohanah&view=registrations&layout=sendmail&ohanah_event_id='.KRequest::get('get.ohanah_event_id', 'int');
		
		foreach (KRequest::get('get.id', 'int') as $registration_id) {
			$redirect_url .= '&id[]='.$registration_id;
		}		

       	$this->setRedirect($redirect_url);
	}

	protected function _actionComposepayremindermail(KCommandContext $context)
	{
		$redirect_url = 'index.php?option=com_ohanah&view=registrations&layout=sendmail&payreminder=1&ohanah_event_id='.KRequest::get('get.ohanah_event_id', 'int');
		
		foreach (KRequest::get('get.id', 'int') as $registration_id) {
			$redirect_url .= '&id[]='.$registration_id;
		}		

       	$this->setRedirect($redirect_url);
	}
	
	public function removeAttendeeFromMailchimpList() { 
		$event = $this->getService('com://admin/ohanah.model.events')->id(KRequest::get('post.ohanah_event_id', 'int'))->getItem();
			
		if ($event->mailchimp_list_id) {
			$this->removeFromMailchimp($this->getService('com://admin/ohanah.model.registrations')->id(KRequest::get('post.ohanah_registration_id', 'int'))->getItem()->email, $mailchimp_list_id);
		}
	} 

	public function removeFromMailchimp($email, $listId)
	{
		$apiKey = JComponentHelper::getParams('com_ohanah')->get('mailchimpApiKey');
		$data = array('apikey' => $apiKey, 'id'	=> $listId, 'email_address' => $email, 'send_goodbye' => false, 'send_notify' => false);
		$payload = json_encode($data);
		 
		$submit_url = '//'.substr($apiKey, strlen($apiKey)-3, 3).'.api.mailchimp.com/1.3/?method=listUnsubscribe';
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $submit_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
		 
		$result = curl_exec($ch);
		curl_close ($ch);
		$data = json_decode($result);
				
		if (isset($data->error)){
		    //echo $data->code .' : '.$data->error."\n";
		} else {
		    //echo "success, look for the confirmation message\n";
		}
	}
	
    public function setMessage(KCommandContext $context)
	{}
	
	protected function _actionSendEmail(KCommandContext $context)
	{
		if (KRequest::get('post.eventid', 'int')) {

			$event = $this->getService('com://admin/ohanah.model.events')->id(KRequest::get('post.eventid', 'int'))->getItem();

			$recipients = array();

			$people = KRequest::get('post.id', 'raw');

			foreach ($people as $registration_id) {
				$registration = $this->getService('com://admin/ohanah.model.registrations')->id($registration_id)->getItem();
			 	$recipients[] = $registration->email;
			}

			if (count($recipients)) {
				$mailfrom = JFactory::getConfig()->getValue('mailfrom');
				$fromname = JFactory::getConfig()->getValue('fromname');

				$subject = KRequest::get('post.subject', 'string');
				$message = KRequest::get('post.message', 'string');

				$date = new KDate(new KConfig(array('date' => $event->date)));
				$date = $date->day." ".JText::_($date->getDate("%B"))." ".$date->year;

				$subject = str_replace('{NAME}', $registration->name, $subject);
				$subject = str_replace('{EMAIL}', $registration->email, $subject);
				$subject = str_replace('{EVENT_TITLE}', $event->title, $subject);
				$subject = str_replace('{START_DATE}', $date, $subject);
				$subject = str_replace('{EVENT_LINK}', '', $subject);

				$message = str_replace('{NAME}', $registration->name, $message);
				$message = str_replace('{EMAIL}', $registration->email, $message);
				$message = str_replace('{EVENT_TITLE}', $event->title, $message);
				$message = str_replace('{START_DATE}', $date, $message);

			
			if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '';
			$message = str_replace('{EVENT_LINK}', 'http://'.$_SERVER['HTTP_HOST'].JRoute::_('index.php?option=com_ohanah&view=event&id='.$event->id.$itemid), $message);



				JUtility::sendMail($mailfrom, $fromname, $recipients, $subject, $message, true);
				JFactory::getApplication()->enqueueMessage(JText::sprintf('OHANAH_MESSAGE_SENT', count($recipients)));
			} else {
				JFactory::getApplication()->enqueueMessage(JText::_('OHANAH_MESSAGE_NOT_SENT'));
			}
		} 
		else {
			JError::raiseWarning(0, 'OHANAH_NO_EVENT_SELECTED');
		}			
		$this->getRedirect();
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
		$context->data['params'] = $this->getService('com://admin/ohanah.controller.registration')->processParams();
		$this->_message = JText::_('OHANAH_SAVED_CHANGES');

		return parent::_actionAdd($context);
	}


	protected function _actionEdit(KCommandContext $context)
	{	
		if (KRequest::get('get.view', 'string') == 'registration') {
			$context->data['params'] = $this->getService('com://admin/ohanah.controller.registration')->processParams();
		}

		$this->_message = JText::_('OHANAH_SAVED_CHANGES');

		return parent::_actionEdit($context);
	}

	public function getRedirect()
	{
		$action = KRequest::get('post.action', 'string');

		if ($action == 'cancel' || $action == 'save') {

			$event_id = $this->getService('com://admin/ohanah.model.registrations')->id(KRequest::get('post.id', 'int'))->getItem()->ohanah_event_id;
			if (!$event_id) $event_id = KRequest::get('post.ohanah_event_id', 'int');

			$url = 'index.php?option=com_ohanah&view=registrations&ohanah_event_id='.$event_id.'&format=html';

			return $result = array('url' => JRoute::_($url, false));	
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