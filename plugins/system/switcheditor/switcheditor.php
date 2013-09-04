<?php
/**
 * @version    $Id$
 * @package    Switch Editor
 * @subpackage plg_system_switcheditor
 * @copyright  Copyright (C) 2012 Anything Digital. All rights reserved.
 * @copyright  Copyright (C) 2008 Netdream - Como,Italy. All rights reserved.
 * @license    GNU/GPLv2
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
jimport('joomla.plugin.plugin');

class plgSystemSwitchEditor extends JPlugin
{
	const EXT = 'switcheditor';
	
	public function onAfterInitialise() {
		// don't execute if we're not firing one of our own tasks
		if (self::EXT != JRequest::getCmd('option')) return;
		// get the module's helper
		$helper = JPATH_ADMINISTRATOR . '/modules/mod_' . self::EXT . '/helper.php';
		if (!JFile::exists($helper)) return;
		require_once $helper;
		// execute the requested task
		$task = JRequest::getWord('task', '');
		switch ($task) {
			case 'switch':
				$set = modSwitchEditorHelper::setEditor();
				jexit();
				break;
			default: return;
		}
	}
}
