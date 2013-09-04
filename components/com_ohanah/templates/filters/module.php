<?php

ini_set('pcre.backtrack_limit', '200000');

class ComOhanahTemplateFilterModule extends ComDefaultTemplateFilterModule
{
}
?>

<?php if (!JComponentHelper::getParams('com_ohanah')->get('disableModuleInjector')) : ?>

	<?php if (!file_exists(JPATH_ROOT.'/plugins/system/advancedmodules/advancedmodules.php') && (substr(JFactory::getApplication()->getTemplate(), 0, 3) != 'ja_') && (substr(JFactory::getApplication()->getTemplate(), 0, 2) != 'jb')) : ?>

		<?php 
		$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
		if ($joomlaVersion == '1.5') { 
			
			jimport('joomla.application.component.helper');

			/**
			 * Module helper class
			 *
			 * @static
			 * @package		Joomla.Framework
			 * @subpackage	Application
			 * @since		1.5
			 */
			class JModuleHelper
			{
				/**
				 * Get module by name (real, eg 'Breadcrumbs' or folder, eg 'mod_breadcrumbs')
				 *
				 * @access	public
				 * @param	string 	$name	The name of the module
				 * @param	string	$title	The title of the module, optional
				 * @return	object	The Module object
				 */
				function &getModule($name, $title = null )
				{
					$result		= null;
					$modules	=& JModuleHelper::_load();
					$total		= count($modules);
					for ($i = 0; $i < $total; $i++)
					{
						// Match the name of the module
						if ($modules[$i]->name == $name)
						{
							// Match the title if we're looking for a specific instance of the module
							if ( ! $title || $modules[$i]->title == $title )
							{
								$result =& $modules[$i];
								break;	// Found it
							}
						}
					}

					// if we didn't find it, and the name is mod_something, create a dummy object
					if (is_null( $result ) && substr( $name, 0, 4 ) == 'mod_')
					{
						$result				= new stdClass;
						$result->id			= 0;
						$result->title		= '';
						$result->module		= $name;
						$result->position	= '';
						$result->content	= '';
						$result->showtitle	= 0;
						$result->control	= '';
						$result->params		= '';
						$result->user		= 0;
					}

					return $result;
				}

				/**
				 * Get modules by position
				 *
				 * @access public
				 * @param string 	$position	The position of the module
				 * @return array	An array of module objects
				 */
				function &getModules($position)
				{
					$position	= strtolower( $position );
					$result		= array();

					$modules =& JModuleHelper::_load();
					
					//Ohanah mapped positions
					$option = KRequest::get('get.option', 'string');
					$view = KRequest::get('get.view', 'string');
					
					$include_injected_position = false;

					if ($option == 'com_ohanah') {
						$ohanah_params = JFactory::getApplication()->getPageParameters('com_ohanah');
					
						if ($view == 'event') {

							if ($ohanah_params->get('singleEventModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleEventModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleEventModulePosition3') == $position)	$include_injected_position = true;
							
						} elseif ($view == 'events') {
			
							if ($ohanah_params->get('listEventsModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('listEventsModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('listEventsModulePosition3') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleVenueModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleVenueModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleVenueModulePosition3') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleCategoryModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleCategoryModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleCategoryModulePosition3') == $position) $include_injected_position = true;

						} elseif ($view == 'registration') {
			
							if ($ohanah_params->get('eventRegistrationModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('eventRegistrationModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('eventRegistrationModulePosition3') == $position) $include_injected_position = true;

						}
					}

					$total = count($modules);
					for ($i = 0; $i < $total; $i++)
					{
						if ($modules[$i]->position == $position) {
							$result[] = &$modules[$i];
						} else {
							if (substr(JFactory::getApplication()->getTemplate(), 0, 4) != 'yoo_') {
								if ($include_injected_position) {
									$module = new stdClass();
									$module->id = 0;
									$module->position = null;
									$module->title = null;
									$module->content = null;
									$module->showtitle = null;
									$module->params = null;
									$module->module = null;
									$module->user = null;
									$result[] = $module;
								}
							}
						}
					}

					if(count($result) == 0) {
						if(JRequest::getBool('tp')) {
							$result[0] = JModuleHelper::getModule( 'mod_'.$position );
							$result[0]->title = $position;
							$result[0]->content = $position;
							$result[0]->position = $position;
						}
					}

					return $result;
				}

				/**
				 * Checks if a module is enabled
				 *
				 * @access	public
				 * @param   string 	$module	The module name
				 * @return	boolean
				 */
				function isEnabled( $module )
				{
					$result = &JModuleHelper::getModule( $module);
					return (!is_null($result));
				}

				function renderModule($module, $attribs = array())
				{
					static $chrome;
					global $mainframe, $option;

					$scope = $mainframe->scope; //record the scope
					$mainframe->scope = $module->module;  //set scope to component name

					// Handle legacy globals if enabled
					if ($mainframe->getCfg('legacy'))
					{
						// Include legacy globals
						global $my, $database, $acl, $mosConfig_absolute_path;

						// Get the task variable for local scope
						$task = JRequest::getString('task');

						// For backwards compatibility extract the config vars as globals
						$registry =& JFactory::getConfig();
						foreach (get_object_vars($registry->toObject()) as $k => $v) {
							$name = 'mosConfig_'.$k;
							$$name = $v;
						}
						$contentConfig = &JComponentHelper::getParams( 'com_content' );
						foreach (get_object_vars($contentConfig->toObject()) as $k => $v)
						{
							$name = 'mosConfig_'.$k;
							$$name = $v;
						}
						$usersConfig = &JComponentHelper::getParams( 'com_users' );
						foreach (get_object_vars($usersConfig->toObject()) as $k => $v)
						{
							$name = 'mosConfig_'.$k;
							$$name = $v;
						}
					}

					// Get module parameters
					$params = new JParameter( $module->params );

					// Get module path
					$module->module = preg_replace('/[^A-Z0-9_\.-]/i', '', $module->module);
					$path = JPATH_BASE.DS.'modules'.DS.$module->module.DS.$module->module.'.php';

					// Load the module
					if (!$module->user && file_exists( $path ) && empty($module->content))
					{
						$lang =& JFactory::getLanguage();
						$lang->load($module->module);

						$content = '';
						ob_start();
						require $path;
						$module->content = ob_get_contents().$content;
						ob_end_clean();
					}

					// Load the module chrome functions
					if (!$chrome) {
						$chrome = array();
					}

					require_once (JPATH_BASE.DS.'templates'.DS.'system'.DS.'html'.DS.'modules.php');
					$chromePath = JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'modules.php';
					if (!isset( $chrome[$chromePath]))
					{
						if (file_exists($chromePath)) {
							require_once ($chromePath);
						}
						$chrome[$chromePath] = true;
					}

					//make sure a style is set
					if(!isset($attribs['style'])) {
						$attribs['style'] = 'none';
					}

					//dynamically add outline style
					if(JRequest::getBool('tp')) {
						$attribs['style'] .= ' outline';
					}

					foreach(explode(' ', $attribs['style']) as $style)
					{
						$chromeMethod = 'modChrome_'.$style;

						// Apply chrome and render module
						if (function_exists($chromeMethod))
						{
							$module->style = $attribs['style'];

							ob_start();
							$chromeMethod($module, $params, $attribs);
							$module->content = ob_get_contents();
							ob_end_clean();
						}
					}

					$mainframe->scope = $scope; //revert the scope

					return $module->content;
				}

				/**
				 * Get the path to a layout for a module
				 *
				 * @static
				 * @param	string	$module	The name of the module
				 * @param	string	$layout	The name of the module layout
				 * @return	string	The path to the module layout
				 * @since	1.5
				 */
				function getLayoutPath($module, $layout = 'default')
				{
					global $mainframe;

					// Build the template and base path for the layout
					$tPath = JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.$module.DS.$layout.'.php';
					$bPath = JPATH_BASE.DS.'modules'.DS.$module.DS.'tmpl'.DS.$layout.'.php';

					// If the template has a layout override use it
					if (file_exists($tPath)) {
						return $tPath;
					} else {
						return $bPath;
					}
				}

				/**
				 * Load published modules
				 *
				 * @access	private
				 * @return	array
				 */
				function &_load()
				{
					global $mainframe, $Itemid;

					static $modules;

					if (isset($modules)) {
						return $modules;
					}

					$user	=& JFactory::getUser();
					$db		=& JFactory::getDBO();

					$aid	= $user->get('aid', 0);

					$modules	= array();

					$wheremenu = isset( $Itemid ) ? ' AND ( mm.menuid = '. (int) $Itemid .' OR mm.menuid = 0 )' : '';

					$query = 'SELECT id, title, module, position, content, showtitle, control, params'
						. ' FROM #__modules AS m'
						. ' LEFT JOIN #__modules_menu AS mm ON mm.moduleid = m.id'
						. ' WHERE m.published = 1'
						. ' AND m.access <= '. (int)$aid
						. ' AND m.client_id = '. (int)$mainframe->getClientId()
						. $wheremenu
						. ' ORDER BY position, ordering';

					$db->setQuery( $query );

					if (null === ($modules = $db->loadObjectList())) {
						JError::raiseWarning( 'SOME_ERROR_CODE', JText::_( 'Error Loading Modules' ) . $db->getErrorMsg());
						return false;
					}

					$total = count($modules);
					for($i = 0; $i < $total; $i++)
					{
						//determine if this is a custom module
						$file					= $modules[$i]->module;
						$custom 				= substr( $file, 0, 4 ) == 'mod_' ?  0 : 1;
						$modules[$i]->user  	= $custom;
						// CHECK: custom module name is given by the title field, otherwise it's just 'om' ??
						$modules[$i]->name		= $custom ? $modules[$i]->title : substr( $file, 4 );
						$modules[$i]->style		= null;
						$modules[$i]->position	= strtolower($modules[$i]->position);
					}

					return $modules;
				}

			}


		} else {
		   	
			abstract class JModuleHelper
			{
				/**
				 * Get modules by position
				 *
				 * This is the method modified by Ohanah to inject the module positions
				 *
				 * @param   string  $position  The position of the module
				 *
				 * @return  array  An array of module objects
				 *
				 * @since   11.1
				 */
				public static function &getModules($position)
				{
					$app		= JFactory::getApplication();
					$position	= strtolower($position);
					$result		= array();

					$modules = JModuleHelper::_load();
					$total = count($modules);

					//Ohanah mapped positions
					$option = KRequest::get('get.option', 'string');
					$view = KRequest::get('get.view', 'string');
					
					$include_injected_position = false;
					
					if ($option == 'com_ohanah') {
						$ohanah_params = JFactory::getApplication()->getPageParameters('com_ohanah');
					
						if ($view == 'event') {

							if ($ohanah_params->get('singleEventModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleEventModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleEventModulePosition3') == $position)	$include_injected_position = true;
							
						} elseif ($view == 'events') {
			
							if ($ohanah_params->get('listEventsModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('listEventsModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('listEventsModulePosition3') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleVenueModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleVenueModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleVenueModulePosition3') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleCategoryModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleCategoryModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('singleCategoryModulePosition3') == $position) $include_injected_position = true;

						} elseif ($view == 'registration') {
			
							if ($ohanah_params->get('eventRegistrationModulePosition1') == $position) $include_injected_position = true;
							if ($ohanah_params->get('eventRegistrationModulePosition2') == $position) $include_injected_position = true;
							if ($ohanah_params->get('eventRegistrationModulePosition3') == $position) $include_injected_position = true;

						}
					}

					for ($i = 0; $i < $total; $i++)
					{
						if ($modules[$i]->position == $position) {
							$result[] = &$modules[$i];
						} else {
							if (substr(JFactory::getApplication()->getTemplate(), 0, 4) != 'yoo_') {
								if ($include_injected_position) {
									$module = new stdClass();
									$module->id = 0;
									$module->position = null;
									$module->title = null;
									$module->content = null;
									$module->showtitle = null;
									$module->params = null;
									$module->module = null;
									$module->user = null;
									$result[] = $module;
								}
							}
						}
					}

					if (count($result) == 0) {
						if (JRequest::getBool('tp') && JComponentHelper::getParams('com_templates')->get('template_positions_display')) {
							$result[0] = JModuleHelper::getModule('mod_'.$position);
							$result[0]->title = $position;
							$result[0]->content = $position;
							$result[0]->position = $position;
						}
					}

					return $result;
				}


				/**
				 * Get module by name (real, eg 'Breadcrumbs' or folder, eg 'mod_breadcrumbs')
				 *
				 * @param   string  $name   The name of the module
				 * @param   string  $title  The title of the module, optional
				 *
				 * @return  object  The Module object
				 *
				 * @since   11.1
				 */
				public static function &getModule($name, $title = null)
				{
					$result		= null;
					$modules	= JModuleHelper::_load();
					$total		= count($modules);

					for ($i = 0; $i < $total; $i++)
					{
						// Match the name of the module
						if ($modules[$i]->name == $name || $modules[$i]->module == $name) {
							// Match the title if we're looking for a specific instance of the module
							if (!$title || $modules[$i]->title == $title) {
								// Found it
								$result = &$modules[$i];
								break;	// Found it
							}
						}
					}

					// If we didn't find it, and the name is mod_something, create a dummy object
					if (is_null($result) && substr($name, 0, 4) == 'mod_') {
						$result				= new stdClass;
						$result->id			= 0;
						$result->title		= '';
						$result->module		= $name;
						$result->position	= '';
						$result->content	= '';
						$result->showtitle	= 0;
						$result->control	= '';
						$result->params		= '';
						$result->user		= 0;
					}

					return $result;
				}



				/**
				 * Checks if a module is enabled
				 *
				 * @param   string  $module  The module name
				 *
				 * @return  boolean
				 *
				 * @since   11.1
				 */
				public static function isEnabled($module)
				{
					$result = JModuleHelper::getModule($module);

					return !is_null($result);
				}

				/**
				 * Render the module.
				 *
				 * @param   object  $module   A module object.
				 * @param   array   $attribs  An array of attributes for the module (probably from the XML).
				 *
				 * @return  string  The HTML content of the module output.
				 *
				 * @since   11.1
				 */
				public static function renderModule($module, $attribs = array())
				{
					static $chrome;

					if (constant('JDEBUG')) {
						JProfiler::getInstance('Application')->mark('beforeRenderModule '.$module->module.' ('.$module->title.')');
					}

					$option = JRequest::getCmd('option');
					$app	= JFactory::getApplication();

					// Record the scope.
					$scope	= $app->scope;

					// Set scope to component name
					$app->scope = $module->module;

					// Get module parameters
					$params = new JRegistry;
					$params->loadString($module->params);

					// Get module path
					$module->module = preg_replace('/[^A-Z0-9_\.-]/i', '', $module->module);
					$path = JPATH_BASE.'/modules/'.$module->module.'/'.$module->module.'.php';

					// Load the module
					if (!$module->user && file_exists($path)) {
						$lang = JFactory::getLanguage();
						// 1.5 or Core then 1.6 3PD
							$lang->load($module->module, JPATH_BASE, null, false, false)
						||	$lang->load($module->module, dirname($path), null, false, false)
						||	$lang->load($module->module, JPATH_BASE, $lang->getDefault(), false, false)
						||	$lang->load($module->module, dirname($path), $lang->getDefault(), false, false);

						$content = '';
						ob_start();
						require $path;
						$module->content = ob_get_contents().$content;
						ob_end_clean();
					}

					// Load the module chrome functions
					if (!$chrome) {
						$chrome = array();
					}

					require_once JPATH_THEMES.'/system/html/modules.php';
					$chromePath = JPATH_THEMES.'/'.$app->getTemplate().'/html/modules.php';

					if (!isset($chrome[$chromePath])) {
						if (file_exists($chromePath)) {
							require_once $chromePath;
						}

						$chrome[$chromePath] = true;
					}

					// Make sure a style is set
					if (!isset($attribs['style'])) {
						$attribs['style'] = 'none';
					}

					// Dynamically add outline style
					if (JRequest::getBool('tp') && JComponentHelper::getParams('com_templates')->get('template_positions_display')) {
						$attribs['style'] .= ' outline';
					}

					foreach(explode(' ', $attribs['style']) as $style)
					{
						$chromeMethod = 'modChrome_'.$style;

						// Apply chrome and render module
						if (function_exists($chromeMethod)) {
							$module->style = $attribs['style'];

							ob_start();
							$chromeMethod($module, $params, $attribs);
							$module->content = ob_get_contents();
							ob_end_clean();
						}
					}

					//revert the scope
					$app->scope = $scope;

					if (constant('JDEBUG')) {
						JProfiler::getInstance('Application')->mark('afterRenderModule '.$module->module.' ('.$module->title.')');
					}

					return $module->content;
				}

				/**
				 * Get the path to a layout for a module
				 *
				 * @param   string  $module  The name of the module
				 * @param   string  $layout  The name of the module layout. If alternative
				 *                           layout, in the form template:filename.
				 *
				 * @return  string  The path to the module layout
				 *
				 * @since   11.1
				 */
				public static function getLayoutPath($module, $layout = 'default')
				{
					$template = JFactory::getApplication()->getTemplate();
					$defaultLayout = $layout;

					if (strpos($layout, ':') !== false ) {
						// Get the template and file name from the string
						$temp = explode(':', $layout);
						$template = ($temp[0] == '_') ? $template : $temp[0];
						$layout = $temp[1];
						$defaultLayout = ($temp[1]) ? $temp[1] : 'default';
					}

					// Build the template and base path for the layout
					$tPath = JPATH_THEMES.'/'.$template.'/html/'.$module.'/'.$layout.'.php';
					$bPath = JPATH_BASE.'/modules/'.$module.'/tmpl/'.$defaultLayout.'.php';

					// If the template has a layout override use it
					if (file_exists($tPath)) {
						return $tPath;
					}
					else {
						return $bPath;
					}
				}

				/**
				 * Load published modules.
				 *
				 * @return  array
				 *
				 * @since   11.1
				 */
				protected static function &_load()
				{
					static $clean;

					if (isset($clean)) {
						return $clean;
					}

					$Itemid 	= JRequest::getInt('Itemid');
					$app		= JFactory::getApplication();
					$user		= JFactory::getUser();
					$groups		= implode(',', $user->getAuthorisedViewLevels());
					$lang 		= JFactory::getLanguage()->getTag();
					$clientId 	= (int) $app->getClientId();

					$cache 		= JFactory::getCache ('com_modules', '');
					$cacheid 	= md5(serialize(array($Itemid, $groups, $clientId, $lang)));

					if (!($clean = $cache->get($cacheid))) {
						$db	= JFactory::getDbo();

						$query = $db->getQuery(true);
						$query->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params, mm.menuid');
						$query->from('#__modules AS m');
						$query->join('LEFT','#__modules_menu AS mm ON mm.moduleid = m.id');
						$query->where('m.published = 1');

						$query->join('LEFT','#__extensions AS e ON e.element = m.module AND e.client_id = m.client_id');
						$query->where('e.enabled = 1');

						$date = JFactory::getDate();
						$now = $date->toMySQL();
						$nullDate = $db->getNullDate();
						$query->where('(m.publish_up = '.$db->Quote($nullDate).' OR m.publish_up <= '.$db->Quote($now).')');
						$query->where('(m.publish_down = '.$db->Quote($nullDate).' OR m.publish_down >= '.$db->Quote($now).')');

						$query->where('m.access IN ('.$groups.')');
						$query->where('m.client_id = '. $clientId);
						$query->where('(mm.menuid = '. (int) $Itemid .' OR mm.menuid <= 0)');

						// Filter by language
						if ($app->isSite() && $app->getLanguageFilter()) {
							$query->where('m.language IN (' . $db->Quote($lang) . ',' . $db->Quote('*') . ')');
						}

						$query->order('m.position, m.ordering');

						// Set the query
						$db->setQuery($query);
						$modules = $db->loadObjectList();
						$clean	= array();

						if ($db->getErrorNum()){
							JError::raiseWarning(500, JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $db->getErrorMsg()));
							return $clean;
						}

						// Apply negative selections and eliminate duplicates
						$negId	= $Itemid ? -(int)$Itemid : false;
						$dupes	= array();
						for ($i = 0, $n = count($modules); $i < $n; $i++)
						{
							$module = &$modules[$i];

							// The module is excluded if there is an explicit prohibition or if
							// the Itemid is missing or zero and the module is in exclude mode.
							$negHit	= ($negId === (int) $module->menuid)
									|| (!$negId && (int)$module->menuid < 0);

							if (isset($dupes[$module->id])) {
								// If this item has been excluded, keep the duplicate flag set,
								// but remove any item from the cleaned array.
								if ($negHit) {
									unset($clean[$module->id]);
								}
								continue;
							}

							$dupes[$module->id] = true;

							// Only accept modules without explicit exclusions.
							if (!$negHit) {
								//determine if this is a custom module
								$file				= $module->module;
								$custom				= substr($file, 0, 4) == 'mod_' ?  0 : 1;
								$module->user		= $custom;
								// Custom module name is given by the title field, otherwise strip off "mod_"
								$module->name		= $custom ? $module->title : substr($file, 4);
								$module->style		= null;
								$module->position	= strtolower($module->position);
								$clean[$module->id]	= $module;
							}
						}

						unset($dupes);

						// Return to simple indexing that matches the query order.
						$clean = array_values($clean);

						$cache->store($clean, $cacheid);
					}

					return $clean;
				}

				/**
				* Module cache helper
				*
				* Caching modes:
				* To be set in XML:
				*    'static'      One cache file for all pages with the same module parameters
				*    'oldstatic'   1.5 definition of module caching, one cache file for all pages
				*                  with the same module id and user aid,
				*    'itemid'      Changes on itemid change, to be called from inside the module:
				*    'safeuri'     Id created from $cacheparams->modeparams array,
				*    'id'          Module sets own cache id's
				*
				* @param   object  $module        Module object
				* @param   object  $moduleparams  Module parameters
				* @param   object  $cacheparams   Module cache parameters - id or url parameters, depending on the module cache mode
				* @param   array   $params        Parameters for given mode - calculated id or an array of safe url parameters and their
				*                                 variable types, for valid values see {@link JFilterInput::clean()}.
				*
				* @return  string
				*
				* @since   11.1
				*
				* @link JFilterInput::clean()
				*/
				public static function moduleCache($module, $moduleparams, $cacheparams)
				{
					if (!isset ($cacheparams->modeparams)) {
						$cacheparams->modeparams = null;
					}

					if (!isset ($cacheparams->cachegroup)) {
						$cacheparams->cachegroup = $module->module;
					}

					$user	= JFactory::getUser();
					$cache	= JFactory::getCache($cacheparams->cachegroup, 'callback');
					$conf	= JFactory::getConfig();

					// Turn cache off for internal callers if parameters are set to off and for all logged in users
					if ($moduleparams->get('owncache', null) === 0  || $conf->get('caching') == 0 || $user->get('id')) {
						$cache->setCaching(false);
					}

					$cache->setLifeTime($moduleparams->get('cache_time', $conf->get('cachetime') * 60));

					$wrkaroundoptions = array (
						'nopathway' 	=> 1,
						'nohead' 		=> 0,
						'nomodules' 	=> 1,
						'modulemode' 	=> 1,
						'mergehead' 	=> 1
					);

					$wrkarounds = true;
					$view_levels = md5(serialize ($user->getAuthorisedViewLevels()));

					switch ($cacheparams->cachemode) {

						case 'id':
							$ret = $cache->get(array($cacheparams->class, $cacheparams->method), $cacheparams->methodparams, $cacheparams->modeparams, $wrkarounds, $wrkaroundoptions);
							break;

						case 'safeuri':
							$secureid=null;
							if (is_array($cacheparams->modeparams)) {
								$uri = JRequest::get();
								$safeuri = new stdClass();
								foreach ($cacheparams->modeparams AS $key => $value) {
									// Use int filter for id/catid to clean out spamy slugs
									if (isset($uri[$key])) {
										$safeuri->$key = JRequest::_cleanVar($uri[$key], 0,$value);
									}
								} }
							$secureid = md5(serialize(array($safeuri, $cacheparams->method, $moduleparams)));
							$ret = $cache->get(array($cacheparams->class, $cacheparams->method), $cacheparams->methodparams, $module->id. $view_levels.$secureid, $wrkarounds, $wrkaroundoptions);
							break;

						case 'static':
							$ret = $cache->get(array($cacheparams->class, $cacheparams->method), $cacheparams->methodparams, $module->module.md5(serialize($cacheparams->methodparams)), $wrkarounds, $wrkaroundoptions);
							break;

						case 'oldstatic':  // provided for backward compatibility, not really usefull
							$ret = $cache->get(array($cacheparams->class, $cacheparams->method), $cacheparams->methodparams, $module->id. $view_levels, $wrkarounds, $wrkaroundoptions);
							break;

						case 'itemid':
						default:
							$ret = $cache->get(array($cacheparams->class, $cacheparams->method), $cacheparams->methodparams, $module->id. $view_levels.JRequest::getVar('Itemid',null,'default','INT'), $wrkarounds, $wrkaroundoptions);
							break;
					}

					return $ret;
				}
			}
		}

		?>

	<?php endif ?>

	<?php if (substr(JFactory::getApplication()->getTemplate(), 0, 4) == 'yoo_') : ?>

		<?php if (file_exists(JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate().'/warp/classes/object.php')) : ?>
			<?php

			/* Warp 5.5 */

			require_once(JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate().'/warp/classes/object.php');
			require_once(JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate().'/warp/classes/helper.php');

			if (JFactory::getApplication()->getTemplate() == 'yoo_bloc' || JFactory::getApplication()->getTemplate() == 'yoo_corona' || JFactory::getApplication()->getTemplate() == 'yoo_pure') {
				class WarpHelperModules extends WarpHelper {

				    /*
						Variable: _document
							Document.
				    */
					var $_document;
					
				    /*
						Variable: _renderer
							Module renderer.
				    */
					var $_renderer;

					/*
						Function: Constructor
							Class Constructor.
					*/
					function __construct() {
						parent::__construct();

						// init vars
						$this->_document =& JFactory::getDocument();
						$this->_renderer =& $this->_document->loadRenderer('module');
					}

					/*
						Function: count
							Retrieve the active module count at a position

						Returns:
							Int
					*/
					function count($position) {
						// init vars
						$document =& JFactory::getDocument();

						$count = $document->countModules($position);
					    $count += count(@JFactory::getDocument()->modules[$position]);

					    return $count;
					}

					/*
						Function: render
							Shortcut to render a position

						Returns:
							String
					*/
					function render($position, $args = array()) {

						// set position in arguments
						$args['position'] = $position;

						return $this->warp->template->render('modules', $args);
					}

					/*
						Function: load
							Retrieve a module objects of a position

						Returns:
							Array
					*/
					function load($position) {

						// init vars
						$modules =& JModuleHelper::getModules($position);

						$injected = @JFactory::getDocument()->modules[$position];
							
						if ($injected) {
							foreach (array_reverse($injected) as $module) {
								$modules[] = $module;
							}
						}

						// set params, force no style
						$params['style'] = 'none';

						// get modules content
						foreach ($modules as $index => $mod)  {		    
							
							$module =& $modules[$index];
							
							// set module params
							$module->parameter = new JParameter($module->params);
				  		
							// set parameter show all children for accordion menu
							if ($module->module == 'mod_mainmenu') {
								if (strpos($module->parameter->get('class_sfx', ''), 'accordion') !== false) {

									if ($module->parameter->get('showAllChildren') == 0) {
										$module->parameter->set('showAllChildren', 1);					
										$module->showAllChildren = 0;
									} else {
										$module->showAllChildren = 1;
									}

									$module->params = $module->parameter->toString();
								}
							}

							$modules[$index]->content = $this->_renderer->render($module, $params);
						}

						return $modules;
					}

				}
			} else {
				class WarpHelperModules extends WarpHelper {

				    /*
						Variable: _document
							Document.
				    */
					var $_document;
					
				    /*
						Variable: _renderer
							Module renderer.
				    */
					var $_renderer;

					/*
						Function: Constructor
							Class Constructor.
					*/
					function __construct() {
						parent::__construct();

						// init vars
						$this->_document = JFactory::getDocument();
						$this->_renderer = $this->_document->loadRenderer('module');
					}
					
					
					/*
						Function: count
							Retrieve the active module count at a position

						Returns:
							Int
					*/
					function count($position) {

						// init vars
						$document =& JFactory::getDocument();

						$count = $document->countModules($position);
					    $count += count(@JFactory::getDocument()->modules[$position]);

						return $count;
					}

					/*
						Function: render
							Shortcut to render a position

						Returns:
							String
					*/
					function render($position, $args = array()) {

						// set position in arguments
						$args['position'] = $position;

						return $this->warp->template->render('modules', $args);
					}

					/*
						Function: load
							Retrieve a module objects of a position

						Returns:
							Array
					*/
					function load($position) {

						// init vars
						$modules =& JModuleHelper::getModules($position);
						
						$injected = @JFactory::getDocument()->modules[$position];
							
						if ($injected) {
							foreach (array_reverse($injected) as $module) {
								$modules[] = $module;
							}
						}

						// set params, force no style
						$params['style'] = 'none';
						
						// get modules content
						foreach ($modules as $index => $module)  {
							
							// set module params
							$module->parameter = new JRegistry($module->params);
							
							// set parameter show all children for accordion menu
							if ($module->module == 'mod_menu') {
								if (strpos($module->parameter->get('class_sfx', ''), 'accordion') !== false) {
									
									if ($module->parameter->get('showAllChildren') == 0) {
										$module->parameter->set('showAllChildren', 1);					
										$module->showAllChildren = 0;
									} else {
										$module->showAllChildren = 1;
									}

									$module->params = $module->parameter->toString();
								}
							}
							
							$modules[$index]->content = $this->_renderer->render($module, $params);
						}

						return $modules;
					}
				}
			}


			

			?>

		<?php elseif (file_exists(JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate().'/warp/classes/helper.php')) : ?>

			<?php
			/* Warp 6 */

			require_once(JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate().'/warp/classes/helper.php');
			$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
			if ($joomlaVersion == '1.5') { 

				class ModulesWarpHelper extends WarpHelper {

				    /*
						Variable: _document
							Document.
				    */
					protected $_document;
					
				    /*
						Variable: _renderer
							Module renderer.
				    */
					protected $_renderer;

					/*
						Function: Constructor
							Class Constructor.
					*/
					public function __construct() {
						parent::__construct();

						// init vars
						$this->_document = JFactory::getDocument();
						$this->_renderer = $this->_document->loadRenderer('module');
					}

					/*
						Function: count
							Retrieve the active module count at a position

						Returns:
							Int
					*/
					public function count($position) {
						return $this->_document->countModules($position);
					}

					/*
						Function: render
							Shortcut to render a position

						Returns:
							String
					*/
					public function render($position, $args = array()) {

						// set position in arguments
						$args['position'] = $position;

						return $this['template']->render('modules', $args);
					}

					/*
						Function: load
							Retrieve a module objects of a position

						Returns:
							Array
					*/
					public function load($position) {

						// init vars
						$modules = JModuleHelper::getModules($position);

						$injected = @JFactory::getDocument()->modules[$position];
							
						if ($injected) {
							foreach (array_reverse($injected) as $module) {
								$modules[] = $module;
							}
						}

						// set params, force no style
						$params['style'] = 'none';

						// get modules content
						foreach ($modules as $module)  {
							$module->parameter = new JParameter($module->params);
							$module->menu = $module->module == 'mod_mainmenu';
							$module->content = $this->_renderer->render($module, $params);
						}

						return $modules;
					}
				}

			} else {

				class ModulesWarpHelper extends WarpHelper {

				    /*
						Variable: _document
							Document.
				    */
					public $_document;
					
				    /*
						Variable: _renderer
							Module renderer.
				    */
					public $_renderer;

					/*
						Function: Constructor
							Class Constructor.
					*/
					public function __construct() {
						parent::__construct();

						// init vars
						$this->_document = JFactory::getDocument();
						$this->_renderer = $this->_document->loadRenderer('module');
					}
					
					
					/*
						Function: count
							Retrieve the active module count at a position

						Returns:
							Int
					*/
					public function count($position) {
					    $count = $this->_document->countModules($position);

					    $count += count(@JFactory::getDocument()->modules[$position]);

						return $count;
					}

					/*
						Function: render
							Shortcut to render a position

						Returns:
							String
					*/
					public function render($position, $args = array()) {

						// set position in arguments
						$args['position'] = $position;

						return $this['template']->render('modules', $args);
					}


					/*
						Function: load
							Retrieve a module objects of a position

						Returns:
							Array
					*/
					public function load($position) {

						// init vars
						$modules = JModuleHelper::getModules($position);
						$injected = @JFactory::getDocument()->modules[$position];
						
						if ($injected) {
							foreach (array_reverse($injected) as $module) {
								$modules[] = $module;
							}
						}
						
						// set params, force no style
						$params['style'] = 'none';
						
						// get modules content
						foreach ($modules as $module)  {
							$module->parameter = new JRegistry($module->params);
							$module->menu = $module->module == 'mod_menu';
							$module->content = $this->_renderer->render($module, $params);
						}

						return $modules;
					}

				}
			}
			
			?>

		<?php endif ?>
	<?php endif ?>

<?php endif ?>