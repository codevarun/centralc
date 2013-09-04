<script>
	$jq(function() {
		$jq('#send-test-email-new-event').click(function() {
			$jq('.button div', this).hide();
			$jq('.loadingImage', this).show();
			$jq.ajax({
			    type: 'post', 
				url: 'index.php?option=com_ohanah&view=config',
				data: {action: 'sendTestMail', subject:$jq('#subject_mail_new_event').val(), message:$jq('#text_mail_new_event').val()},
			    success: function (data, text) {
					$jq('.loadingImage').hide();
					$jq('.button div').show();
			    }
			});
		});

		$jq('#send-test-email-registration-organizer').click(function() {
			$jq('.button div', this).hide();
			$jq('.loadingImage', this).show();
			$jq.ajax({
			    type: 'post', 
				url: 'index.php?option=com_ohanah&view=config',
				data: {action: 'sendTestMail', subject:$jq('#subject_mail_new_registration_organizer').val(), message:$jq('#text_mail_new_registration_organizer').val()},
			    success: function (data, text) {
					$jq('.loadingImage').hide();
					$jq('.button div').show();
			    }
			});
		});

		$jq('#send-test-email-registration-registrant').click(function() {
			$jq('.button div', this).hide();
			$jq('.loadingImage', this).show();
			$jq.ajax({
			    type: 'post', 
				url: 'index.php?option=com_ohanah&view=config',
				data: {action: 'sendTestMail', subject:$jq('#subject_mail_new_registration_registrant').val(), message:$jq('#text_mail_new_registration_registrant').val()},
			    success: function (data, text) {
					$jq('.loadingImage').hide();
					$jq('.button div').show();
			    }
			});
		});
	});
</script>

