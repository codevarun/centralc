<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahTemplateHelperMenubar extends ComDefaultTemplateHelperMenubar
{
 	/**
     * Render the menubar 
     *
     * @param   array   An optional array with configuration options
     * @return  string  Html
     */
    public function render($config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
        	'menubar' => null
        ));

		$html = '';
		$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
		if ($joomlaVersion == '1.6') {
			$html = '<div id="submenu-box"><div class="t"><div class="t"><div class="t"></div></div></div><div class="m"><ul id="submenu">';
		    foreach ($config->menubar->getCommands() as $command) 
		    {
		        if($command->active) {
		            $html .= '<li class="active">';
		        } else {
		        	$html .= '<li>';
		        }

	            $html .= $this->command(array('command' => $command)); 
	            $html .= '</li>';  
	        }
			$html .= '</ul><div class="clr"></div></div><div class="b"><div class="b"><div class="b"></div></div></div></div>';
		} else {
			
	        $html = '<ul id="submenu">';
		    foreach ($config->menubar->getCommands() as $command) 
		    {
		        $html .= '<li>';
	            $html .= $this->command(array('command' => $command)); 
	            $html .= '</li>';  
	        }

	        $html .= '</ul>';
		}     

		return $html;
    }
}


				