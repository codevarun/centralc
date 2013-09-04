<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined('_JEXEC') or die('Restricted access');

class ComOhanahViewConfigHtml extends ComOhanahViewHtml
{
	public function display()
	{       
    	KRequest::set('get.hidemainmenu', 1);

    	$params = null;

    	$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
        
        if ($joomlaVersion == '1.5') { 
        	$params = JComponentHelper::getParams('com_ohanah')->toObject();
        } else {
           	$params = (json_decode(JComponentHelper::getComponent('com_ohanah')->params));
        }

        if (!isset($params->showFeedLink)) $params->showFeedLink = '0';
        if (!isset($params->useFacebookComments)) $params->useFacebookComments = '0';
        if (!isset($params->disableModuleInjector)) $params->disableModuleInjector = null;
        if (!isset($params->itemid)) $params->itemid = null;
        if (!isset($params->enableEmail)) $params->enableEmail = null;
        if (!isset($params->paypal_email)) $params->paypal_email = null;
        if (!isset($params->payment_currency)) $params->payment_currency = null;
        if (!isset($params->payment_gateway)) $params->payment_gateway = null;
        if (!isset($params->loadJQuery)) $params->loadJQuery = null;
        if (!isset($params->dst)) $params->dst = null;
        if (!isset($params->timeFormat)) $params->timeFormat = null;
        if (!isset($params->customCSS)) $params->customCSS = null;
        if (!isset($params->showLinkBack)) $params->showLinkBack = null;
        if (!isset($params->usePagination)) $params->usePagination = null;
        if (!isset($params->eventsPerPage)) $params->eventsPerPage = null;
        if (!isset($params->subject_mail_new_event)) $params->subject_mail_new_event = null;
        if (!isset($params->text_mail_new_event)) $params->text_mail_new_event = null;
        if (!isset($params->subject_mail_new_registration_organizer)) $params->subject_mail_new_registration_organizer = null;
        if (!isset($params->text_mail_new_registration_organizer)) $params->text_mail_new_registration_organizer = null;
        if (!isset($params->subject_mail_new_registration_registrant)) $params->subject_mail_new_registration_registrant = null;
        if (!isset($params->text_mail_new_registration_registrant)) $params->text_mail_new_registration_registrant = null;
        if (!isset($params->singleEventModulePosition1)) $params->singleEventModulePosition1 = null;
        if (!isset($params->singleEventModulePosition2)) $params->singleEventModulePosition2 = null;
        if (!isset($params->singleEventModulePosition3)) $params->singleEventModulePosition3 = null;
        if (!isset($params->listEventsModulePosition1)) $params->listEventsModulePosition1 = null;
        if (!isset($params->listEventsModulePosition2)) $params->listEventsModulePosition2 = null;
        if (!isset($params->listEventsModulePosition3)) $params->listEventsModulePosition3 = null;
        if (!isset($params->eventRegistrationModulePosition1)) $params->eventRegistrationModulePosition1 = null;
        if (!isset($params->eventRegistrationModulePosition2)) $params->eventRegistrationModulePosition2 = null;
        if (!isset($params->eventRegistrationModulePosition3)) $params->eventRegistrationModulePosition3 = null;
        if (!isset($params->singleVenueModulePosition1)) $params->singleVenueModulePosition1 = null;
        if (!isset($params->singleVenueModulePosition2)) $params->singleVenueModulePosition2 = null;
        if (!isset($params->singleVenueModulePosition3)) $params->singleVenueModulePosition3 = null;
        if (!isset($params->singleCategoryModulePosition1)) $params->singleCategoryModulePosition1 = null;
        if (!isset($params->singleCategoryModulePosition2)) $params->singleCategoryModulePosition2 = null;
        if (!isset($params->singleCategoryModulePosition3)) $params->singleCategoryModulePosition3 = null;
        if (!isset($params->registration_system)) $params->registration_system = null;
        if (!isset($params->enableMailchimp)) $params->enableMailchimp = null;
        if (!isset($params->mailchimpApiKey)) $params->mailchimpApiKey = null;
        if (!isset($params->commentsCode)) $params->commentsCode = null;
        if (!isset($params->custom_field_label_1)) $params->custom_field_label_1 = null;
        if (!isset($params->custom_field_label_2)) $params->custom_field_label_2 = null;
        if (!isset($params->custom_field_label_3)) $params->custom_field_label_3 = null;
        if (!isset($params->custom_field_label_4)) $params->custom_field_label_4 = null;
        if (!isset($params->custom_field_label_5)) $params->custom_field_label_5 = null;
        if (!isset($params->custom_field_label_6)) $params->custom_field_label_6 = null;
        if (!isset($params->custom_field_label_7)) $params->custom_field_label_7 = null;
        if (!isset($params->custom_field_label_8)) $params->custom_field_label_8 = null;
        if (!isset($params->custom_field_label_9)) $params->custom_field_label_9 = null;
        if (!isset($params->custom_field_label_10)) $params->custom_field_label_10 = null;
        if (!isset($params->custom_field_label_1_checked)) $params->custom_field_label_1_checked = null;
        if (!isset($params->custom_field_label_2_checked)) $params->custom_field_label_2_checked = null;
        if (!isset($params->custom_field_label_3_checked)) $params->custom_field_label_3_checked = null;
        if (!isset($params->custom_field_label_4_checked)) $params->custom_field_label_4_checked = null;
        if (!isset($params->custom_field_label_5_checked)) $params->custom_field_label_5_checked = null;
        if (!isset($params->custom_field_label_6_checked)) $params->custom_field_label_6_checked = null;
        if (!isset($params->custom_field_label_7_checked)) $params->custom_field_label_7_checked = null;
        if (!isset($params->custom_field_label_8_checked)) $params->custom_field_label_8_checked = null;
        if (!isset($params->custom_field_label_9_checked)) $params->custom_field_label_9_checked = null;
        if (!isset($params->custom_field_label_10_checked)) $params->custom_field_label_10_checked = null;
        if (!isset($params->custom_field_label_1_mandatory)) $params->custom_field_label_1_mandatory = null;
        if (!isset($params->custom_field_label_2_mandatory)) $params->custom_field_label_2_mandatory = null;
        if (!isset($params->custom_field_label_3_mandatory)) $params->custom_field_label_3_mandatory = null;
        if (!isset($params->custom_field_label_4_mandatory)) $params->custom_field_label_4_mandatory = null;
        if (!isset($params->custom_field_label_5_mandatory)) $params->custom_field_label_5_mandatory = null;
        if (!isset($params->custom_field_label_6_mandatory)) $params->custom_field_label_6_mandatory = null;
        if (!isset($params->custom_field_label_7_mandatory)) $params->custom_field_label_7_mandatory = null;
        if (!isset($params->custom_field_label_8_mandatory)) $params->custom_field_label_8_mandatory = null;
        if (!isset($params->custom_field_label_9_mandatory)) $params->custom_field_label_9_mandatory = null;
        if (!isset($params->custom_field_label_10_mandatory)) $params->custom_field_label_10_mandatory = null;
        if (!isset($params->module_chrome)) $params->module_chrome = null;
        if (!isset($params->moduleclass_sfx)) $params->moduleclass_sfx = null;
        if (!isset($params->event_place_style)) $params->event_place_style = null;
        if (!isset($params->destination_email)) $params->destination_email = null;
        if (!isset($params->buttons_style)) $params->buttons_style = null;
        if (!isset($params->enableComments)) $params->enableComments = null;
        if (!isset($params->moderation)) $params->moderation = null;
        if (!isset($params->enableEmailNewEventFrontend)) $params->enableEmailNewEventFrontend = null;
        if (!isset($params->enableEmailNewRegistration)) $params->enableEmailNewRegistration = null;
        if (!isset($params->enableEmailRegistrationConfirmation)) $params->enableEmailRegistrationConfirmation = null;
        if (!isset($params->showButtonFacebook)) $params->showButtonFacebook = null;
        if (!isset($params->showButtonGoogle)) $params->showButtonGoogle = null;
        if (!isset($params->showButtonTwitter)) $params->showButtonTwitter = null;
        if (!isset($params->useStandardJoomlaEditor)) $params->useStandardJoomlaEditor = null;
        if (!isset($params->enable_frontend)) $params->enable_frontend = null;
        
        if (!isset($params->showLinkToCategoryInList)) $params->showLinkToCategoryInList = 1;
        if (!isset($params->showLinkToCategoryInSingle)) $params->showLinkToCategoryInSingle = 1;
        if (!isset($params->showLinkToCategoryInRegistration)) $params->showLinkToCategoryInRegistration = 1;
        if (!isset($params->showLinkToCategoryInModule)) $params->showLinkToCategoryInModule = 1;
        
        if (!isset($params->showLinkToVenueInList)) $params->showLinkToVenueInList = 1;
        if (!isset($params->showLinkToVenueInSingle)) $params->showLinkToVenueInSingle = 1;
        if (!isset($params->showLinkToVenueInRegistration)) $params->showLinkToVenueInRegistration = 1;
        if (!isset($params->showLinkToVenueInModule)) $params->showLinkToVenueInModule = 1;
        
        if (!isset($params->showLinkToRecurringSetInList)) $params->showLinkToRecurringSetInList = 1;
        if (!isset($params->showLinkToRecurringSetInSingle)) $params->showLinkToRecurringSetInSingle = 1;
        if (!isset($params->showLinkToRecurringSetInRegistration)) $params->showLinkToRecurringSetInRegistration = 1;
        if (!isset($params->showLinkToRecurringSetInModule)) $params->showLinkToRecurringSetInModule = 1;
        
        if (!isset($params->showLinkToSaveToCalInList)) $params->showLinkToSaveToCalInList = 1;
        if (!isset($params->showLinkToSaveToCalInSingle)) $params->showLinkToSaveToCalInSingle = 1;
        if (!isset($params->showLinkToSaveToCalInRegistration)) $params->showLinkToSaveToCalInRegistration = 1;
        if (!isset($params->showLinkToSaveToCalInModule)) $params->showLinkToSaveToCalInModule = 1;
        
        if (!isset($params->showCostInfoInList)) $params->showCostInfoInList = 1;
        if (!isset($params->showCostInfoInSingle)) $params->showCostInfoInSingle = 1;
        if (!isset($params->showCostInfoInRegistration)) $params->showCostInfoInRegistration = 1;
        if (!isset($params->showCostInfoInModule)) $params->showCostInfoInModule = 1;
        
        if (!isset($params->showPlacesLeftInList)) $params->showPlacesLeftInList = 1;
        if (!isset($params->showPlacesLeftInSingle)) $params->showPlacesLeftInSingle = 1;
        if (!isset($params->showPlacesLeftInRegistration)) $params->showPlacesLeftInRegistration = 1;
        if (!isset($params->showPlacesLeftInModule)) $params->showPlacesLeftInModule = 1;
        
        if (!isset($params->showEventPictureInList)) $params->showEventPictureInList = 1;
        if (!isset($params->showEventPictureInSingle)) $params->showEventPictureInSingle = 1;
        if (!isset($params->showEventPictureInRegistration)) $params->showEventPictureInRegistration = 1;
        if (!isset($params->showEventPictureInModule)) $params->showEventPictureInModule = 1;
        
        if (!isset($params->showEventFullDescriptionInList)) $params->showEventFullDescriptionInList = 0;
        if (!isset($params->showEventFullDescriptionInSingle)) $params->showEventFullDescriptionInSingle = 1;
        if (!isset($params->showEventFullDescriptionInRegistration)) $params->showEventFullDescriptionInRegistration = 0;
        if (!isset($params->showEventFullDescriptionInModule)) $params->showEventFullDescriptionInModule = 0;
        
        if (!isset($params->showEventDescriptionSnippetInList)) $params->showEventDescriptionSnippetInList = 1;
        if (!isset($params->showEventDescriptionSnippetInSingle)) $params->showEventDescriptionSnippetInSingle = 0;
        if (!isset($params->showEventDescriptionSnippetInRegistration)) $params->showEventDescriptionSnippetInRegistration = 1;
        if (!isset($params->showEventDescriptionSnippetInModule)) $params->showEventDescriptionSnippetInModule = 1;
        
        if (!isset($params->showEventDateInList)) $params->showEventDateInList = 1;
        if (!isset($params->showEventDateInSingle)) $params->showEventDateInSingle = 1;
        if (!isset($params->showEventDateInRegistration)) $params->showEventDateInRegistration = 1;
        if (!isset($params->showEventDateInModule)) $params->showEventDateInModule = 1;

        if (!isset($params->showEventAddressInList)) $params->showEventAddressInList = 1;
        if (!isset($params->showEventAddressInSingle)) $params->showEventAddressInSingle = 1;
        if (!isset($params->showEventAddressInRegistration)) $params->showEventAddressInRegistration = 1;
        if (!isset($params->showEventAddressInModule)) $params->showEventAddressInModule = 1;

        if (!isset($params->showBigDateBadgeInList)) $params->showBigDateBadgeInList = 0;
        if (!isset($params->showBigDateBadgeInSingle)) $params->showBigDateBadgeInSingle = 0;
        if (!isset($params->showBigDateBadgeInRegistration)) $params->showBigDateBadgeInRegistration = 0;
        if (!isset($params->showBigDateBadgeInModule)) $params->showBigDateBadgeInModule = 0;

        if (!isset($params->showReadMoreInList)) $params->showReadMoreInList = 1;
        if (!isset($params->showReadMoreInRegistration)) $params->showReadMoreInRegistration = 0;
        if (!isset($params->showReadMoreInModule)) $params->showReadMoreInModule = 1;

        if (!isset($params->showTimeInList)) $params->showTimeInList = 1;
        if (!isset($params->showTimeInSingle)) $params->showTimeInSingle = 1;
        if (!isset($params->showTimeInRegistration)) $params->showTimeInRegistration = 1;
        if (!isset($params->showTimeInModule)) $params->showTimeInModule = 1;


        if (!isset($params->redirect_after_add_event)) $params->redirect_after_add_event = '';
        if (!isset($params->allow_only_one_ticket)) $params->allow_only_one_ticket = 0;
        if (!isset($params->localEnvironment)) $params->localEnvironment = 0;
        if (!isset($params->frontend_editing)) $params->frontend_editing = 0;
 
		$this->assign('params', $params);
		return parent::display();
	}
}