<div class="panelContent">
	<table>
		<tr>
			<td class="part-left">
				<div>
					<table>
						<tr>
							<span class="fieldTitle"><input type="checkbox" name="enableEmailNewEventFrontend" value="0" <? if ($params->enableEmailNewEventFrontend == '1') echo 'checked' ?> /><?=@text('OHANAH_SEND_ME_AN_EMAIL_WHEN_A_NEW_EVENT_IS_CREATED_BY_USERS_ON_THE_FRONTEND')?></span><br/>
						</tr>
					</table>
				</div>

				<script>
					$jq(function() {
						$jq('input[name="enableEmailNewEventFrontend"]:checkbox').click(function(){
							if ($jq(this).attr('checked')=="checked") { $jq('#ohanah-enable-mail-frontend-enabled-div').show(); } 
							else { $jq('#ohanah-enable-mail-frontend-enabled-div').hide(); }
						});

						<? if ($params->enableEmailNewEventFrontend == 0) : ?>
							$jq('#ohanah-enable-mail-frontend-enabled-div').hide();
						<? endif ?>
					});
				</script>

				<div id="ohanah-enable-mail-frontend-enabled-div">			
					<div class="sendmail-container">
						<table>
							<tr>
								<td style="width:60%;">
									<span class="fieldTitle"><?=@text('OHANAH_SUBJECT');?></span><br/>
									<input class="text" type="text" name="subject_mail_new_event" id="subject_mail_new_event" value="<? if (isset($params->subject_mail_new_event)) echo $params->subject_mail_new_event?>" style="width:450px" />
									<br/>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_MESSAGE');?></span><br/>
									<textarea rows="20" cols="60" name="text_mail_new_event" id="text_mail_new_event" class="description"><?=$params->text_mail_new_event?></textarea>
								</td>
							</tr>
						</table>
						<?=@text('OHANAH_SNIPPETS_YOU_CAN_USE');?>: {NAME} {EMAIL} {EVENT_TITLE} {EVENT_LINK} {START_DATE} 

						<br /><br />

						<div id="send-test-email-new-event" class="send-test-email">
							<div class="button" style="width:150px">
								<div><?=@text('OHANAH_SEND_ME_A_TEST_EMAIL')?></div>
								<img class="loadingImage" src="media://com_ohanah/images/loader.gif" />
							</div>
						</div>
					</div>
				</div>
				<div class="break"></div>


				<div>
					<table>
						<tr>
							<span class="fieldTitle"><input type="checkbox" name="enableEmailNewRegistration" value="0" <? if ($params->enableEmailNewRegistration == '1') echo 'checked' ?> /><?=@text('OHANAH_SEND_ME_AN_EMAIL_WHEN_SOMEONE_REGISTERS_TO_AN_EVENT');?></span><br/>
						</tr>
					</table>
				</div>

				<script>
					$jq(function() {
						$jq('input[name="enableEmailNewRegistration"]:checkbox').click(function(){
							if ($jq(this).attr('checked')=="checked") { $jq('#ohanah-enable-mail-new-registration-enabled-div').show(); } 
							else { $jq('#ohanah-enable-mail-new-registration-enabled-div').hide(); }
						});

						<? if ($params->enableEmailNewRegistration == 0) : ?>
							$jq('#ohanah-enable-mail-new-registration-enabled-div').hide();
						<? endif ?>
					});
				</script>

				<div id="ohanah-enable-mail-new-registration-enabled-div">			
					<div class="sendmail-container">
						<table>
							<tr>
								<td style="width:60%;">
									<span class="fieldTitle"><?=@text('OHANAH_SUBJECT');?></span><br/>
									<input class="text" type="text" name="subject_mail_new_registration_organizer" id="subject_mail_new_registration_organizer" value="<? if (isset($params->subject_mail_new_registration_organizer)) echo $params->subject_mail_new_registration_organizer?>" style="width:460px" />
									<br/>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_MESSAGE');?></span><br/>
									<textarea rows="20" cols="60" name="text_mail_new_registration_organizer" id="text_mail_new_registration_organizer" class="description"><?=$params->text_mail_new_registration_organizer?></textarea>
								</td>
							</tr>
						</table>
						<?=@text('OHANAH_SNIPPETS_YOU_CAN_USE')?>: {NAME} {EMAIL} {EVENT_TITLE} {EVENT_LINK} {TICKETS} {NOTES} {START_DATE} {PERSONS_INFO}

						<br /><br />

						<div id="send-test-email-registration-organizer" class="send-test-email">
							<div class="button" style="width:150px">
								<div><?=@text('OHANAH_SEND_ME_A_TEST_EMAIL');?></div>
								<img class="loadingImage" src="media://com_ohanah/images/loader.gif" />
							</div>
						</div>
					</div>
				</div>
				<div class="break"></div>

				<div>
					<table>
						<tr>
							<span class="fieldTitle"><input type="checkbox" name="enableEmailRegistrationConfirmation" value="0" <? if ($params->enableEmailRegistrationConfirmation == '1') echo 'checked' ?> /><?=@text('OHANAH_SEND_USER_A_CONFIRMATION_EMAIL_UPON_REGISTERING_TO_AN_EVENT'); ?></span><br/>
						</tr>
					</table>
				</div>

				<script>
					$jq(function() {
						$jq('input[name="enableEmailRegistrationConfirmation"]:checkbox').click(function(){
							if ($jq(this).attr('checked')=="checked") { $jq('#ohanah-enable-mail-registration-confirmation-enabled-div').show(); } 
							else { $jq('#ohanah-enable-mail-registration-confirmation-enabled-div').hide(); }
						});

						<? if ($params->enableEmailRegistrationConfirmation == 0) : ?>
							$jq('#ohanah-enable-mail-registration-confirmation-enabled-div').hide();
						<? endif ?>
					});
				</script>

				<div id="ohanah-enable-mail-registration-confirmation-enabled-div">			
					<div class="sendmail-container">
						<table>
							<tr>
								<td style="width:60%;">
									<span class="fieldTitle"><?=@text('OHANAH_SUBJECT');?></span><br/>
									<input class="text" type="text" name="subject_mail_new_registration_registrant" id="subject_mail_new_registration_registrant" value="<? if (isset($params->subject_mail_new_registration_registrant)) echo $params->subject_mail_new_registration_registrant?>" style="width:460px" />
									<br/>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_MESSAGE');?></span><br/>
									<textarea rows="20" cols="60" name="text_mail_new_registration_registrant" id="text_mail_new_registration_registrant" class="description"><?=$params->text_mail_new_registration_registrant?></textarea>
								</td>
							</tr>
						</table>
						<?=@text('OHANAH_SNIPPETS_YOU_CAN_USE')?>: {NAME} {EMAIL} {EVENT_TITLE} {EVENT_LINK} {TICKETS} {NOTES} {START_DATE} {PERSONS_INFO}

						<br /><br />

						<div id="send-test-email-registration-registrant" class="send-test-email">
							<div class="button" style="width:150px">
								<div><?=@text('OHANAH_SEND_ME_A_TEST_EMAIL')?></div>
								<img class="loadingImage" src="media://com_ohanah/images/loader.gif" />
							</div>
						</div>
					</div>
				</div><br />
			</td>
			
			<td class="part-right">

				<div>
					<span class="fieldTitle"><?=@text('OHANAH_SEND_NOTIFICATIONS_TO_THIS_EMAIL')?></span><br/>
					<table>
						<tr>
							<? if (isset($params->destination_email) && $params->destination_email) $default = $params->destination_email; else $default =  JFactory::getConfig()->getValue('mailfrom'); ?>
							<input type="text" id="destination_email" name="destination_email" class="text" value="<?=$default?>" />
						</tr>
					</table><span style="font-size: 85%">
					<? //=@text('OHANAH_MULTIPLE_EMAIL_ADDRESSES')?>You can use multiple email addresses. Example: admin@server.com;moderator@server.com</span>
				</div>

				<div>
					<span class="fieldTitle"><?=@text('OHANAH_ENABLE_MAILCHIMP')?></span><br/>
					<table>
						<tr>
							<? if ($params->enableMailchimp) $default = $params->enableMailchimp; else $default = '0'; ?>
							<?= @helper('select.booleanlist', array('name' => 'enableMailchimp', 'selected' => $default)); ?><br />
						</tr>
					</table>
				</div>


				<script>
					$jq(function() {
						$jq('input[name="enableMailchimp"]:radio').change(function(){
							if ($jq(this).attr('value')=="1") { $jq('#ohanah-mailchimp-enabled-div').show(); } 
							else { $jq('#ohanah-mailchimp-enabled-div').hide(); }
						});

						<? if ($default == 0) : ?>
							$jq('#ohanah-mailchimp-enabled-div').hide();
						<? endif ?>
					});
				</script>

				<div id="ohanah-mailchimp-enabled-div">
					<br />
					<div>
						<span class="fieldTitle"><?=@text('OHANAH_MAILCHIMP_API_KEY')?></span><br/>
						<table>
							<tr>
								<? if ($params->mailchimpApiKey) $default = $params->mailchimpApiKey; else $default = ''; ?>
								<input type="text" name="mailchimpApiKey" class="text" value="<?=$default?>"></div>
							</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>