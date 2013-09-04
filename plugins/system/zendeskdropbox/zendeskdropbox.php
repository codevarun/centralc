<?php
/**
 * Zendesk Dropbox for Joomla!
 *
 * @version     2.0
 * @author      $Author: Jordan Worner $
 * @copyright   3B Digital Ltd - 2011
 * @package     Zendesk Dropbox
 * @license     GNU General Public License, see http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');
jimport( 'joomla.html.parameter' );

/**
 * Zendesk Dropbox system plugin
 */
class plgSystemZendeskdropbox extends JPlugin {
        /**
         * Constructor
         *
         * @access      protected
         * @param       object  $subject The object to observe
         * @param       array   $config  An array that holds the plugin configuration
         * @since       1.0
         */
        function plgSystemZendeskdropbox( &$subject, $config ) {
            parent::__construct( $subject, $config );
                
            $this->_plugin = JPluginHelper::getPlugin( 'system', 'zendeskdropbox' );
            $this->_params = new JParameter( $this->_plugin->params );  
        }
        
        /**
         * onAfterRender - triggered after the framework has rendered the application.
         */
        function onAfterRender() {
            $mainframe = &JFactory::getApplication();
            
            // must have a value
            $dropboxid  = trim($this->params->get('dropboxid'   , ''));
            $zendeskurl = trim($this->params->get('zendeskurl'  , ''));
            $tabid      = trim($this->params->get('tabid'       , ''));
            $tmpl       = JRequest::getVar('tmpl', '');
            
            // if the dropboxid, zendesk url or tab id are empty then do not load Dropbox. If the tmpl variable is set to component do not load Dropbox
            if($dropboxid == '' || $zendeskurl == '' || $tabid == '' || strpos($_SERVER["PHP_SELF"], "index.php") === false || $tmpl == 'component') {
                // Don't load Dropbox
                return;
            }
                    
            // other options
            $tabcolor               = $this->params->get('tabcolor'                 , 'black');
            $tabposition            = $this->params->get('tabposition'              , 'Left');
            $application            = $this->params->get('application'              , '');
            $hidetab                = $this->params->get('hidetab'                  , 'false');
            $joomlainfo             = $this->params->get('joomlainfo'               , 0);
            $requestimage           = $this->params->get('requestimage'             , '');
            $requestsubject         = $this->params->get('requestsubject'           , '');
            $requestdescription     = $this->params->get('requestdescription'       , '');
            
            /*
            $language               = $this->params->get('language'                 , '1');
            $tabtag                 = $this->params->get('tabtag'                   , '');
            $tabchat                = $this->params->get('tabchat'                  , '');
            $knowledge              = $this->params->get('knowledge'                , '');
            $custom                 = $this->params->get('custom'                   , '');
            $requesttitle           = $this->params->get('requesttitle'             , '');
            $requestsubjecttitle    = $this->params->get('requestsubjecttitle'      , '');  
            $requestquestiontitle   = $this->params->get('requestquestiontitle'     , '');
            $requestquestion        = $this->params->get('requestquestion'          , '');
            $requestdescriptiontitle= $this->params->get('requestdescriptiontitle'  , '');
            $requestprivacy         = $this->params->get('requestprivacy'           , '');
            $customcss              = $this->params->get('customcss'                , '');
            */
            
            // check the display options
            switch($application) {
                case 'admin':
                    // if the page is being viewed in the site do not load
                    if($mainframe->isSite()) return;
                break;
                
                case 'site':
                    // if the page is being viewed in the admin do not load
                    if($mainframe->isAdmin()) return;
                break;
            }
            
            $requester_email_str            = 'null';
            $requester_name_str             = 'null';   
            $request_subject_str            = ($requestsubject!='')?            '"'.urlencode($requestsubject).'"'          : 'null';
            $request_description_str        = ($requestdescription!='')?        '"'.urlencode($requestdescription).'"'      : 'null';
            $request_image_str              = ($requestimage!='')?              '"'.JURI::base().$requestimage.'"'          : 'null';
            
            /*
            $request_title_str              = ($requestsubject!='')?            '"'.urlencode($requestsubject).'"'          : 'null';
            $request_subject_title_str      = ($requestsubjecttitle!='')?       '"'.urlencode($requestsubjecttitle).'"'     : 'null';
            $request_question_title_str     = ($requestquestiontitle!='')?      '"'.urlencode($requestquestiontitle).'"'    : 'null';
            $request_question_str           = ($requestquestion!='')?           '"'.urlencode($requestquestion).'"'         : 'null';
            $request_description_title_str  = ($requestdescriptiontitle!='')?   '"'.urlencode($requestdescriptiontitle).'"' : 'null';
            */
            
            if($joomlainfo) {
                $user                   =& JFactory::getUser();
                if($user->id > 0){
                    $requester_email_str    = '"'.urlencode($user->email).'"';
                    $requester_name_str     = '"'.urlencode($user->name).'"';
                }
            }
    
            $buffer = JResponse::getBody();

            
            // create code to insert
            $dropbox = '<script type="text/javascript" src="//asset0.zendesk.com/external/zenbox/v2.2/zenbox.js"></script>
                            <style type="text/css" media="screen, projection">
                                @import url(//asset0.zendesk.com/external/zenbox/v2.2/zenbox.css);
                            </style>
                            <script type="text/javascript">
                              if (typeof(Zenbox) !== "undefined") {
                                Zenbox.init({
                                  dropboxID:            "'.$dropboxid.'",
                                  url:                  "'.$zendeskurl.'",
                                  tabID:                "'.$tabid.'",
                                  tabColor:             "'.$tabcolor.'",
                                  tabPosition:          "'.$tabposition.'",
                                  tabImageURL:          '.$request_image_str.',
                                  hide_tab:             '.$hidetab.',
                                  requester_name:       '.$requester_name_str.',
                                  requester_email:      '.$requester_email_str.',
                                  request_subject:      '.$request_subject_str.',
                                  request_description:  '.$request_description_str.'
                                });
                              }
                              </script>';
            
            $pos = strrpos($buffer, "</body>");
            
            if($pos > 0)
            {
                // insert code before the end of the body
                $buffer = substr($buffer, 0, $pos).$dropbox.substr($buffer, $pos);
    
                JResponse::setBody($buffer);
            }
            
            return true;
        }
    
}