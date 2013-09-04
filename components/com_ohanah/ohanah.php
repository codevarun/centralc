<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

// Check if Koowa is active 
if(!defined('KOOWA')) 
{ 
	JError::raiseWarning(0, JText::_("Koowa wasn't found. Please install the Koowa plugin and enable it.")); 
    return; 
} 

KService::setAlias('com://site/ohanah.controller.attachment', 'com://admin/ohanah.controller.attachment');
KService::setAlias('com://site/ohanah.controller.common', 'com://admin/ohanah.controller.common');
KService::setAlias('com://site/ohanah.database.table.categories', 'com://admin/ohanah.database.table.categories');
KService::setAlias('com://site/ohanah.database.table.events', 'com://admin/ohanah.database.table.events');
KService::setAlias('com://site/ohanah.database.table.registrations', 'com://admin/ohanah.database.table.registrations');
KService::setAlias('com://site/ohanah.database.table.venues', 'com://admin/ohanah.database.table.venues');
KService::setAlias('com://site/ohanah.database.row.event', 'com://admin/ohanah.database.row.event');
KService::setAlias('com://site/ohanah.database.row.registration', 'com://admin/ohanah.database.row.registration');
KService::setAlias('com://site/ohanah.database.behavior.sluggable', 'com://admin/ohanah.database.behavior.sluggable');
KService::setAlias('com://site/ohanah.filter.slug', 'com://admin/ohanah.filter.slug');

if (KRequest::get('get.view', 'string') == '') KRequest::set('get.view', 'events');

try {
	echo KService::get('com://site/ohanah.dispatcher')->dispatch();
} catch (Exception $e) { 
	JError::raiseWarning(0, $e->getMessage()."<br/><br/>".nl2br($e->getTraceAsString()));
}