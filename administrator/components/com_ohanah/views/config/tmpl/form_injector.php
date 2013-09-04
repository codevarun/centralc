<div class="panelContent">
 				
 	<br />
	<br />

	<span style="line-height:20px" class="fieldTitle"><?=@text('OHANAH_MODULE_INJECTOR_DESC')?></span>

	<div>
		<table>
			<tr>
				<span class="fieldTitle"><input type="checkbox" name="disableModuleInjector" value="0" <? if ($params->disableModuleInjector == '1') echo 'checked' ?> /><?=@text('OHANAH_DISABLE_MODULE_INJECTOR')?></span><br/>
			</tr>
		</table>
	</div>

	<div class="break"></div>
	<br />

	<? $positions = @helper('com://admin/ohanah.template.helper.listbox.getModulePositions'); ?>

	<h3><?=@text('OHANAH_SINGLE_EVENT_VIEW')?></h3>
	<div class="thirty">
		<span class="fieldTitle">ohanah-single-event-1</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->singleEventModulePosition1)) $default = $params->singleEventModulePosition1; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'singleEventModulePosition1', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-single-event-2</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->singleEventModulePosition2)) $default = $params->singleEventModulePosition2; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'singleEventModulePosition2', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-single-event-3</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->singleEventModulePosition3)) $default = $params->singleEventModulePosition3; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'singleEventModulePosition3', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	
	<br />
	<div class="break"></div>
	<br />

	<h3><?=@text('OHANAH_EVENT_LIST_VIEW'); ?></h3>
	<div class="thirty">
		<span class="fieldTitle">ohanah-list-events-1</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->listEventsModulePosition1)) $default = $params->listEventsModulePosition1; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'listEventsModulePosition1', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-list-events-2</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->listEventsModulePosition2)) $default = $params->listEventsModulePosition2; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'listEventsModulePosition2', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-list-events-3</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->listEventsModulePosition3)) $default = $params->listEventsModulePosition3; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'listEventsModulePosition3', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>


	<br />
	<div class="break"></div>
	<br />

	<h3><?=@text('OHANAH_SINGLE_VENUE_VIEW')?></h3>
	<div class="thirty">
		<span class="fieldTitle">ohanah-single-venue-1</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->singleVenueModulePosition1)) $default = $params->singleVenueModulePosition1; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'singleVenueModulePosition1', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-single-venue-2</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->singleVenueModulePosition2)) $default = $params->singleVenueModulePosition2; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'singleVenueModulePosition2', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-single-venue-3</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->singleVenueModulePosition3)) $default = $params->singleVenueModulePosition3; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'singleVenueModulePosition3', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>


	<br />
	<div class="break"></div>
	<br />

	<h3><?=@text('OHANAH_SINGLE_CATEGORY_VIEW')?></h3>
	<div class="thirty">
		<span class="fieldTitle">ohanah-single-category-1</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->singleCategoryModulePosition1)) $default = $params->singleCategoryModulePosition1; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'singleCategoryModulePosition1', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-single-category-2</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->singleCategoryModulePosition2)) $default = $params->singleCategoryModulePosition2; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'singleCategoryModulePosition2', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-single-category-3</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->singleCategoryModulePosition3)) $default = $params->singleCategoryModulePosition3; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'singleCategoryModulePosition3', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>

	<br />
	<div class="break"></div>
	<br />

	<h3><?=@text('OHANAH_EVENT_REGISTRATION_VIEW')?></h3>
	<div class="thirty">
		<span class="fieldTitle">ohanah-event-registration-1</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->eventRegistrationModulePosition1)) $default = $params->eventRegistrationModulePosition1; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'eventRegistrationModulePosition1', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-event-registration-2</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->eventRegistrationModulePosition2)) $default = $params->eventRegistrationModulePosition2; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'eventRegistrationModulePosition2', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>
	<div class="thirty">
		<span class="fieldTitle">ohanah-event-registration-3</span><br/>
		<div class="dropdownWrapper" style="float:left">
			<div class="dropdown size1">
				<? if (isset($params->eventRegistrationModulePosition3)) $default = $params->eventRegistrationModulePosition3; else $default = ''; ?>
				<?=@helper('com://admin/ohanah.template.helper.listbox.module_positions', array('name' => 'eventRegistrationModulePosition3', 'selected' => $default, 'positions' => $positions)) ?>
			</div>
		</div>
	</div>

	<br /><br />

</div>
<br />
<br />