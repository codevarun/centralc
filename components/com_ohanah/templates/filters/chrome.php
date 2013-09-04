<?php
/**
 * @version     $Id: chrome.php 4266 2011-10-08 23:57:41Z johanjanssens $
 * @category	Nooku
 * @package     Nooku_Components
 * @subpackage  Default
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens. All rights reserved.
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

/**
 * Chrome Template Filter
 * 
 * This filter allows to apply module chrome to a template
.*
 * @author      Johan Janssens <johan@nooku.org>
 * @category    Nooku
 * @package     Nooku_Components
 * @subpackage  Default
 */
class ComOhanahTemplateFilterChrome extends ComDefaultTemplateFilterChrome
{  
    public function write(&$text)
    {   
		$name = $this->getIdentifier()->package . '_' . $this->getIdentifier()->name;
		
		//Create a module object
		$module   	       = new KObject();
		$module->id        = uniqid();
		$module->module    = 'mod_'.$name;
		$module->content   = $text;
		$module->position  = $name;

        $anObject = $this->_class;

		$module->params    = 'moduleclass_sfx='. implode(' ', $anObject->toArray());
		$module->showtitle = (bool) $this->_title;
		$module->title     = $this->_title;
		$module->user      = 0;
		
		$text = $this->getService('mod://admin/default.html')->module($module)->attribs($this->_attribs)->styles($this->_styles)->display();
        
        return $this;
    }    
}