<?php
/**
 * @version		$Id: grid.php 3522 2011-06-20 01:51:50Z johanjanssens $
 * @category	Koowa
 * @package		Koowa_Template
 * @subpackage	Helper
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link     	http://www.nooku.org
 */

/**
 * Template Grid Helper
 *
 * @author		Johan Janssens <johan@nooku.org>
 * @category	Koowa
 * @package		Koowa_Template
 * @subpackage	Helper
 * @see 		http://ajaxpatterns.org/Data_Grid
 */
class ComOhanahTemplateHelperGrid extends KTemplateHelperGrid
{
	public function enable($config = array())
	{
		$config = new KConfig($config);
		$config->append(array(
			'row'  		=> null,
		    'field'		=> 'enabled'
		))->append(array(
		    'data'		=> array($config->field => $config->row->{$config->field})
		));

		$img    = $config->row->{$config->field} ? 'icon-arrow.png' : 'icon-x.png';
		$alt 	= $config->row->{$config->field} ? JText::_( 'OHANAH_PUBLISHED' ) : JText::_( 'OHANAH_UNPUBLISHED' );
		$text 	= $config->row->{$config->field} ? JText::_( 'OHANAH_UNPUBLISH_ITEM' ) : JText::_( 'OHANAH_PUBLISH_ITEM' );
		
	    $config->data->{$config->field} = $config->row->{$config->field} ? 0 : 1;
	    $data = str_replace('"', '&quot;', $config->data);

		$html = '<img class="list_status_icon" src="media://com_ohanah/v2/ohanah_images/'. $img .'" border="0" alt="'. $alt .'" data-action="edit" data-data="'.$data.'" title='.$text.' />';

		return $html;
	}

	public function search($config = array())
	{
	    $config = new KConfig($config);
		$config->append(array(
			'search' => null
		));
	    
	    $html = '<input name="search" id="search" value="'.$this->getTemplate()->getView()->escape($config->search).'" />';
	
	    return $html;
	}

	public function feature($config = array())
	{
		$config = new KConfig($config);
		$config->append(array(
			'row'  		=> null,
		    'field'		=> 'featured'
		))->append(array(
		    'data'		=> array($config->field => $config->row->{$config->field})
		));

		$img    = $config->row->{$config->field} ? 'icon-featured.png' : 'icon-unfeatured.png';
		$alt 	= $config->row->{$config->field} ? JText::_( 'OHANAH_FEATURED' ) : JText::_( 'OHANAH_NORMAL' );
		$text 	= $config->row->{$config->field} ? JText::_( 'OHANAH_REMOVE_FEATURING' ) : JText::_( 'OHANAH_FEATURE_ITEM' );
		
	    $config->data->{$config->field} = $config->row->{$config->field} ? 0 : 1;
	    $data = str_replace('"', '&quot;', $config->data);

		$html = '<img  class="list_status_icon" src="media://com_ohanah/v2/ohanah_images/'. $img .'" border="0" alt="'. $alt .'" data-action="edit" data-data="'.$data.'" title='.$text.' />';

		return $html;
	}

	public function paid($config = array())
	{
		$config = new KConfig($config);
		$config->append(array(
			'row'  		=> null,
		    'field'		=> 'paid'
		))->append(array(
		    'data'		=> array($config->field => $config->row->{$config->field})
		));

		$img    = $config->row->{$config->field} ? 'icon-arrow.png' : 'icon-x.png';
		$alt 	= $config->row->{$config->field} ? JText::_( 'OHANAH_PAID' ) : JText::_( 'OHANAH_NOT_PAID' );
		$text 	= $config->row->{$config->field} ? JText::_( 'OHANAH_SET_AS_NOT_PAID' ) : JText::_( 'OHANAH_SET_AS_PAID' );
		
	    $config->data->{$config->field} = $config->row->{$config->field} ? 0 : 1;
	    $data = str_replace('"', '&quot;', $config->data);

		$html = '<img class="list_status_icon" src="media://com_ohanah/v2/ohanah_images/'. $img .'" border="0" alt="'. $alt .'" data-action="edit" data-data="'.$data.'" title='.$text.' />';

		return $html;
	}	

	public function checked_in($config = array())
	{
		$config = new KConfig($config);
		$config->append(array(
			'row'  		=> null,
		    'field'		=> 'checked_in'
		))->append(array(
		    'data'		=> array($config->field => $config->row->{$config->field})
		));

		$img    = $config->row->{$config->field} ? 'icon-arrow.png' : 'icon-x.png';
		$alt 	= $config->row->{$config->field} ? JText::_( 'OHANAH_SET_AS_CHECKED_IN' ) : JText::_( 'OHANAH_NOT_CHECKED_IN' );
		$text 	= $config->row->{$config->field} ? JText::_( 'OHANAH_SET_AS_NOT_CHECKED_IN' ) : JText::_( 'OHANAH_CHECKED_IN' );
		
	    $config->data->{$config->field} = $config->row->{$config->field} ? 0 : 1;
	    $data = str_replace('"', '&quot;', $config->data);

		$html = '<img class="list_status_icon" src="media://com_ohanah/v2/ohanah_images/'. $img .'" border="0" alt="'. $alt .'" data-action="edit" data-data="'.$data.'" title='.$text.' />';

		return $html;
	}

}