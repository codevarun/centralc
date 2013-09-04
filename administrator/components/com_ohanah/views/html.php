<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined('_JEXEC') or die('Restricted access');

class ComOhanahViewHtml extends ComDefaultViewHtml
{
    public function __construct(KConfig $config)
    {
        parent::__construct($config);
        
		JFactory::getDocument()->addStyleSheet(JURI::root(1).'/media/com_ohanah/v2/ohanah_admin.css');

		$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
		if ($joomlaVersion == '1.5') { 
			JFactory::getDocument()->addStyleSheet(JURI::root(1).'/media/com_ohanah/v2/ohanah_admin_15.css');
		}

		if (!JFactory::getApplication()->get('jquery'))  {
			JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery.min.js');
			JFactory::getApplication()->set('jquery', true); 
		}

		JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/slideup-system-message.js');
		JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/checkbox-toolbar.js');

		JFactory::getDocument()->addStyleSheet(JURI::root(1).'/media/com_default/css/form.css');

		if (KInflector::isSingular($this->getName())) {
			JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery.maskedinput-1.3.min.js');
			JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery-ui.custom.min.js');
			JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery.form.js');
			JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/si.files.js');
			JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery.ohanah.stickytoolbar.js');
		}

    }
}