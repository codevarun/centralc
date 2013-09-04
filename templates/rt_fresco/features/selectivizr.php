<?php
/**
 * @package     gantry
 * @subpackage  features
 * @version		1.1 July 13, 2012
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');
/**
 * @package     gantry
 * @subpackage  features
 */
class GantryFeatureSelectivizr extends GantryFeature {
    var $_feature_name = 'selectivizr';
	
	function isInPosition($position) {
        return false;
    }
	function isOrderable(){
		return false;
	}
	
	function init() {
		global $gantry;
		
		if ($gantry->browser->name == 'ie' && $gantry->browser->shortversion <= '8') {
			if ($this->get('enabled')) {
				$gantry->addScript('selectivizr-min.js');
			}
		}
	}
	
}