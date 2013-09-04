<?php
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */


defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.html.parameter');

class ComOhanahViewHtml extends ComDefaultViewHtml
{
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'template_filters' => array('module'),
        ));

        parent::_initialize($config);
    }

	public function display()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root(1).'/media/com_ohanah/css/screen.css');
		$customCSS = JFactory::getApplication()->getPageParameters('com_ohanah')->get('customCSS'); 
		$document->addStyleDeclaration($customCSS);
		
		if (JFactory::getApplication()->getPageParameters('com_ohanah')->get('showFeedLink', 0)) {
			$document->addHeadLink(JRoute::_('index.php?option=com_ohanah&view=events&format=feed'), 'alternate', 'rel', array('type' => 'application/rss+xml', 'title' => 'Events feed'));	
		}
		
		$this->assign('user', JFactory::getUser());
	
		$params = JComponentHelper::getParams('com_ohanah');
		$this->assign('params', $params);
	
		return parent::display();
	}
}