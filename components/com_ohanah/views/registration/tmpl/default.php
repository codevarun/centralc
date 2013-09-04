<? defined('_JEXEC') or die('Restricted access'); ?>
<? defined('KOOWA') or die('Restricted access'); ?>

<?=@helper('behavior.mootools'); ?>

<?
// Load language file
$lang = &JFactory::getLanguage();
$lang->load('com_ohanah');
$lang->load('com_ohanah', JPATH_ADMINISTRATOR);
?>

<style src="media://com_ohanah/v2/frontend-event-form.css" />
<div class="panelContent ohanah">

	<? if (($params->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
		<script src="media://com_ohanah/js/jquery.min.js" />
		<? JFactory::getApplication()->set('jquery', true); ?>
	<? endif; ?>

	<style src="media://com_ohanah/css/jquery-ui.css" />
	<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />

	<?=@helper('behavior.mootools'); ?>
	<?=@helper('behavior.validator') ?>
	<script src="media://lib_koowa/js/koowa.js" />
		
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-event-registration-1', 'position' => $params->get('eventRegistrationModulePosition1'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-event-registration-2', 'position' => $params->get('eventRegistrationModulePosition2'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-event-registration-3', 'position' => $params->get('eventRegistrationModulePosition3'))) ?>

	<? if (KRequest::get('get.ohanah_event_id', 'int')) : ?>

		<? $event = $this->getService('com://site/ohanah.model.events')->id(KRequest::get('get.ohanah_event_id', 'int'))->getItem(); ?>

		<?= @template('com://site/ohanah.view.event.default_header', array('event' => $event, 'params' => $params)); ?>

		<? if (!$event->limit_number_of_attendees or $event->countAttendees() < $event->attendees_limit) : ?>

			<h4><?=@text('OHANAH_REGISTRATION')?></h4>

			<form action="index.php?option=com_ohanah&view=registration" method="post" class="form-validate -koowa-form box" name="adminForm" enctype="multipart/form-data"  id="adminForm">

				<span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_NAME');?></span><br/>
				<input type="text" class="text size7 required" name="name" id="name" <? if (!$user->guest) echo 'value="'.$user->name.'"'; ?> />

				<br />
				
				<span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_EMAIL');?></span><br/>
				<input type="text" class="text size7 required validate-email" name="email" id="email" <? if (!$user->guest) echo 'value="'.$user->email.'"'; ?> />
			
				<? $active_custom_fields = new JParameter($event->customfields); ?>
				<? for ($i = 1; $i <= 10; $i++) : ?>
					<? if ($active_custom_fields->get('cf'.$i)) : ?>
						<br /><span class="fieldTitle"><?=$active_custom_fields->get('custom_field_label_'.$i)?></span><br/>
						<input type="text" name="custom_field_value_<?=$i?>_person_1" class="customfield text size7 <? if ($active_custom_fields->get('custom_field_label_'.$i.'_mandatory')) echo 'required'?>" value="" /><br />
					<? endif; ?>
				<? endfor ?>

				<? if ($event->payment_gateway != 'custom' && $event->allow_only_one_ticket != 1) : ?>

					<? 
					if ($event->limit_number_of_attendees) {
						if (!$event->attendees_limit) {
							$available = 5;
						} else {
							$available = ($event->attendees_limit - $event->countAttendees()); 
							if ($available < 0) $available = 0; 	
						}
					} else {
						$available = 5;
					}
					?>

					<div>
						<table style="width:20%">
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_NUMBER_OF_TICKETS');?></span><br/>
									<div class="dropdownWrapper">
										<div class="dropdown size5">
											<select name="number_of_tickets" id="number_of_tickets">
												<option value="1">1</option>
												<? if ($available > 1) : ?>
													<option value="2">2</option>
													<? if ($available > 2) : ?>
														<option value="3">3</option>
														<? if ($available > 3) : ?>
															<option value="4">4</option>
															<? if ($available > 4) : ?>
																<option value="5">5</option>
															<? endif ?>
														<? endif ?>
													<? endif ?>
												<? endif ?>
											</select>
										</div>
									</div>
								</td>
							</tr>
						</table>

																
						<span id="ohanah_registration_fields"></span>


						<script>
					 		var $jq = jQuery.noConflict();  
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
												code += ('<div id="ohanah-registration-container-person-'+i+'"><span class="fieldTitle"><?=@text("OHANAH_NAME_OF_ADDITIONAL_PERSON")?> '+(i)+'</span><br/><input type="text" name="field_name_person_'+i+'" class="customfield text size7 required" value="" /><br/>');

												<? for ($i = 1; $i <= 10; $i++) : ?>
													<? if ($active_custom_fields->get('cf'.$i)) : ?>
														code += ('<span class="fieldTitle"><?=$active_custom_fields->get("custom_field_label_".$i)?> <?=@text("OHANAH_OF_PERSON")?> '+i+'</span><br/><input type="text" name="custom_field_value_<?=$i?>_person_'+i+'" class="customfield text size7 <? if ($active_custom_fields->get('custom_field_label_'.$i.'_mandatory')) echo 'required'?>" /><br />');
													<? endif; ?>
												<? endfor ?>

												code += '</div>';

												$jq('#ohanah_registration_fields').append(code);
											}
										}
									}
								});
							});
						</script>	
					</div>

				<? else : ?>
					<input type="hidden" name="number_of_tickets" value="1" />
				<? endif ?>

				<br />
				<table class="notes">
					<tr>
						<td colspan="2"><span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_NOTES');?></span><br/>	
						<textarea class="description" name="notes" id="notes_textarea" style="border: 1px lightgray solid;"><?=$registration->notes?></textarea>
						</td>
					</tr>
				</table>

				<br />
				<? $token = JUtility::getToken(); ?>

				<input type="hidden" name="action" id="action" value="add" />
				<input type="hidden" name="ohanah_event_id" id="ohanah_event_id" value="<?=KRequest::get('get.ohanah_event_id', 'int')?>" />
				<input type="hidden" name="Itemid" id="Itemid" value="<?=KRequest::get('get.Itemid', 'int')?>" />
			
				<? 
				if ($event->payment_gateway != 'none' && $event->ticket_cost) $text = 'OHANAH_BUY_TICKETS';
				else $text = 'OHANAH_REGISTER';
				?>

				<?= @helper('button.button', array('type' => 'input', 'text' => @text($text))); ?>

			</form>
		<? else : ?>
			<?=@text('OHANAH_TICKETS_SOLD_OUT')?>
		<? endif ?>
	<? endif ?>
</div>