<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<style src="media://com_ohanah/v2/ohanah_css/jquery.cleditor.css" />
<style src="media://com_ohanah/css/jquery-ui.css" />

<?=@helper('behavior.mootools') ?>
<?=@helper('behavior.validator') ?>
<script src="media://lib_koowa/js/koowa.js" />

<? 
if ($id = KRequest::get('get.id', 'int')) {
	$event = $this->getService('com://admin/ohanah.model.events')->id($this->getService('com://admin/ohanah.model.registrations')->id(KRequest::get('get.id', 'int'))->getItem()->ohanah_event_id)->getItem();
} else {
	$event = $this->getService('com://admin/ohanah.model.events')->id(KRequest::get('get.ohanah_event_id', 'int'))->getItem();
}
?>

<form action="" method="post" class="form-validate -koowa-form" id="edit-form" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?=$registration->id?>" />

	<div class="clr"></div>
			
	<div id="eventWrapper" class="clearfix">
		<div id="panelWrapper">
			<div id="adminLeft">
				<div class="panel">
					<div class="panelContent">
						<table>
							<tr>
								<td style="width:60%;" >
									<span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_NAME');?></span><br/>
									<input type="text" class="text size6 required" name="name" id="name" value="<?=$registration->name?>" />
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td style="width:60%;" >
									<span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_EMAIL');?></span><br/>
									<input type="text" class="text size6 required validate-email" name="email" id="email" value="<?=$registration->email?>" />
								</td>
							</tr>
						</table>

						<br />	<br />

						<? $active_custom_fields = new JParameter($event->customfields); ?>
						<? $params = new JParameter($registration->params); ?>					

						<? for ($indexField = 1; $indexField <= 10; $indexField++) : ?>
							<? if ($active_custom_fields->get('cf'.$indexField)) : ?>
								<span class="fieldTitle"><?=$active_custom_fields->get('custom_field_label_'.$indexField)?></span><br/>
								<input type="text" name="custom_field_value_<?=$indexField?>_person_1" class="customfield text size5 <? if ($active_custom_fields->get('custom_field_label_'.$indexField.'_mandatory')) echo 'required'?>" value="<?=$params->get('custom_field_value_'.$indexField.'_person_1')?>" /><br />
							<? endif; ?>
						<? endfor ?>
						<br />
					</div>
				</div>
			</div>
			<div id="adminRight">
				<div class="panel">
					<div class="panelContent">
						<table>
							<tr>
								<td>
									<div id="eventPhotos">
										<div id="ohanah_registration_fields">
											<? for ($i = 2; $i <= $registration->number_of_tickets; $i++) : ?>
												<? if ($i > 2) : ?>
													<div class="break"></div>
												<? endif ?>
												
												<div id="ohanah-registration-container-person-<?=$i?>">
													<span class="fieldTitle"><?=@text('OHANAH_NAME_OF_ADDITIONAL_PERSON')?> <?=($i-1);?></span><br/>
													<input type="text" name="field_name_person_<?=$i?>" class="customfield text size5 required" value="<?=$params->get('field_name_person_'.$i)?>" /><br/>
													<? for ($indexField = 1; $indexField <= 10; $indexField++) : ?>
														<? if ($active_custom_fields->get('cf'.$indexField)) : ?>
															<span class="fieldTitle"><?=$active_custom_fields->get('custom_field_label_'.$indexField)?> <?=@text("OHANAH_OF_PERSON")?> <?=$indexField?></span><br/>
															<input type="text" name="custom_field_value_<?=$indexField?>_person_<?=$i?>" class="customfield text size5 <? if ($active_custom_fields->get('custom_field_label_'.$indexField.'_mandatory')) echo 'required'?>" value="<?=$params->get('custom_field_value_'.$indexField.'_person_'.$i)?>" /><br />
														<? endif; ?>
													<? endfor ?>
													<div class="break"></div>
												</div>
											<? endfor; ?>
										</div>
										<script>
											$jq(function() {
												var oldNumberOfTickets;

											    $jq('#number_of_tickets').focus(function() {
											        oldNumberOfTickets = parseInt(this.value);
											    });

												$jq('#number_of_tickets').change(function() {
													newNumberOfTickets = parseInt(this.getElement(':selected').text);

													for (i = 2; i<=5; i++) {
														if (i > newNumberOfTickets) {
															if ($('ohanah-registration-container-person-'+i)) {
																$('ohanah-registration-container-person-'+i).destroy();
															}
														} else {
															if (!$('ohanah-registration-container-person-'+i)) {
																var code = '';
																code += ('<div id="ohanah-registration-container-person-'+i+'"><span class="fieldTitle"><?=@text("OHANAH_NAME_OF_ADDITIONAL_PERSON")?> '+i+'</span><br/><input type="text" name="field_name_person_'+i+'" class="customfield text size5 required" value="" /><br/>');

																<? for ($i = 1; $i <= 10; $i++) : ?>
																	<? if ($active_custom_fields->get('cf'.$i)) : ?>
																		code += ('<span class="fieldTitle"><?=$active_custom_fields->get("custom_field_label_".$i)?> <?=@text("OHANAH_OF_PERSON")?> '+i+'</span><br/><input type="text" name="custom_field_value_<?=$i?>_person_'+i+'" class="customfield text size5 <? if ($active_custom_fields->get("custom_field_label_".$i."_mandatory")) echo "required"?>" /><br />');
																	<? endif; ?>
																<? endfor ?>

																code += '<br/><br/><div class="break"></div></div>';
																$jq('#ohanah_registration_fields').append(code);
															}
														}
													}
												});
											});
										</script>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div><br />
	<div id="eventWrapper2" class="clearfix">
		<div id="panelWrapper">
			<div id="adminLeft" class="bottom">
				<div class="panel">
					<div class="panelContent">
						<table>
							<tr>
								<td colspan="2"><span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_NOTES');?></span><br/>	
								<textarea class="description" name="notes" id="notes_textarea"><?=$registration->notes?></textarea>
								</td>
							</tr>
						</table>
						<br />
					</div>		
				</div>
			</div>
			<div id="adminRight" class="bottom">
				<div class="panel">
					<div class="panelContent">
						<? if ($event->allow_only_one_ticket != 1) : ?>
							<table style="width:20%">
								<tr>
									<td>
										<span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_NUMBER_OF_TICKETS');?></span><br/>
										<div class="dropdownWrapper">
											<div class="dropdown size2">
												
												<select name="number_of_tickets" id="number_of_tickets">
													<option value="1" <? if ($registration->number_of_tickets==1) echo 'selected';?>>1</option>
													<option value="2" <? if ($registration->number_of_tickets==2) echo 'selected';?>>2</option>
													<option value="3" <? if ($registration->number_of_tickets==3) echo 'selected';?>>3</option>
													<option value="4" <? if ($registration->number_of_tickets==4) echo 'selected';?>>4</option>
													<option value="5" <? if ($registration->number_of_tickets==5) echo 'selected';?>>5</option>
												</select>
											</div>
										</div>
									</td>

								</tr>
							</table>
						<? else : ?>
							<input type="hidden" name="number_of_tickets" value="1" />
						<? endif ?>
						<table style="width:20%">
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_PAYMENT_STATUS');?></span><br/>
									<div class="dropdownWrapper">
										<div class="dropdown size2">
											
											<select name="paid" id="paid">
												<option value="1" <? if ($registration->paid==1) echo 'selected';?>><?=@text('OHANAH_PAID')?></option>
												<option value="0" <? if ($registration->paid==0) echo 'selected';?>><?=@text('OHANAH_NOT_PAID')?></option>
											</select>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="calendarTab">&nbsp;</div>
	
	<? $id = KRequest::get('get.id', 'int'); ?>
	<? if (!$id) : ?>
		<input type="hidden" name="ohanah_event_id" value="<?=KRequest::get('get.ohanah_event_id', 'int')?>" />
	<? endif; ?>
</form>