<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<style src="media://com_ohanah/css/jquery-ui.css" />

<?=@helper('behavior.mootools'); ?>
<script src="media://lib_koowa/js/koowa.js" />
<script src="media://com_ohanah/js/jquery.maskedinput-1.3.min.js" />
<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />
<script src="media://com_ohanah/js/jquery.form.js" />
<script src="media://com_ohanah/js/si.files.js" />

<style>
#submenu-box .m { display: none;}
</style>

<div id="eventWrapper" class="clearfix">
	<form action="" name="adminForm" method="post"  class="form-validate -koowa-form" id="edit-form" />

		<div id="panelWrapper">
			<div id="adminLeft">
				<div class="panel">
					<div class="panelContent">
						<div class="sendmail-container">
							<table>
								<tr>
									<td style="width:60%;">
										<span class="fieldTitle"><?=@text('OHANAH_SUBJECT')?></span><br/>
										<input class="text" type="text" name="subject" id="subject" value="<? if (KRequest::get('get.payreminder', 'int')) : ?>Payment reminder<? endif; ?>" size="70" />
										<br/>
									</td>
								</tr>
							</table>
							<table>
								<tr>
									<td colspan="2">
										<span class="fieldTitle"><?=@text('OHANAH_MESSAGE')?></span><br/>
										<textarea rows="20" cols="60" name="message" id="message" class="description"><? if (KRequest::get('get.payreminder', 'int')) : ?>Pay reminder: here's the paypal link<? endif ?></textarea>
									</td>
								</tr>
							</table>
							<br />
							<?=@text('OHANAH_SNIPPETS_YOU_CAN_USE')?>: {NAME} {EMAIL} {EVENT_TITLE} {EVENT_LINK} {START_DATE}
						</div>
						<br />
						<br />
					</div>
				</div>
			</div>
			<div id="adminRight">
				<div class="panel">
					<div class="panelContent">
						<table style="margin-bottom:14px;">
							<tr>
								<td>
									<? $registrations = array_unique(KRequest::get('get.id', 'raw')); ?>
									<span class="fieldTitle">
										<? if (count($registrations)>1) : ?>
											<?=JText::sprintf('OHANAH_YOU_ARE_SENDING_EMAIL_PLURAL', count($registrations))?>
										<? else : ?>
											<?=@text('OHANAH_YOU_ARE_SENDING_EMAIL_SINGULAR')?>
										<? endif ?>
									</span><br />
									<ul class="registrationfield-list">
										<? foreach ($registrations as $registration) : ?>
											<? $registrationData = $this->getService('com://admin/ohanah.model.registrations')->id($registration)->getItem(); ?>

											<li>
												<input type="Checkbox" name="id[]" value="<?=$registration?>" checked />&nbsp;<?=$registrationData->name?> <a href="mailto:<?=$registrationData->email?>"><?=$registrationData->email?></a>
												<? if (KRequest::get('get.payreminder', 'int') && $registrationData->paid) : ?>
													<span style="color:orange">PAID</span>
												<? endif ?>

											</li>

										<? endforeach; ?>
									</ul>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="eventid" value="<?=KRequest::get('get.ohanah_event_id', 'int')?>" />

	</form>
</div>
<br />