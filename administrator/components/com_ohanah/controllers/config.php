<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerConfig extends ComDefaultControllerResource
{
	public function _actionSendtestmail(KCommandContext $context) {
		$subject = KRequest::get('post.subject', 'string');
		$message = KRequest::get('post.message', 'raw');

		$date = new KDate(new KConfig(array('date' => '2012-12-21')));
		$date = $date->day." ".JText::_($date->getDate("%B"))." ".$date->year;

		$subject = str_replace('{NAME}', 'John Appleseed', $subject);
		$subject = str_replace('{EMAIL}', 'john@appleseed.com', $subject);
		$subject = str_replace('{EVENT_TITLE}', 'My Test Event', $subject);
		$subject = str_replace('{EVENT_LINK}', '', $subject);
		$subject = str_replace('{START_DATE}', $date, $subject);
		$subject = str_replace('{TICKETS}', '2', $subject);
		$subject = str_replace('{NOTES}', 'Sample additional notes', $subject);
		$subject = str_replace('{PERSONS_INFO}', '', $subject);



		$message = str_replace('{NAME}', 'John Appleseed', $message);
		$message = str_replace('{EMAIL}', 'john@appleseed.com', $message);
		$message = str_replace('{EVENT_TITLE}', 'My Test Event', $message);
		$message = str_replace('{EVENT_LINK}', 'http://link-to-my-site.com/my-event', $message);
		$message = str_replace('{START_DATE}', $date, $message);
		$message = str_replace('{TICKETS}', '2', $message);
		$message = str_replace('{NOTES}', 'Sample additional notes', $message);
		$message = str_replace('{PERSONS_INFO}', '<ul  class="persons_info" style="list-style-type:none;"><li><strong>Registrant</strong></li><li>Phone number: +38195648246</li><li>Age: 42</li></ul><ul  class="persons_info" style="list-style-type:none;"><li><strong>Wife</strong></li><li>Phone number: +381434234234</li><li>Age: 39</li></ul>', $message);

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

	private function _save() {
		
		$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
		if ($joomlaVersion == '1.5') { 
			$table =& JTable::getInstance('component');
			$table->loadByOption('com_ohanah');
		} else {
			$table =& JTable::getInstance('extension');
			$db =& JFactory::getDBO();
			$db->setQuery('SELECT extension_id FROM #__extensions WHERE type="component" AND element="com_ohanah"');
			$extension_id = $db->loadResult();
			$table->load($extension_id);
		}

		$post['option'] = 'com_ohanah';
		$post['params']['itemid']= KRequest::get('post.itemid', 'int');
		$post['params']['enableEmail']= KRequest::get('post.enableEmail', 'int');
		$post['params']['paypal_email']= KRequest::get('post.paypal_email', 'string');
		$post['params']['payment_currency']= KRequest::get('post.payment_currency', 'string');
		$post['params']['payment_gateway']= KRequest::get('post.payment_gateway', 'string');
		$post['params']['loadJQuery']= KRequest::get('post.loadJQuery', 'int');
		$post['params']['dst']= KRequest::get('post.dst', 'int');
		$post['params']['timeFormat']= KRequest::get('post.timeFormat', 'string');
		$post['params']['customCSS']= KRequest::get('post.customCSS', 'string');
		$post['params']['showLinkBack']= KRequest::get('post.showLinkBack', 'int');
		$post['params']['usePagination']= KRequest::get('post.usePagination', 'int');
		$post['params']['eventsPerPage']= KRequest::get('post.eventsPerPage', 'int');
		$post['params']['showFeedLink']= KRequest::get('post.showFeedLink', 'int');

		$post['params']['subject_mail_new_event']= KRequest::get('post.subject_mail_new_event', 'string');
		$post['params']['text_mail_new_event']= KRequest::get('post.text_mail_new_event', 'raw');
		$post['params']['subject_mail_new_registration_organizer']= KRequest::get('post.subject_mail_new_registration_organizer', 'string');
		$post['params']['text_mail_new_registration_organizer']= KRequest::get('post.text_mail_new_registration_organizer', 'raw');
		$post['params']['subject_mail_new_registration_registrant']= KRequest::get('post.subject_mail_new_registration_registrant', 'string');
		$post['params']['text_mail_new_registration_registrant']= KRequest::get('post.text_mail_new_registration_registrant', 'raw');

		$post['params']['singleEventModulePosition1']= KRequest::get('post.singleEventModulePosition1', 'string');
		$post['params']['singleEventModulePosition2']= KRequest::get('post.singleEventModulePosition2', 'string');
		$post['params']['singleEventModulePosition3']= KRequest::get('post.singleEventModulePosition3', 'string');
		$post['params']['listEventsModulePosition1']= KRequest::get('post.listEventsModulePosition1', 'string');
		$post['params']['listEventsModulePosition2']= KRequest::get('post.listEventsModulePosition2', 'string');
		$post['params']['listEventsModulePosition3']= KRequest::get('post.listEventsModulePosition3', 'string');
		$post['params']['eventRegistrationModulePosition1']= KRequest::get('post.eventRegistrationModulePosition1', 'string');
		$post['params']['eventRegistrationModulePosition2']= KRequest::get('post.eventRegistrationModulePosition2', 'string');
		$post['params']['eventRegistrationModulePosition3']= KRequest::get('post.eventRegistrationModulePosition3', 'string');
		$post['params']['singleVenueModulePosition1']= KRequest::get('post.singleVenueModulePosition1', 'string');
		$post['params']['singleVenueModulePosition2']= KRequest::get('post.singleVenueModulePosition2', 'string');
		$post['params']['singleVenueModulePosition3']= KRequest::get('post.singleVenueModulePosition3', 'string');
		$post['params']['singleCategoryModulePosition1']= KRequest::get('post.singleCategoryModulePosition1', 'string');
		$post['params']['singleCategoryModulePosition2']= KRequest::get('post.singleCategoryModulePosition2', 'string');
		$post['params']['singleCategoryModulePosition3']= KRequest::get('post.singleCategoryModulePosition3', 'string');
		
		$post['params']['registration_system']= KRequest::get('post.registration_system', 'string');

		$post['params']['enableMailchimp']= KRequest::get('post.enableMailchimp', 'int');
		$post['params']['mailchimpApiKey']= KRequest::get('post.mailchimpApiKey', 'raw');

		$post['params']['commentsCode'] = htmlentities(KRequest::get('post.commentsCode', 'raw'));

		$post['params']['custom_field_label_1']= KRequest::get('post.custom_field_label_1', 'raw');
		$post['params']['custom_field_label_2']= KRequest::get('post.custom_field_label_2', 'raw');
		$post['params']['custom_field_label_3']= KRequest::get('post.custom_field_label_3', 'raw');
		$post['params']['custom_field_label_4']= KRequest::get('post.custom_field_label_4', 'raw');
		$post['params']['custom_field_label_5']= KRequest::get('post.custom_field_label_5', 'raw');
		$post['params']['custom_field_label_6']= KRequest::get('post.custom_field_label_6', 'raw');
		$post['params']['custom_field_label_7']= KRequest::get('post.custom_field_label_7', 'raw');
		$post['params']['custom_field_label_8']= KRequest::get('post.custom_field_label_8', 'raw');
		$post['params']['custom_field_label_9']= KRequest::get('post.custom_field_label_9', 'raw');
		$post['params']['custom_field_label_10']= KRequest::get('post.custom_field_label_10', 'raw');

		$post['params']['custom_field_label_1_checked']= KRequest::get('post.custom_field_label_1_checked', 'raw');
		$post['params']['custom_field_label_2_checked']= KRequest::get('post.custom_field_label_2_checked', 'raw');
		$post['params']['custom_field_label_3_checked']= KRequest::get('post.custom_field_label_3_checked', 'raw');
		$post['params']['custom_field_label_4_checked']= KRequest::get('post.custom_field_label_4_checked', 'raw');
		$post['params']['custom_field_label_5_checked']= KRequest::get('post.custom_field_label_5_checked', 'raw');
		$post['params']['custom_field_label_6_checked']= KRequest::get('post.custom_field_label_6_checked', 'raw');
		$post['params']['custom_field_label_7_checked']= KRequest::get('post.custom_field_label_7_checked', 'raw');
		$post['params']['custom_field_label_8_checked']= KRequest::get('post.custom_field_label_8_checked', 'raw');
		$post['params']['custom_field_label_9_checked']= KRequest::get('post.custom_field_label_9_checked', 'raw');
		$post['params']['custom_field_label_10_checked']= KRequest::get('post.custom_field_label_10_checked', 'raw');

		$post['params']['custom_field_label_1_mandatory']= KRequest::get('post.custom_field_label_1_mandatory', 'raw');
		$post['params']['custom_field_label_2_mandatory']= KRequest::get('post.custom_field_label_2_mandatory', 'raw');
		$post['params']['custom_field_label_3_mandatory']= KRequest::get('post.custom_field_label_3_mandatory', 'raw');
		$post['params']['custom_field_label_4_mandatory']= KRequest::get('post.custom_field_label_4_mandatory', 'raw');
		$post['params']['custom_field_label_5_mandatory']= KRequest::get('post.custom_field_label_5_mandatory', 'raw');
		$post['params']['custom_field_label_6_mandatory']= KRequest::get('post.custom_field_label_6_mandatory', 'raw');
		$post['params']['custom_field_label_7_mandatory']= KRequest::get('post.custom_field_label_7_mandatory', 'raw');
		$post['params']['custom_field_label_8_mandatory']= KRequest::get('post.custom_field_label_8_mandatory', 'raw');
		$post['params']['custom_field_label_9_mandatory']= KRequest::get('post.custom_field_label_9_mandatory', 'raw');
		$post['params']['custom_field_label_10_mandatory']= KRequest::get('post.custom_field_label_10_mandatory', 'raw');

		$post['params']['module_chrome']= KRequest::get('post.module_chrome', 'raw');
		$post['params']['moduleclass_sfx']= KRequest::get('post.moduleclass_sfx', 'raw');
		$post['params']['event_place_style']= KRequest::get('post.event_place_style', 'raw');

		$post['params']['destination_email']= KRequest::get('post.destination_email', 'raw');
		$post['params']['buttons_style']= KRequest::get('post.buttons_style', 'raw');
		$post['params']['useFacebookComments']= KRequest::get('post.useFacebookComments', 'int');
		$post['params']['redirect_after_add_event']= KRequest::get('post.redirect_after_add_event', 'raw');
		$post['params']['localEnvironment']= KRequest::get('post.localEnvironment', 'int');


		// Checkboxes

		if (KRequest::get('post.allow_only_one_ticket', 'string') != null) $allow_only_one_ticket = 1; else $allow_only_one_ticket = 0;
		$post['params']['allow_only_one_ticket'] = $allow_only_one_ticket;

		if (KRequest::get('post.frontend_editing', 'string') != null) $frontend_editing = 1; else $frontend_editing = 0;
		$post['params']['frontend_editing'] = $frontend_editing;

		if (KRequest::get('post.disableModuleInjector', 'string') != null) $disableModuleInjector = 1; else $disableModuleInjector = 0;
		$post['params']['disableModuleInjector'] = $disableModuleInjector;

		if (KRequest::get('post.enableComments', 'string') != null) $enableComments = 1; else $enableComments = 0;
		$post['params']['enableComments'] = $enableComments;

		if (KRequest::get('post.moderation', 'string') != null) $moderation = 1; else $moderation = 0;
		$post['params']['moderation'] = $moderation;

		if (KRequest::get('post.enable_frontend', 'string') != null) $enable_frontend = 1; else $enable_frontend = 0;
		$post['params']['enable_frontend'] = $enable_frontend;

		if (KRequest::get('post.dst', 'string') != null) $dst = 1; else $dst = 0;
		$post['params']['dst'] = $dst;

		if (KRequest::get('post.enableEmailNewEventFrontend', 'string') != null) $enableEmailNewEventFrontend = 1; else $enableEmailNewEventFrontend = 0;
		$post['params']['enableEmailNewEventFrontend'] = $enableEmailNewEventFrontend;

		if (KRequest::get('post.enableEmailNewRegistration', 'string') != null) $enableEmailNewRegistration = 1; else $enableEmailNewRegistration = 0;
		$post['params']['enableEmailNewRegistration'] = $enableEmailNewRegistration;

		if (KRequest::get('post.enableEmailRegistrationConfirmation', 'string') != null) $enableEmailRegistrationConfirmation = 1; else $enableEmailRegistrationConfirmation = 0;
		$post['params']['enableEmailRegistrationConfirmation'] = $enableEmailRegistrationConfirmation;

		if (KRequest::get('post.showButtonFacebook', 'string') != null) $showButtonFacebook = 1; else $showButtonFacebook = 0;
		$post['params']['showButtonFacebook'] = $showButtonFacebook;
		if (KRequest::get('post.showButtonGoogle', 'string') != null) $showButtonGoogle = 1; else $showButtonGoogle = 0;
		$post['params']['showButtonGoogle'] = $showButtonGoogle;
		if (KRequest::get('post.showButtonTwitter', 'string') != null) $showButtonTwitter = 1; else $showButtonTwitter = 0;
		$post['params']['showButtonTwitter'] = $showButtonTwitter;
		
		if (KRequest::get('post.useStandardJoomlaEditor', 'string') != null) $useStandardJoomlaEditor = 1; else $useStandardJoomlaEditor = 0;
		$post['params']['useStandardJoomlaEditor'] = $useStandardJoomlaEditor;


		if (KRequest::get('post.showLinkToCategoryInList', 'string') != null) $showLinkToCategoryInList = 1; else $showLinkToCategoryInList = 0;
		$post['params']['showLinkToCategoryInList'] = $showLinkToCategoryInList;
		if (KRequest::get('post.showLinkToCategoryInSingle', 'string') != null) $showLinkToCategoryInSingle = 1; else $showLinkToCategoryInSingle = 0;
		$post['params']['showLinkToCategoryInSingle'] = $showLinkToCategoryInSingle;
		if (KRequest::get('post.showLinkToCategoryInModule', 'string') != null) $showLinkToCategoryInModule = 1; else $showLinkToCategoryInModule = 0;
		$post['params']['showLinkToCategoryInModule'] = $showLinkToCategoryInModule;
		if (KRequest::get('post.showLinkToVenueInList', 'string') != null) $showLinkToVenueInList = 1; else $showLinkToVenueInList = 0;
		$post['params']['showLinkToVenueInList'] = $showLinkToVenueInList;
		if (KRequest::get('post.showLinkToVenueInSingle', 'string') != null) $showLinkToVenueInSingle = 1; else $showLinkToVenueInSingle = 0;
		$post['params']['showLinkToVenueInSingle'] = $showLinkToVenueInSingle;
		if (KRequest::get('post.showLinkToVenueInModule', 'string') != null) $showLinkToVenueInModule = 1; else $showLinkToVenueInModule = 0;
		$post['params']['showLinkToVenueInModule'] = $showLinkToVenueInModule;
		if (KRequest::get('post.showLinkToRecurringSetInList', 'string') != null) $showLinkToRecurringSetInList = 1; else $showLinkToRecurringSetInList = 0;
		$post['params']['showLinkToRecurringSetInList'] = $showLinkToRecurringSetInList;
		if (KRequest::get('post.showLinkToRecurringSetInSingle', 'string') != null) $showLinkToRecurringSetInSingle = 1; else $showLinkToRecurringSetInSingle = 0;
		$post['params']['showLinkToRecurringSetInSingle'] = $showLinkToRecurringSetInSingle;
		if (KRequest::get('post.showLinkToRecurringSetInModule', 'string') != null) $showLinkToRecurringSetInModule = 1; else $showLinkToRecurringSetInModule = 0;
		$post['params']['showLinkToRecurringSetInModule'] = $showLinkToRecurringSetInModule;
		if (KRequest::get('post.showLinkToSaveToCalInList', 'string') != null) $showLinkToSaveToCalInList = 1; else $showLinkToSaveToCalInList = 0;
		$post['params']['showLinkToSaveToCalInList'] = $showLinkToSaveToCalInList;
		if (KRequest::get('post.showLinkToSaveToCalInSingle', 'string') != null) $showLinkToSaveToCalInSingle = 1; else $showLinkToSaveToCalInSingle = 0;
		$post['params']['showLinkToSaveToCalInSingle'] = $showLinkToSaveToCalInSingle;
		if (KRequest::get('post.showLinkToSaveToCalInModule', 'string') != null) $showLinkToSaveToCalInModule = 1; else $showLinkToSaveToCalInModule = 0;
		$post['params']['showLinkToSaveToCalInModule'] = $showLinkToSaveToCalInModule;
		if (KRequest::get('post.showCostInfoInList', 'string') != null) $showCostInfoInList = 1; else $showCostInfoInList = 0;
		$post['params']['showCostInfoInList'] = $showCostInfoInList;
		if (KRequest::get('post.showCostInfoInSingle', 'string') != null) $showCostInfoInSingle = 1; else $showCostInfoInSingle = 0;
		$post['params']['showCostInfoInSingle'] = $showCostInfoInSingle;
		if (KRequest::get('post.showCostInfoInModule', 'string') != null) $showCostInfoInModule = 1; else $showCostInfoInModule = 0;
		$post['params']['showCostInfoInModule'] = $showCostInfoInModule;
		if (KRequest::get('post.showPlacesLeftInList', 'string') != null) $showPlacesLeftInList = 1; else $showPlacesLeftInList = 0;
		$post['params']['showPlacesLeftInList'] = $showPlacesLeftInList;
		if (KRequest::get('post.showPlacesLeftInSingle', 'string') != null) $showPlacesLeftInSingle = 1; else $showPlacesLeftInSingle = 0;
		$post['params']['showPlacesLeftInSingle'] = $showPlacesLeftInSingle;
		if (KRequest::get('post.showPlacesLeftInModule', 'string') != null) $showPlacesLeftInModule = 1; else $showPlacesLeftInModule = 0;
		$post['params']['showPlacesLeftInModule'] = $showPlacesLeftInModule;
		if (KRequest::get('post.showEventPictureInList', 'string') != null) $showEventPictureInList = 1; else $showEventPictureInList = 0;
		$post['params']['showEventPictureInList'] = $showEventPictureInList;
		if (KRequest::get('post.showEventPictureInSingle', 'string') != null) $showEventPictureInSingle = 1; else $showEventPictureInSingle = 0;
		$post['params']['showEventPictureInSingle'] = $showEventPictureInSingle;
		if (KRequest::get('post.showEventPictureInModule', 'string') != null) $showEventPictureInModule = 1; else $showEventPictureInModule = 0;
		$post['params']['showEventPictureInModule'] = $showEventPictureInModule;
		if (KRequest::get('post.showEventFullDescriptionInList', 'string') != null) $showEventFullDescriptionInList = 1; else $showEventFullDescriptionInList = 0;
		$post['params']['showEventFullDescriptionInList'] = $showEventFullDescriptionInList;
		if (KRequest::get('post.showEventFullDescriptionInSingle', 'string') != null) $showEventFullDescriptionInSingle = 1; else $showEventFullDescriptionInSingle = 0;
		$post['params']['showEventFullDescriptionInSingle'] = $showEventFullDescriptionInSingle;
		if (KRequest::get('post.showEventFullDescriptionInModule', 'string') != null) $showEventFullDescriptionInModule = 1; else $showEventFullDescriptionInModule = 0;
		$post['params']['showEventFullDescriptionInModule'] = $showEventFullDescriptionInModule;
		if (KRequest::get('post.showEventDescriptionSnippetInList', 'string') != null) $showEventDescriptionSnippetInList = 1; else $showEventDescriptionSnippetInList = 0;
		$post['params']['showEventDescriptionSnippetInList'] = $showEventDescriptionSnippetInList;
		if (KRequest::get('post.showEventDescriptionSnippetInSingle', 'string') != null) $showEventDescriptionSnippetInSingle = 1; else $showEventDescriptionSnippetInSingle = 0;
		$post['params']['showEventDescriptionSnippetInSingle'] = $showEventDescriptionSnippetInSingle;
		if (KRequest::get('post.showEventDescriptionSnippetInModule', 'string') != null) $showEventDescriptionSnippetInModule = 1; else $showEventDescriptionSnippetInModule = 0;
		$post['params']['showEventDescriptionSnippetInModule'] = $showEventDescriptionSnippetInModule;
		if (KRequest::get('post.showEventDateInList', 'string') != null) $showEventDateInList = 1; else $showEventDateInList = 0;
		$post['params']['showEventDateInList'] = $showEventDateInList;
       	if (KRequest::get('post.showEventDateInSingle', 'string') != null) $showEventDateInSingle = 1; else $showEventDateInSingle = 0;
		$post['params']['showEventDateInSingle'] = $showEventDateInSingle;
		if (KRequest::get('post.showEventDateInModule', 'string') != null) $showEventDateInModule = 1; else $showEventDateInModule = 0;
		$post['params']['showEventDateInModule'] = $showEventDateInModule;
		if (KRequest::get('post.showEventAddressInList', 'string') != null) $showEventAddressInList = 1; else $showEventAddressInList = 0;
		$post['params']['showEventAddressInList'] = $showEventAddressInList;
		if (KRequest::get('post.showEventAddressInSingle', 'string') != null) $showEventAddressInSingle = 1; else $showEventAddressInSingle = 0;
		$post['params']['showEventAddressInSingle'] = $showEventAddressInSingle;
		if (KRequest::get('post.showEventAddressInModule', 'string') != null) $showEventAddressInModule = 1; else $showEventAddressInModule = 0;
		$post['params']['showEventAddressInModule'] = $showEventAddressInModule;
		if (KRequest::get('post.showBigDateBadgeInList', 'string') != null) $showBigDateBadgeInList = 1; else $showBigDateBadgeInList = 0;
		$post['params']['showBigDateBadgeInList'] = $showBigDateBadgeInList;
		if (KRequest::get('post.showBigDateBadgeInSingle', 'string') != null) $showBigDateBadgeInSingle = 1; else $showBigDateBadgeInSingle = 0;
		$post['params']['showBigDateBadgeInSingle'] = $showBigDateBadgeInSingle;
		if (KRequest::get('post.showBigDateBadgeInModule', 'string') != null) $showBigDateBadgeInModule = 1; else $showBigDateBadgeInModule = 0;
		$post['params']['showBigDateBadgeInModule'] = $showBigDateBadgeInModule;

		if (KRequest::get('post.showReadMoreInList', 'string') != null) $showReadMoreInList = 1; else $showReadMoreInList = 0;
		$post['params']['showReadMoreInList'] = $showReadMoreInList;
		if (KRequest::get('post.showReadMoreInSingle', 'string') != null) $showReadMoreInSingle = 1; else $showReadMoreInSingle = 0;
		$post['params']['showReadMoreInSingle'] = $showReadMoreInSingle;
		if (KRequest::get('post.showReadMoreInModule', 'string') != null) $showReadMoreInModule = 1; else $showReadMoreInModule = 0;
		$post['params']['showReadMoreInModule'] = $showReadMoreInModule;
		if (KRequest::get('post.showTimeInList', 'string') != null) $showTimeInList = 1; else $showTimeInList = 0;
		$post['params']['showTimeInList'] = $showTimeInList;
		if (KRequest::get('post.showTimeInSingle', 'string') != null) $showTimeInSingle = 1; else $showTimeInSingle = 0;
		$post['params']['showTimeInSingle'] = $showTimeInSingle;
		if (KRequest::get('post.showTimeInModule', 'string') != null) $showTimeInModule = 1; else $showTimeInModule = 0;
		$post['params']['showTimeInModule'] = $showTimeInModule;

		if (KRequest::get('post.showLinkToCategoryInRegistration', 'string') != null) $showLinkToCategoryInRegistration = 1; else $showLinkToCategoryInRegistration = 0;
		$post['params']['showLinkToCategoryInRegistration'] = $showLinkToCategoryInRegistration;
		if (KRequest::get('post.showLinkToVenueInRegistration', 'string') != null) $showLinkToVenueInRegistration = 1; else $showLinkToVenueInRegistration = 0;
		$post['params']['showLinkToVenueInRegistration'] = $showLinkToVenueInRegistration;
		if (KRequest::get('post.showLinkToRecurringSetInRegistration', 'string') != null) $showLinkToRecurringSetInRegistration = 1; else $showLinkToRecurringSetInRegistration = 0;
		$post['params']['showLinkToRecurringSetInRegistration'] = $showLinkToRecurringSetInRegistration;
		if (KRequest::get('post.showLinkToSaveToCalInRegistration', 'string') != null) $showLinkToSaveToCalInRegistration = 1; else $showLinkToSaveToCalInRegistration = 0;
		$post['params']['showLinkToSaveToCalInRegistration'] = $showLinkToSaveToCalInRegistration;
		if (KRequest::get('post.showCostInfoInRegistration', 'string') != null) $showCostInfoInRegistration = 1; else $showCostInfoInRegistration = 0;
		$post['params']['showCostInfoInRegistration'] = $showCostInfoInRegistration;
		if (KRequest::get('post.showPlacesLeftInRegistration', 'string') != null) $showPlacesLeftInRegistration = 1; else $showPlacesLeftInRegistration = 0;
		$post['params']['showPlacesLeftInRegistration'] = $showPlacesLeftInRegistration;
		if (KRequest::get('post.showEventPictureInRegistration', 'string') != null) $showEventPictureInRegistration = 1; else $showEventPictureInRegistration = 0;
		$post['params']['showEventPictureInRegistration'] = $showEventPictureInRegistration;
		if (KRequest::get('post.showEventFullDescriptionInRegistration', 'string') != null) $showEventFullDescriptionInRegistration = 1; else $showEventFullDescriptionInRegistration = 0;
		$post['params']['showEventFullDescriptionInRegistration'] = $showEventFullDescriptionInRegistration;
		if (KRequest::get('post.showEventDescriptionSnippetInRegistration', 'string') != null) $showEventDescriptionSnippetInRegistration = 1; else $showEventDescriptionSnippetInRegistration = 0;
		$post['params']['showEventDescriptionSnippetInRegistration'] = $showEventDescriptionSnippetInRegistration;
		if (KRequest::get('post.showEventDateInRegistration', 'string') != null) $showEventDateInRegistration = 1; else $showEventDateInRegistration = 0;
		$post['params']['showEventDateInRegistration'] = $showEventDateInRegistration;
		if (KRequest::get('post.showBigDateBadgeInRegistration', 'string') != null) $showBigDateBadgeInRegistration = 1; else $showBigDateBadgeInRegistration = 0;
		$post['params']['showBigDateBadgeInRegistration'] = $showBigDateBadgeInRegistration;
		if (KRequest::get('post.showEventAddressInRegistration', 'string') != null) $showEventAddressInRegistration = 1; else $showEventAddressInRegistration = 0;
		$post['params']['showEventAddressInRegistration'] = $showEventAddressInRegistration;
		if (KRequest::get('post.showTimeInRegistration', 'string') != null) $showTimeInRegistration = 1; else $showTimeInRegistration = 0;
		$post['params']['showTimeInRegistration'] = $showTimeInRegistration;
		if (KRequest::get('post.showReadMoreInRegistration', 'string') != null) $showReadMoreInRegistration = 1; else $showReadMoreInRegistration = 0;
		$post['params']['showReadMoreInRegistration'] = $showReadMoreInRegistration;


		// End checkboxes

		$table->bind($post);
		$table->store();
	}

	protected function _actionSave(KCommandContext $context) 
	{
		$this->_save();
		$this->_message = JText::_('OHANAH_CHANGES_APPLIED');
	}
	protected function _actionApply(KCommandContext $context) 
	{
		$this->_save();
		$this->_message = JText::_('OHANAH_CHANGES_APPLIED');
	}
		
	public function getRedirect()
	{
		$action = KRequest::get('post.action', 'string');
		if ($action == "save") 
		{
			$url = 'index.php?option=com_ohanah&view=events';
			
			return $result = array(
				'url' 			=> JRoute::_($url, false),
				'message' 		=> $this->_message,
				'messageType' 	=> $this->_messageType
			);
		} elseif ($action == "apply") 
		{
			$url = 'index.php?option=com_ohanah&view=config';
			
			return $result = array(
				'url' 			=> JRoute::_($url, false),
				'message' 		=> $this->_message,
				'messageType' 	=> $this->_messageType
			);
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