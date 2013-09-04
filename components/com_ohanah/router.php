<?php
/**
 * @version		$Id: router.php 133 2010-09-08 13:43:26Z copesc $
 * @package		Profiles
 * @copyright	Copyright (C) 2009 - 2010 Nooku. All rights reserved.
 * @license 	GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link     	http://www.nooku.org
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * List views are people/, offices/, departments/
 * Item views are people/id-firstname_lastname, offices/officeslug, departments/departmentslug
 */
function ohanahBuildRoute(&$query)
{	
 	$segments = array();

 	if (@$query['view'] == 'event')
 	{
		if (@$query['layout'] == 'default' || @$query['layout'] == '')
		{
		 	if(array_key_exists('id', $query))
		 	{
		 		$segments[] = KService::get('com://site/ohanah.model.events')->id($query['id'])->getItem()->slug;

		  		unset($query['id']);
		 		unset($query['view']);
		 		unset($query['layout']);
		 	}
		}
 	}
 	if (@$query['view'] == 'registration')
 	{
		if (@$query['layout'] == 'default' || @$query['layout'] == '')
		{
		 	if(array_key_exists('ohanah_event_id', $query))
		 	{
		 		$segments[] = KService::get('com://site/ohanah.model.events')->id($query['ohanah_event_id'])->getItem()->slug;
		 		$segments[] = 'registration';

		  		unset($query['id']);
		 		unset($query['view']);
		 		unset($query['layout']);
		 		unset($query['ohanah_event_id']);
		 	}
		}
 	}
 
 	return $segments;
}

/**
 *	$segments array
 * es. { [0]=>  string(10) "cena-in-pizzeria" } 
 *
 */
function ohanahParseRoute($segments)
{
	$item = JSite::getMenu()->getActive();

 	//We are using the alias, circonvent the auto-segment decoding
 	$segments = str_replace(':', '-', $segments);
 
 	if(count($segments) > 0)
 	{
 		$vars['view'] = 'event';
 		$event = (reset(KService::get('com://site/ohanah.model.events')->set('slug', $segments[0])->getList()->getData()));
 		$vars['id'] = $event['id'];

		if (isset($segments[1]))
		{
			if ($segments[1] == 'registration') { 
				$vars['view'] = 'registration';
				$vars['layout'] = 'default';
				$vars['ohanah_event_id'] = $event['id'];
				unset($vars['id']);
			}
			else {		
				$vars['layout'] = $segments[1];	
			}
		}
		else
		{	
			$vars['layout'] = 'default';
	 	}
 	}
 	
 	return $vars;
}
