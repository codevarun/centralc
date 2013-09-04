<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!function_exists('humanize'))
{
	function humanize ($word)
	{
		return ucwords(strtolower(str_replace("_", " ", $word)));
	}
}

// To allow multiple components to be installed in a single go, crucial to have this check
if(!function_exists('com_install'))
{
	/**
	 * This function is required by JInstallerComponent in order to run this script
	 *
	 * @return	boolean	true
	 */
	function com_install()
	{
		static $installable;
		
		if(isset($installable)) return $installable;
		
		$db = JFactory::getDBO();
		//Run check on the minimum required server specs. Will roll back install if any check fails
		foreach(array(
			class_exists('mysqli') => "Your server doesn't have MySQLi.",
			in_array('curl', get_loaded_extensions()) => "Your server doesn't have cURL, a requirement to run Ohanah. Please enable it and retry.",
			version_compare(phpversion(), '5.2', '>=') => "Your PHP version is older than 5.2.",
			version_compare($db->getVersion(), '5.0.41', '>=') => "Your MySQL version is older than 5.0.41."
			
		) as $succeed => $fail) {
			if(!$succeed) {
				JError::raiseWarning(0, $fail);
				return $installable = false;
			}
		}
				
		return $installable = true;
	}
}


if (extension_loaded('suhosin'))
{
	//Attempt setting the whitelist value
	@ini_set('suhosin.executor.include.whitelist', 'tmpl://, file://');

	//Checking if the whitelist is ok
	if(!@ini_get('suhosin.executor.include.whitelist') || strpos(@ini_get('suhosin.executor.include.whitelist'), 'tmpl://') === false)
	{
		$this->parent->abort(sprintf(JText::_('The install failed because your server got Suhosin loaded but not configured correctly. Please follow <a href="%s" target="_blank">this</a> tutorial before you reinstall.'), 'https://nooku.assembla.com/wiki/show/nooku-framework/Known_Issues'));
		return false;
	}
}

if (!class_exists('mysqli'))
{
	$this->parent->abort(JText::_("We're sorry but your server isn't configured with the MySQLi database driver. Please contact your host and ask them to enable MySQLi for your server."));
	return false;
}


//Do not execute the rest of the custom install script if the com_install check fails
if(!com_install()) return;

$this->name = strtolower($this->name);
$extname = 'com_' . $this->name;

//Delete cache folder if it exists
$cache = JPATH_ROOT.'/cache/'.$extname.'/';
if(JFolder::exists($cache)) JFolder::delete($cache);

jimport('joomla.installer.installer');

// Load language file
$lang = &JFactory::getLanguage();
$lang->load('com_ohanah');

$db = & JFactory::getDBO();
$status = new JObject();
$status->modules = array();
$src = $this->parent->getPath('source');
$database = JFactory::getDBO();

$joomlaVersion = JVersion::isCompatible('1.6.0') ? '>1.5' : '1.5';


