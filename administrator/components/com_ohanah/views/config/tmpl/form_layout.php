<? $joomla_version = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5'; ?>

<div class="panelContent">
	<table>
		<tr>
			<td class="part-left">			
				<div>
					<span class="fieldTitle"><?=@text('OHANAH_MENU_OHANAH_SHOULD_POINT_ITS_LINK_TO'); ?></span><br/>
					<div class="dropdownWrapper left">
						<div class="dropdown size1">
							<? $db =& JFactory::getDBO(); ?>
							<? $db->setQuery('SELECT * FROM #__menu_types'); ?>
							<select class="size1"  id="itemid" name="itemid">
								<option value="" <? if ($params->itemid=='') echo 'selected'?>><?=@text('OHANAH_USE_THE_MENU_WHERE_THE_LINK_IS');?></option>
								<?foreach ($db->loadObjectList() as $menutype) : ?>
									<option value=<?=$menutype->id?> disabled><?=$menutype->title?></option>
									
									<? if ($joomla_version == '1.5') : ?>
										<? $db->setQuery('SELECT * FROM #__menu WHERE menutype="'.$menutype->menutype.'" AND parent=0'); ?>
									<? else : ?>
										<? $db->setQuery('SELECT * FROM #__menu WHERE menutype="'.$menutype->menutype.'" AND parent_id=1 AND client_id=0'); ?>
									<? endif ?>

									<?foreach ($db->loadObjectList() as $item) : ?>
										<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   -->   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>

										<? if ($joomla_version == '1.5') : ?>
											<? $db->setQuery('SELECT * FROM #__menu WHERE parent="'.$item->id.'"');	?>
										<? else : ?>
											<? $db->setQuery('SELECT * FROM #__menu WHERE parent_id="'.$item->id.'" AND client_id=0');	?>
										<? endif ?>

										<?foreach ($db->loadObjectList() as $item) : ?>
											<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   ---->   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>	
											
											<? if ($joomla_version == '1.5') : ?>
												<? $db->setQuery('SELECT * FROM #__menu WHERE parent="'.$item->id.'"');	?>
											<? else : ?>
												<? $db->setQuery('SELECT * FROM #__menu WHERE parent_id="'.$item->id.'" AND client_id=0');	?>
											<? endif ?>

											<?foreach ($db->loadObjectList() as $item) : ?>
												<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   ------>   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>

												<? if ($joomla_version == '1.5') : ?>
													<? $db->setQuery('SELECT * FROM #__menu WHERE parent="'.$item->id.'"');	?>
												<? else : ?>
													<? $db->setQuery('SELECT * FROM #__menu WHERE parent_id="'.$item->id.'" AND client_id=0');	?>
												<? endif ?>
												
												<?foreach ($db->loadObjectList() as $item) : ?>
													<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   -------->   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>

													<? if ($joomla_version == '1.5') : ?>
														<? $db->setQuery('SELECT * FROM #__menu WHERE parent="'.$item->id.'"');	?>
													<? else : ?>
														<? $db->setQuery('SELECT * FROM #__menu WHERE parent_id="'.$item->id.'" AND client_id=0');	?>
													<? endif ?>

													<?foreach ($db->loadObjectList() as $item) : ?>
														<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   ---------->   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>

															<? if ($joomla_version == '1.5') : ?>
																<? $db->setQuery('SELECT * FROM #__menu WHERE parent="'.$item->id.'"');	?>
															<? else : ?>
																<? $db->setQuery('SELECT * FROM #__menu WHERE parent_id="'.$item->id.'" AND client_id=0');	?>
															<? endif ?>

															<?foreach ($db->loadObjectList() as $item) : ?>
																<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   ------------>   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>
															
																<? if ($joomla_version == '1.5') : ?>
																	<? $db->setQuery('SELECT * FROM #__menu WHERE parent="'.$item->id.'"');	?>
																<? else : ?>
																	<? $db->setQuery('SELECT * FROM #__menu WHERE parent_id="'.$item->id.'" AND client_id=0');	?>
																<? endif ?>
																
																<?foreach ($db->loadObjectList() as $item) : ?>
																	<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   -------------->   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>

																	<? if ($joomla_version == '1.5') : ?>
																		<? $db->setQuery('SELECT * FROM #__menu WHERE parent="'.$item->id.'"');	?>
																	<? else : ?>
																		<? $db->setQuery('SELECT * FROM #__menu WHERE parent_id="'.$item->id.'" AND client_id=0');	?>
																	<? endif ?>																	

																	<?foreach ($db->loadObjectList() as $item) : ?>
																		<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   ---------------->   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>

																		<? if ($joomla_version == '1.5') : ?>
																			<? $db->setQuery('SELECT * FROM #__menu WHERE parent="'.$item->id.'"');	?>
																		<? else : ?>
																			<? $db->setQuery('SELECT * FROM #__menu WHERE parent_id="'.$item->id.'" AND client_id=0');	?>
																		<? endif ?>																	

																		<?foreach ($db->loadObjectList() as $item) : ?>
																			<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   ------------------>   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>
																			
																			<? if ($joomla_version == '1.5') : ?>
																				<? $db->setQuery('SELECT * FROM #__menu WHERE parent="'.$item->id.'"');	?>
																			<? else : ?>
																				<? $db->setQuery('SELECT * FROM #__menu WHERE parent_id="'.$item->id.'" AND client_id=0');	?>
																			<? endif ?>	
																																			
																			<?foreach ($db->loadObjectList() as $item) : ?>
																				<option value=<?=$item->id?> <? if ($params->itemid==$item->id) echo 'selected'?>>   -------------------->   <? if ($joomla_version == '1.5') echo $item->name; else echo $item->title; ?></option>
																			<? endforeach ?>
																		<? endforeach ?>
																	<? endforeach ?>
																<? endforeach ?>	
															<? endforeach ?>
													<? endforeach ?>
												<? endforeach ?>
											<? endforeach ?>
										<? endforeach ?>
									<? endforeach ?>
								<? endforeach ?>
							</select>
						</div>
					</div>
				</div>

				<br />
				<div class="break"></div>

				<div>
					<span class="fieldTitle"><?=@text('OH_CUSTOM_CSS'); ?></span><br/>
					<textarea class="description" name="customCSS" id="customCSS" style="height: 80px; max-width:490px"><?=$params->customCSS?></textarea>
				</div>

				<div class="break"></div>

				<div>
					<span class="fieldTitle"></span><br/>
					<table>
						<tr>
							<span class="fieldTitle"><input type="checkbox" name="enableComments" value="0" <? if ($params->enableComments == '1') echo 'checked' ?> /><?php echo JText::_('OHANAH_ENABLE_COMMENTS'); ?></span>
						</tr>
					</table>
				</div>

				<script>
					$jq(function() {
						$jq('input[name="enableComments"]:checkbox').click(function(){
							if ($jq(this).attr('checked')=="checked") { $jq('#ohanah-comments-enabled-div').show(); } 
							else { $jq('#ohanah-comments-enabled-div').hide(); }
						});

						<? if ($params->enableComments == 0) : ?>
							$jq('#ohanah-comments-enabled-div').hide();
						<? endif ?>

						$jq('select[name="useFacebookComments"]').change(function(){
							if($jq(this).attr('value')=="0") {
								$jq('#ohanah-comments-enabled-custom-code').css('display', 'inline');
							} else {
								$jq('#ohanah-comments-enabled-custom-code').css('display', 'none');
							}
						});

						<? if ($params->useFacebookComments == '1') : ?>
							$jq('#ohanah-comments-enabled-custom-code').hide();
						<? endif ?>
					});					
				</script>


				<div id="ohanah-comments-enabled-div">
					<br />
					<div class="dropdownWrapper left">
						<div class="dropdown size1">
							<span id="recurr">
								<select name="useFacebookComments" size="1">
									<option value="1" <? if ($params->useFacebookComments == '1') echo 'selected="selected"'; ?>><?=@text('Facebook Comments')?></option>
									<option value="0" <? if ($params->useFacebookComments == '0') echo 'selected="selected"'; ?>><?=@text('Custom')?></option>
								</select>
							</span>
						</div>
					</div>

					<br /><br />
					<div id="ohanah-comments-enabled-custom-code">
						<span class="fieldTitle"><?=@text('OHANAH_COMMENTS_CODE'); ?></span><br/>
						<textarea class="description" name="commentsCode" id="commentsCode"><?=$params->commentsCode?></textarea>
						<span class="fieldTitle"><?=@text('OHANAH_EXAMPLE_OF_COMMENTS_YOU_COULD_USE');?>: <a target="_blank" href="http://disqus.com">Disqus</a></span>
					</div>
				</div>

				<div class="break"></div>

				<div>
					<span class="fieldTitle"><?php echo JText::_('OHANAH_SHOW_SOCIAL_SHARE_BUTTONS_ON_EVENTS'); ?></span><br/>
					<table>
						<tr>
							<span style="line-height:30px"><input type="checkbox" name="showButtonFacebook" value="0" <? if ($params->showButtonFacebook == '1') echo 'checked' ?> />&nbsp;Facebook Like</span><br />
							<span style="line-height:30px"><input type="checkbox" name="showButtonGoogle" value="0" <? if ($params->showButtonGoogle == '1') echo 'checked' ?> />&nbsp;Google +1</span><br />
							<span style="line-height:30px"><input type="checkbox" name="showButtonTwitter" value="0" <? if ($params->showButtonTwitter == '1') echo 'checked' ?> />&nbsp;Twitter Tweet</span><br />
						</tr>
					</table>
				</div>

				<div class="break"></div>

				<div>
					<span class="fieldTitle"></span><br/>
					<table>
						<tr>
							<span class="fieldTitle"><input type="checkbox" name="useStandardJoomlaEditor" value="0" <? if ($params->useStandardJoomlaEditor == '1') echo 'checked' ?> /><?php echo JText::_('OHANAH_USE_THE_STANDARD_JOOMLA_EDITOR'); ?></span>
						</tr>
					</table>
				</div>


			</td>
			
			<td class="part-right">
				<span class="fieldTitle"><?=@text('OHANAH_FRONTEND_STYLE');?></span><br/>
				<div class="dropdownWrapper" style="float:left">
					<div class="dropdown size1">
						<? if (isset($params->module_chrome)) $default = $params->module_chrome; else $default = 'xhtml'; ?>
						<?=@helper('com://admin/ohanah.template.helper.listbox.module_chrome', array('selected' => $default)) ?>
					</div>
				</div>
				<br />
				<span class="fieldTitle">Moduleclass SFX</span><br/><input type="text" id="moduleclass_sfx" name="moduleclass_sfx" class="text" value="<?=$params->moduleclass_sfx?>" />

				
				<div class="break"></div>


				<span class="fieldTitle"><?=@text('OHANAH_EVENT_PLACE_DISPLAY_STYLE');?></span><br/>
				<div class="dropdownWrapper" style="float:left">
					<div class="dropdown size1">
						<? if (isset($params->event_place_style)) $default = $params->event_place_style; else $default = 'venue'; ?>
						<?=@helper('com://admin/ohanah.template.helper.listbox.event_place_style', array('selected' => $default)) ?>
					</div>
				</div>

				<br />
				<div class="break"></div>

				<span class="fieldTitle"><?=@text('OHANAH_BUTTONS_STYLE');?></span><br/>
				<div class="dropdownWrapper" style="float:left">
					<div class="dropdown size1">
						<? if (isset($params->buttons_style)) $default = $params->buttons_style; else $default = 'ohanah'; ?>
						<?=@helper('com://admin/ohanah.template.helper.listbox.buttons_style', array('selected' => $default)) ?>
					</div>
				</div>

				<br />
				<div class="break"></div>

				<span class="fieldTitle"><?=@text('OHANAH_LOAD_JQUERY');?></span><br/>
				<div class="dropdownWrapper left">
					<div class="dropdown size4">
						<? if (isset($params->loadJQuery)) $default = $params->loadJQuery; else $default = '1'; ?>
						<?=@helper('com://admin/ohanah.template.helper.listbox.yes_or_no', array('name' => 'loadJQuery', 'selected' => $default)) ?>
					</div>
				</div>

				<br />
				<div class="break"></div>

				<span class="fieldTitle"><?=@text('Add RSS Feed');?></span><br/>
				<div class="dropdownWrapper left">
					<div class="dropdown size4">
						<? if (isset($params->showFeedLink)) $default = $params->showFeedLink; else $default = '0'; ?>
						<?=@helper('com://admin/ohanah.template.helper.listbox.yes_or_no', array('name' => 'showFeedLink', 'selected' => $default)) ?>
					</div>
				</div>
				<br />
				<div class="break"></div>

				<span class="fieldTitle"><?=@text('Local environment');?></span><br/>
				<div class="dropdownWrapper left">
					<div class="dropdown size4">
						<? if (isset($params->localEnvironment)) $default = $params->localEnvironment; else $default = '0'; ?>
						<?=@helper('com://admin/ohanah.template.helper.listbox.yes_or_no', array('name' => 'localEnvironment', 'selected' => $default)) ?>
					</div>
				</div>

				
			</td>
		</tr>
	</table>
	<br /><br />
</div>