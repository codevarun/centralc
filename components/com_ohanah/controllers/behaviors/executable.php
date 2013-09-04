<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahControllerBehaviorExecutable extends ComDefaultControllerBehaviorExecutable
{
	protected function _authorize()
	{
		return true;
	}

    public function canAdd()
    {
		return $this->_authorize();
	}

	public function canEdit()
    {
		return $this->_authorize();
	}

	public function canDelete()
    {
		return $this->_authorize();
	}

	/**
	 * Check the token to prevent CSRF exploits
	 *
	 * @param   object  The command context
	 * @return  boolean Returns FALSE if the check failed. Otherwise TRUE.
	 */
    protected function _checkToken(KCommandContext $context)
    {
        //Check the token
        if($context->caller->isDispatched())
        {  
            $method = KRequest::method();
            
            //Only check the token for PUT, DELETE and POST requests (AND if the view is not 'ipn')
            if(($method != KHttpRequest::GET) && ($method != KHttpRequest::OPTIONS) && (KRequest::get('get.view', 'string') != 'ipn')) 
            {     
                if( KRequest::token() !== JUtility::getToken()) {     
                    return false;
                }
            }
        }
        
        return true;
    }
}