//Install Nooku
$source	= $this->parent->getPath('source').DS.'nooku'; 
if (JFolder::exists($source)) {

	if ($joomlaVersion == '>1.5')
	{
		// Prevent the plugin row to be inserted more than once
		$query = "SELECT COUNT(*) FROM `#__extensions` WHERE type = 'plugin' AND folder = 'system' AND element = 'koowa'";
		$database->setQuery($query);
		if(!$database->loadResult())
		{
			$database->setQuery("INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`, `enabled`, `access`) VALUES (NULL, 'System - Koowa', 'plugin', 'koowa', 'system', 1, 1);");
			if (!$database->query()) {
				// Install failed, roll back changes
				$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$database->stderr(true));
				return false;
			}
		}

		// Disable com_extensions from the admin menu until its realy for primetime
		$query = "UPDATE `#__extensions` SET `enabled` = '0' WHERE type = 'component' AND element = 'com_extensions'";
		$database->setQuery($query);
		$database->query();
			
		// Copy over the folders for the fw, com_default, mod_default
		foreach ($this->manifest->framework->folder as $folder)
		{
			$from = isset($folder['src']) ? $folder['src'] : $folder;
			JFolder::copy($source.$from, JPATH_ROOT.$folder, false, true);
		}

		foreach ($this->manifest->framework->file as $file)
		{
			$folder = JPATH_ROOT.dirname($file);
			if(!JFolder::exists($folder)) JFolder::create($folder);
			
			JFile::copy($source.$file, JPATH_ROOT.$file);
		}

		//Fix installation of Koowa on some hostings
		$query = "UPDATE `#__extensions` SET `access` = '1' WHERE type = 'plugin' AND element = 'koowa'";
		$database->setQuery($query);
		$database->query();

	} else { //1.5
		$query = "SELECT COUNT(*) FROM `#__plugins` WHERE element = 'koowa' AND folder = 'system'";
		$database->setQuery($query);
		if(!$database->loadResult())
		{
			// Insert in database
			$plugin = JTable::getInstance('plugin');
			$plugin->name = 'System - Koowa';
			$plugin->folder = 'system';
			$plugin->element = 'koowa';
			$plugin->published = 1;
			if (!$plugin->store()) {
				// Install failed, roll back changes
				$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$database->stderr(true));
				return false;
			}
		}

		$framework = $this->manifest->framework;
		$framework = $framework[0];
		$folders = $framework->folder;
		$files = $framework->file;

		// Copy over the folders for the fw, com_default, mod_default
		foreach ($folders as $folder)
		{
			$from = $folder->attributes('src') ? $folder->attributes('src') : $folder->get('_data');
			JFolder::copy($source.$from, JPATH_ROOT.$folder->get('_data'), false, true);
		}

		foreach ($files as $file)
		{
			$filedir = $file->attributes('src');

			$folder = JPATH_ROOT.dirname($filedir);
			if(!JFolder::exists($folder)) JFolder::create($folder);
			
			$from = $file->attributes('src') ? $file->attributes('src') : $file->get('_data');
			JFile::copy($source.$from, JPATH_ROOT.$file->get('_data'));
		}
	}
} //END install Nooku


if ($joomlaVersion == '>1.5')
{
	//Modules
	
	$modules = $this->manifest->modules;
	if (is_a($modules, 'JXMLElement') && count($modules)) 
	{
		foreach ($modules->module as $module) 
		{
			$mname = $module->getAttribute('module');
			$client = $module->getAttribute('client');
		
			if(is_null($client)) 
				$client = 'site';
			
			if ($client=='administrator')
				$mypath = $src.'/administrator/modules/'.$mname;
			else
				$mypath = $src.'/modules/'.$mname;
				
			if (JFolder::exists($mypath)) {
				$installer = new JInstaller;
				$result = $installer->install($mypath);
				$status->modules[] = array('name' => $mname, 'client' => $client, 'result' => $result);
			}
		}
	}
	
	$query = "SELECT extension_id FROM #__extensions WHERE element='com_ohanah'";
	$db->setQuery($query);
	$component_id = $db->loadResult();
	
	if ($component_id) {
		$query = "UPDATE #__menu SET menutype='menu', component_id=".$component_id." WHERE path='ohanah' OR path='ohanah/events' OR path='ohanah/categories'";
		$db->setQuery($query);
		$db->query();	
	}
}
else
{
	//Modules
	$modules = $this->manifest->getElementByPath('modules');
	if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) 
	{
        foreach ($modules->children() as $module) 
		{
            $mname = $module->attributes('module');
            $client = $module->attributes('client');
            
            if(is_null($client)) 
            	$client = 'site';
            
			if ($client=='administrator') 
				$path = $src.'/administrator/modules/'.$mname;
			else
				$path = $src.'/modules/'.$mname;
				
			if (JFolder::exists($path)) {
	            $installer = new JInstaller;
	            $result = $installer->install($path);
	            $status->modules[] = array('name' => $mname, 'client' => $client, 'result' => $result);	
			}
        }
	}
}
?>

<?php
if(!function_exists('ohstats'))
{
	function ohstats($event, $properties=array()) 
	{
	    $params = array('event' => $event, 'properties' => $properties);
	    $params['properties']['token'] = '41aca88360ef6164533944b503484055';
	    $params['properties']['ip'] = $_SERVER['REMOTE_ADDR'];
	    $params['properties']['ohanah_version'] = '2.0.20';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://api.mixpanel.com/track/?data=' . base64_encode(json_encode($params)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		curl_close ($ch);
	}
}

