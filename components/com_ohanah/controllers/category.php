<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahControllerCategory extends ComDefaultControllerDefault 
{
	public function __construct(KConfig $config)
	{		
		$config->request->append(array(
		    'sort' => 'title',
			'direction' => 'asc'
		));
		
		parent::__construct($config);
	}
}