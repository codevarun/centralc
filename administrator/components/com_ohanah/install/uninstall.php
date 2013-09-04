<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.installer.installer');

$lang = &JFactory::getLanguage();
$lang->load('com_ohanah');

$status = new JObject();
$status->modules = array();

$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';

if ($joomlaVersion == '1.6')
{
	$modules = $this->manifest->modules;
	
	if (is_a($modules, 'JXMLElement') && count($modules)) {

		foreach ($modules->module as $module) 
		{
			$mname = $module->getAttribute('module');
			$db = & JFactory::getDBO();
			$query = "SELECT `extension_id` FROM `#__extensions` WHERE type='module' AND name = ".$db->Quote($mname)."";
			$db->setQuery($query);
			$modules = $db->loadResultArray();
			if (count($modules)) {
				foreach ($modules as $module) {
					$installer = new JInstaller;
					$result = $installer->uninstall('module', $module, 0);
				}
			}
			$status->modules[] = array ('name'=>$mname, 'client'=>'Site', 'result'=>$result);
		}
	}
}
else
{
	$modules = $this->manifest->getElementByPath('modules');
	
	if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) {

		foreach ($modules->children() as $module) 
		{
			$mname = $module->attributes('module');
			$db = & JFactory::getDBO();
			$query = "SELECT `id` FROM `#__modules` WHERE module = ".$db->Quote($mname)."";
			$db->setQuery($query);
			$modules = $db->loadResultArray();
			if (count($modules)) {
				foreach ($modules as $module) {
					$installer = new JInstaller;
					$result = $installer->uninstall('module', $module, 0);
				}
			}
			$status->modules[] = array ('name'=>$mname, 'client'=>'Site', 'result'=>$result);
		}
	}
}

$status->plugins = array();


if ($joomlaVersion == '1.6')
{
	$plugins = $this->manifest->plugins;
	
	if (is_a($plugins, 'JXMLElement') && count($plugins)) {

		foreach ($plugins->plugin as $plugin) 
		{
			$mname = $plugin->getAttribute('plugin');
			$db = & JFactory::getDBO();
			$query = "SELECT `extension_id` FROM `#__extensions` WHERE type='plugin' AND name = ".$db->Quote($mname)."";
			$db->setQuery($query);
			$plugins = $db->loadResultArray();
			if (count($plugins)) {
				foreach ($plugins as $plugin) {
					$installer = new JInstaller;
					$result = $installer->uninstall('plugin', $plugin, 0);
				}
			}
			$status->plugins[] = array ('name'=>$mname, 'client'=>'Site', 'result'=>$result);
		}
	}
}
else
{
	$plugins = $this->manifest->getElementByPath('plugins');
	
	if (is_a($plugins, 'JSimpleXMLElement') && count($plugins->children())) {

		foreach ($plugins->children() as $plugin) 
		{
			$mname = $plugin->attributes('plugin');
			$db = & JFactory::getDBO();
			$query = "SELECT `id` FROM `#__plugins` WHERE element = ".$db->Quote($mname)."";
			$db->setQuery($query);
			$plugins = $db->loadResultArray();
			if (count($plugins)) {
				foreach ($plugins as $plugin) {
					$installer = new JInstaller;
					$result = $installer->uninstall('plugin', $plugin, 0);
				}
			}
			$status->plugins[] = array ('name'=>$mname, 'client'=>'Site', 'result'=>$result);
		}
	}
}



?>

<?php $rows = 0;?>
<h2><?php echo JText::_('Ohanah Uninstall Status'); ?></h2>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'Ohanah '.JText::_('Component'); ?></td>
			<td><strong><?php echo JText::_('Removed'); ?></strong></td>
		</tr>
		<?php if (count($status->modules)) : ?>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Client'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->modules as $module) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong><?php echo ($module['result'])?JText::_('Removed'):JText::_('Not removed'); ?></strong></td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
		<?php if (count($status->plugins)) : ?>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($status->plugins as $plugin) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $plugin['name']; ?></td>
			<td class="key"></td>
			<td><strong><?php echo ($plugin['result'])?JText::_('Removed'):JText::_('Not removed'); ?></strong></td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
	</tbody>
</table>