if(!function_exists('ohanah_version'))
{
	function ohanah_version()
	{
		$db = & JFactory::getDBO();
		$joomlaVersion = JVersion::isCompatible('1.6.0') ? '>1.5' : '1.5';

		//Find out Ohanah version
		if ($joomlaVersion == '1.5') { 
			$table =& JTable::getInstance('component');
			$table->loadByOption('com_ohanah');

			jimport('joomla.filesystem.folder');

			$db->setQuery('SELECT * FROM #__components WHERE admin_menu_link=\'option=com_ohanah\'');

			// Get the component base directory
			$adminDir = JPATH_ADMINISTRATOR .DS. 'components';
			$siteDir = JPATH_SITE .DS. 'components';

			$row = $db->loadObject();

			// Get the component folder and list of xml files in folder 
			$folder = $adminDir.DS.$row->option;
			if (JFolder::exists($folder)) {
				$xmlFilesInDir = JFolder::files($folder, '.xml$');
			} else {
				$folder = $siteDir.DS.$row->option;
				if (JFolder::exists($folder)) {
					$xmlFilesInDir = JFolder::files($folder, '.xml$');
				} else {
					$xmlFilesInDir = null;
				}
			}
			if (count($xmlFilesInDir)) {
				foreach ($xmlFilesInDir as $xmlfile) {
					if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
						foreach($data as $key => $value) {
							$row->$key = $value;
						}
					}
					$row->jname = JString::strtolower(str_replace(" ", "_", $row->name));
				}
			}
			$version = $row->version;

		} else {
			$table =& JTable::getInstance('extension');
			$db->setQuery('SELECT extension_id FROM #__extensions WHERE type="component" AND element="com_ohanah"');
			$table->load($db->loadResult());
			$version = json_decode($table->manifest_cache)->version;
		}

		if (!$version) { //Ohanah was uninstalled
			
			if (in_array($db->getPrefix().'ohanah_stories', $db->getTableList())) { 
				$version = '1.0.20';
			} elseif (in_array($db->getPrefix().'ohanah_attachments', $db->getTableList())) { 
				$version = '2.0.0';
			}
		}

		return $version;
	}
}


