<?php
/**
 * @version    $Id$
 * @package    Switch Editor
 * @copyright  Copyright (C) 2012 Anything Digital. All rights reserved.
 * @copyright  Copyright (C) 2008 Netdream - Como,Italy. All rights reserved.
 * @license    GNU/GPLv2
 */

// no direct access
defined('_JEXEC') or die;

class pkg_SwitchEditorInstallerScript
{
	public function postflight($type, $parent) {
		// get the database object
		$db = JFactory::getDbo();
		// update the plugin
		$this->_fireQuery($db->getQuery(true)
			->update('#__extensions')
			->set($db->nameQuote('enabled') . '=1')
			->where($db->nameQuote('element') . '=' . $db->Quote('switcheditor'))
			->where($db->nameQuote('type') . '=' . $db->Quote('plugin'))
		);
		// get the module id
		$db->setQuery((string) $db->getQuery(true)
			->select($db->nameQuote('id'))
			->from('#__modules')
			->where($db->nameQuote('module') . '=' . $db->Quote('mod_switcheditor'))
			->where($db->nameQuote('client_id') . '=1')
		);
		$id = $db->loadResult();
		if ($id) {
			$id = (int) $id;
			// update the module position & publication
			$this->_fireQuery($db->getQuery(true)
				->update('#__modules')
				->set($db->nameQuote('published') . '=1')
				->set($db->nameQuote('position') . '=' . $db->Quote('status'))
				->where($db->nameQuote('id') . '=' . $id)
			);
			// remove any previous module menu entries
			$this->_fireQuery($db->getQuery(true)->delete('#__modules_menu')->where($db->nameQuote('moduleid') . '=' . $id));
			// insert a new module menu entry
			$this->_fireQuery($db->getQuery(true)->insert('#__modules_menu')->values($id . ', 0'));
		}
	}
	
	private function _fireQuery($query) {
		$db = JFactory::getDbo();
		$db->setQuery((string) $query);
		return $db->query();
	}
}
