<?php
/**
* CHRONOFORMS version 4.0
* Copyright (c) 2006 - 2011 Chrono_Man, ChronoEngine.com. All rights reserved.
* Author: Chrono_Man (ChronoEngine.com)
* @license		GNU/GPL
* Visit http://www.ChronoEngine.com for regular updates and information.
**/
defined('_JEXEC') or die('Restricted access');
$mainframe = JFactory::getApplication();
?>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr><td>Choose your .zip action installer file: &nbsp;<input type="file" name="file"></td></tr>
	<tr><td><input type="submit" value="submit file"></td></tr>
	</table>
	<input type="hidden" name="option" value="com_chronoforms" />
	<input type="hidden" name="task" value="install_action" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidemainmenu" value="0">
</form>