if(!function_exists('executeOnce')) {
		
	function executeOnce() {
			
		static $fnCount = 0;
		if($fnCount) return;
		$fnCount++;

		$db = & JFactory::getDBO();

		//Set modules position if first install
		$query = 'SELECT COUNT(*) FROM #__modules WHERE position="ohanah-single-event-1" OR position="ohanah-single-event-2" OR position="ohanah-single-event-3"';
		$db->setQuery($query);
		$results = $db->loadResult();

		if (!$results) 
		{
			$query = "UPDATE #__modules SET position='ohanah-single-event-1' WHERE module='mod_ohanahattendees'";
			$db->setQuery($query);
			$db->query();
			$query = "UPDATE #__modules SET position='ohanah-single-event-2' WHERE module='mod_ohanahrelatedinfo' OR module='mod_ohanaheventmap'";
			$db->setQuery($query);
			$db->query();
			$query = "UPDATE #__modules SET position='ohanah-single-event-3' WHERE module='mod_ohanaheventimages'";
			$db->setQuery($query);
			$db->query();			
		}

		//Set modules position if first install
		$query = 'SELECT COUNT(*) FROM #__modules WHERE position="ohanah-list-events-1" OR position="ohanah-list-events-2" OR position="ohanah-list-events-3"';
		$db->setQuery($query);
		$results = $db->loadResult();

		if (!$results) 
		{
			$query = "UPDATE #__modules SET position='ohanah-list-events-1' WHERE module='mod_ohanahcalendar'";
			$db->setQuery($query);
			$db->query();
			$query = "UPDATE #__modules SET position='ohanah-list-events-2' WHERE module='mod_ohanaheventsmap'";
			$db->setQuery($query);
			$db->query();
			$query = "UPDATE #__modules SET position='ohanah-list-events-3' WHERE module='mod_ohanahsearch'";
			$db->setQuery($query);
			$db->query();
		}


		if (in_array($db->getPrefix().'ohanah_events', $db->getTableList())) { 
			// I am upgrading

			$version = ohanah_version();

			if ($version) {
				
				if (version_compare($version, '1.0.30', '>') && version_compare($version, '2.0.0', '<')) {	 //use 1.0.30 as we'll never get to that number with priority/security 1.0.x releases
					//upgrading from a 2.0 beta

					$events_columns = $db->getTableFields('#__ohanah_events');
					$events_columns = reset($events_columns);

					if (!isset($events_columns['custom_payment_url'])) {
						$query = "ALTER TABLE #__ohanah_events ADD COLUMN custom_payment_url varchar(300) DEFAULT ''";
						$db->setQuery($query);
						$db->query();
					}
					if (!isset($events_columns['custom_registration_url'])) {
						$query = "ALTER TABLE #__ohanah_events ADD COLUMN custom_registration_url varchar(300) DEFAULT ''";
						$db->setQuery($query);
						$db->query();
					}
					if (!isset($events_columns['payment_gateway'])) {
						$query = "ALTER TABLE #__ohanah_events ADD COLUMN payment_gateway varchar(20) DEFAULT ''";
						$db->setQuery($query);
						$db->query();
					}
					if (!isset($events_columns['registration_system'])) {
						$query = "ALTER TABLE #__ohanah_events ADD COLUMN registration_system varchar(20) DEFAULT ''";
						$db->setQuery($query);
						$db->query();
					}
				} else if (version_compare($version, '1.0.30', '<=')) {
					//Handle migration from version 1.0

					//Move images from old directory to new one
						$beforePath = JPATH_ROOT.'/media/com_ohanah/events_images';
						$afterPath = JPATH_ROOT.'/media/com_ohanah/attachments';
					 	if(JFolder::exists($beforePath)) JFolder::move($beforePath, $afterPath);

					 	$beforePath = JPATH_ROOT.'/media/com_ohanah/events_thumbs';
						$afterPath = JPATH_ROOT.'/media/com_ohanah/attachments_thumbs';
					 	if(JFolder::exists($beforePath)) JFolder::move($beforePath, $afterPath);

					 	$beforePath = JPATH_ROOT.'/media/com_ohanah/venues_images/';
						$afterPath = JPATH_ROOT.'/media/com_ohanah/attachments/';
						$files = JFolder::files($beforePath);

						if ($files) foreach($files as $file) {
							JFile::move($beforePath.$file, $afterPath.$file);
						}

					 	$beforePath = JPATH_ROOT.'/media/com_ohanah/venues_thumbs/';
						$afterPath = JPATH_ROOT.'/media/com_ohanah/attachments_thumbs/';
						$files = JFolder::files($beforePath);

						if ($files) foreach($files as $file) {
							JFile::move($beforePath.$file, $afterPath.$file);
						}

					//Delete unused tables
						$db->setQuery("DROP TABLE IF EXISTS #__ohanah_stories");
						$db->query();
						$db->setQuery("DROP TABLE IF EXISTS #__ohanah_comments");
						$db->query();
						$db->setQuery("DROP TABLE IF EXISTS #__ohanah_extensions");
						$db->query();
					//Create new tables
						$query = 	"CREATE TABLE IF NOT EXISTS `#__ohanah_attachments` ( ".
									"`ohanah_attachment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,".
									"`name` varchar(300) NOT NULL,".
									"`target_id` int(11) NOT NULL,".
									"`target_type` varchar(20) NOT NULL,".
									"PRIMARY KEY (`ohanah_attachment_id`)".
									") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
						$db->setQuery($query);
						$db->query();
						
						$query =  "CREATE TABLE IF NOT EXISTS `#__ohanah_registrations` (".
								  "`ohanah_registration_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,".
								  "`ohanah_event_id` bigint(20) unsigned NOT NULL,".
								  "`name` varchar(255) NOT NULL,".
								  "`email` varchar(255) NOT NULL,".
								  "`number_of_tickets` int(11) NOT NULL,".
								  "`text` text NOT NULL,".
								  "`notes` text NOT NULL,".
								  "`created_by` int(11) unsigned NOT NULL,".
								  "`created_on` datetime NOT NULL,".
								  "`paid` TINYINT( 1 ) NOT NULL,".
								  "`checked_in` TINYINT( 1 ) NOT NULL,".
								  "`params` mediumtext NOT NULL,".
								  "PRIMARY KEY (`ohanah_registration_id`)".
								") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
						$db->setQuery($query);
						$db->query();

					//Modify existing tables
						//modifico __ohanah_events
							//prendo le immagini legate in image_1, image_2, image_3, image_4, image_5 e creo entries in #__ohanah_attachments
								$db->setQuery('SELECT * FROM '.$db->getPrefix().'ohanah_events');
								foreach ($db->loadObjectList() as $event) {

									if ($event->header) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$event->header.'", '.$event->ohanah_event_id.', "event")');
										$db->query();
									}
									if ($event->image_1) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$event->image_1.'", '.$event->ohanah_event_id.', "event")');
										$db->query();
									}
									if ($event->image_2) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$event->image_2.'", '.$event->ohanah_event_id.', "event")');
										$db->query();
									}
									if ($event->image_3) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$event->image_3.'", '.$event->ohanah_event_id.', "event")');
										$db->query();
									}
									if ($event->image_4) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$event->image_4.'", '.$event->ohanah_event_id.', "event")');
										$db->query();
									}
									if ($event->image_5) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$event->image_5.'", '.$event->ohanah_event_id.', "event")');
										$db->query();
									}
								}

							//add new fields
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN featured TINYINT(1) DEFAULT 0");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN geolocated_state VARCHAR(50) DEFAULT ''");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN ohanah_venue_id INT(11)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN payment_currency VARCHAR(10)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN frontendsubmission TINYINT(1) DEFAULT 0");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN created_by_name VARCHAR(300)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN created_by_email VARCHAR(300)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN mailchimp_list_id VARCHAR(300)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN customfields MEDIUMTEXT");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN isRecurring TINYINT(1)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN everyNumber INT(11)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN everyWhat VARCHAR(10)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN endOnDate DATE");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN endAfterNumber INT(11)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN endAfterWhat VARCHAR(10)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN recurringParent INT(11)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN picture VARCHAR(100)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN frontend_submitted TINYINT(1)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN end_time_enabled TINYINT(1)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN who_can_register TINYINT(1)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN close_registration_day DATE");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN custom_payment_url VARCHAR(300)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN custom_registration_url VARCHAR(300)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN payment_gateway VARCHAR(20)");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN registration_system VARCHAR(20)");
								$db->query();

							//delete old fields
								$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN header");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN image_1");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN image_2");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN image_3");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN image_4");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN image_5");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN acl_stories");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN acl_comments");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN last_official_update");
								$db->query();

						//modifico __ohanah_categories
							//add new fields
								$db->setQuery("ALTER TABLE #__ohanah_categories ADD COLUMN picture VARCHAR(100) DEFAULT ''");
								$db->query();

						//modifico __ohanah_venues
							//prendo le immagini legate in image_1, image_2, image_3, image_4, image_5 e creo entries in #__ohanah_attachments
								$db->setQuery('SELECT * FROM '.$db->getPrefix().'ohanah_venues');
								foreach ($db->loadObjectList() as $venue) {
									if ($venue->image_1) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$venue->image_1.'", '.$venue->ohanah_venue_id.', "venue")');
										$db->query();
									}
									if ($venue->image_2) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$venue->image_2.'", '.$venue->ohanah_venue_id.', "venue")');
										$db->query();
									}
									if ($venue->image_3) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$venue->image_3.'", '.$venue->ohanah_venue_id.', "venue")');
										$db->query();
									}
									if ($venue->image_4) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$venue->image_4.'", '.$venue->ohanah_venue_id.', "venue")');
										$db->query();
									}
									if ($venue->image_5) {
										$db->setQuery('INSERT INTO #__ohanah_attachments (name, target_id, target_type) VALUES ("'.$venue->image_5.'", '.$venue->ohanah_venue_id.', "venue")');
										$db->query();
									}
								}
							//add new fields
								$db->setQuery("ALTER TABLE #__ohanah_venues ADD COLUMN geolocated_state VARCHAR(50) DEFAULT ''");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_venues ADD COLUMN picture VARCHAR(100) DEFAULT ''");
								$db->query();
							//delete old fields
								$db->setQuery("ALTER TABLE #__ohanah_venues DROP COLUMN image_1");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_venues DROP COLUMN image_2");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_venues DROP COLUMN image_3");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_venues DROP COLUMN image_4");
								$db->query();
								$db->setQuery("ALTER TABLE #__ohanah_venues DROP COLUMN image_5");
								$db->query();

						//__ohanah_attendees diventa __ohanah_registrations, recupero i dati
							$db->setQuery('SELECT * FROM '.$db->getPrefix().'ohanah_attendees');
							foreach ($db->loadObjectList() as $attendee) {
								$user = JFactory::getUser($attendee->created_by);
								$db->setQuery('INSERT INTO #__ohanah_registrations (ohanah_event_id, name, email, number_of_tickets, created_by, created_on, paid, checked_in) VALUES ('.$attendee->ohanah_event_id.', "'.$user->name.'", "'.$user->email.'", 1, '.$attendee->created_by.', "'.$attendee->created_on.'", 0, 0)');
								$db->query();
							}

						// correctly upgrade the venues
							$db->setQuery('SELECT * FROM '.$db->getPrefix().'ohanah_events');
							foreach ($db->loadObjectList() as $event) {

								$db->setQuery("SELECT ohanah_venue_id FROM #__ohanah_venues WHERE title='".$event->venue."'");
								$db->query();
								$id = $db->loadResult();

								if ($id) {
									$query = "UPDATE `#__ohanah_events` SET `ohanah_venue_id` = '".$id."' WHERE ohanah_event_id = '".$event->ohanah_event_id."'";
									$db->setQuery($query);
									$db->query();
								}
							}

					//Delete com_ohfrontent / com_ohmailchimp entries
						$joomlaVersion = JVersion::isCompatible('1.6.0') ? '>1.5' : '1.5';

						if ($joomlaVersion == '1.5') {
							$db->setQuery("DELETE FROM #__components WHERE name='ohfrontend' OR name='ohmailchimp'");
							$db->query();		
							$db->setQuery("DELETE FROM #__plugins WHERE element='ohanah'");
							$db->query();
							$db->setQuery("DELETE FROM #__modules WHERE module='mod_ohanaheventqwiki' OR module='mod_ohanahflyer'");
							$db->query();

						} else {
							$db->setQuery("DELETE FROM #__extensions WHERE element='com_ohfrontend' OR name='com_ohmailchimp'");
							$db->query();
							$db->setQuery("DELETE FROM #__extensions WHERE element='mod_ohanaheventqwiki' OR element='mod_ohanahflyer'");
							$db->query();
						}
				} else if (version_compare($version, '2.0.5', '<=')) { //handle db changes from version 2.0.4 on
					
					$events_columns = $db->getTableFields('#__ohanah_events');
					$events_columns = reset($events_columns);

					if (!isset($events_columns['allow_only_one_ticket'])) {
						$db->setQuery("ALTER TABLE #__ohanah_events ADD COLUMN allow_only_one_ticket TINYINT(1)");
						$db->query();
					}

					if (isset($events_columns['ticketing_end_date'])) {
						$db->setQuery("ALTER TABLE #__ohanah_events DROP COLUMN ticketing_end_date");
						$db->query();
					}
				}
			}

			//Stats
			$db =& JFactory::getDBO();

			if (version_compare($version, '1.0.16', 'le')) {	
				$db->setQuery('SELECT * FROM '.$db->getPrefix().'ohanah_events');
				foreach ($db->loadObjectList() as $event) {
					$query = 'SELECT COUNT(*) FROM #__ohanah_attendees WHERE ohanah_event_id="'.$event->ohanah_event_id.'"';
					$db->setQuery($query);
					$count = $db->loadResult();
					ohstats('event_already_present', array('number_attendees' => $count, 'ticket_price' => $event->ticket_cost));
				}
			} 
			ohstats('upgrade', array('joomla_version'=> JVERSION, 'php_version' => phpversion()));

		} else {
			ohstats('new_install', array('joomla_version'=> JVERSION, 'php_version' => phpversion()));
		}
	}
}

executeOnce();
?>

<?php $joomlaVersion = JVersion::isCompatible('1.6.0') ? '>1.5' : '1.5'; ?>
<?php if ($joomlaVersion == '1.5') : ?>
<h3>****** Please note: the plugin 'System - Mootools upgrade' must be enabled otherwise the admin buttons won't work. *******</h3>
<?php endif; ?>

<?php $rows = 0;?>
<div style="margin:0 auto; text-align:center"><a href="index.php?option=com_ohanah&view=help"><img src="http://<?php echo $_SERVER['HTTP_HOST'].JURI::root(1)?>/media/com_ohanah/images/install.jpg" /></a></div>
