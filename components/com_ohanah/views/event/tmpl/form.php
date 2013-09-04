<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<?
// Load language file
$lang = &JFactory::getLanguage();
$lang->load('com_ohanah');
$lang->load('com_ohanah', JPATH_ADMINISTRATOR);
?>

<? 
if ($params->get('useStandardJoomlaEditor')) {
    $config = new KConfig();
    $config->append(array(
        'editor'    => null,
        'name'      => 'description',
        'width'     => '100%',
        'height'    => '291',
        'cols'      => '100',
        'rows'      => '20',
        'buttons'   => true,
        'options'   => array()
    ));

    $editor  = JFactory::getEditor($config->editor);
    $options = KConfig::unbox($config->options);

    if (version_compare(JVERSION, '1.6.0', 'ge')) { 
        $editorResult = $editor->display($config->name, $config->{$config->name}, $config->width, $config->height, $config->cols, $config->rows, KConfig::unbox($config->buttons), $config->name, null, null, $options); 
    } else { 
        $editorResult = $editor->display($config->name, $config->{$config->name}, $config->width, $config->height, $config->cols, $config->rows, KConfig::unbox($config->buttons), $options); 
    } 
}
?>

<style src="media://com_ohanah/v2/frontend-event-form.css" />
<div class="panelContent ohanah">

	<? if (($params->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
		<script src="media://com_ohanah/js/jquery.min.js" />
		<? JFactory::getApplication()->set('jquery', true); ?>
	<? endif; ?>

	<? 
		$lang =& JFactory::getLanguage();
		$locale = $lang->get('tag');

		$localeMap = Array(
				"en-GB" => "en-US",
				"af-ZA" => "af-ZA",
				"ar-AA" => "ar",
				"bs-BA" => "en-US",
				"bg-BG" => "en-US",
				"ca-ES" => "ca-CA",
				"zh-TW" => "zh-CH",
				"hr-HR" => "en-US",
				"cs-CZ" => "cs-CZ",
				"ds-DK" => "en-US",
				"nl-NL" => "nl-NL",
				"et-EE" => "et-EE",
				"fi-FI" => "fi-FI",
				"fr-FR" => "fr-FR",
				"de-DE" => "de-DE",
				"el-GR" => "en-US",
				"hu-HU" => "hu-HU",
				"it-IT" => "it-IT",
				"lv-LV" => "en-US",
				"mk-MK" => "en-US",
				"nb-NO" => "no-NO",
				"fa-IR" => "fa",
				"pl-PL" => "pl-PL",
				"pt-BR" => "pt-BR",
				"pt-PT" => "pt-PT",
				"ro-RO" => "en-US",
				"ru-RO" => "ru-RU",
				"sl-SL" => "si-SI",
				"es-ES" => "es-ES",
				"sv-SE" => "sv-SE",
				"tr-TR" => "tr-TR",
			);
	?>

	<?=@helper('behavior.mootools'); ?>
	<?=@helper('behavior.validator') ?>
	<?  $joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
			if ($joomlaVersion == '1.6') { ?>
				<script src="media://com_ohanah/js/mootools-locale/Locale.<?=$localeMap["$locale"]?>.Date.js" />
				<script src="media://com_ohanah/js/mootools-locale/Locale.<?=$localeMap["$locale"]?>.Form.Validator.js" />
				<script>
					Locale.use("<?=$localeMap["$locale"]?>");
				</script>
			<? }
	?>
	
	<script src="media://lib_koowa/js/koowa.js" />
	<script src="media://com_ohanah/js/jquery.cleditor.min.js" />
	<script src="media://com_ohanah/js/jquery.maskedinput-1.3.min.js" />
	<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />
	<script src="media://com_ohanah/js/jquery.form.js" />
	<script src="media://com_ohanah/js/si.files.js" />

	<style src="media://com_ohanah/css/jquery-ui.css" />
	<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />
	<style src="media://com_ohanah/v2/ohanah_css/jquery.cleditor.css" />

	<?= @template('images', array('item' => $event, 'name' => 'event')); ?>

	<script>
		var $jq = jQuery.noConflict();  
	</script>

	<script>
		function check_times() {
			if ($jq('#end_date').val() == $jq('#date').val()) { 	
				var hS = $jq('select[name="start_time_h"]');
				var mS = $jq('select[name="start_time_m"]');
				var ampmS = $jq('select[name="start_time_ampm"]'); // return empty array if there is no such element
				var hE = $jq('select[name="end_time_h"]');
				var mE = $jq('select[name="end_time_m"]');
				var ampmE = $jq('select[name="end_time_ampm"]'); // return empty array if there is no such element
			
				if (ampmS.length) { // ampm returned something, so actually there is AMPM selector and we should do the math
					if (ampmS.val() == ampmE.val()) { // if start and end are in the same part of the day, we do the math
						
						// problem is that 12 means 00, so we treat this case special
						// f end is 12, then it's OK just if start is 12, otherwise it's bad
						if (hE.val() == "12") {
							hE.val(hS.val()); // if start is 12 too, nothing will change, otherwise end = start
						} else { // now we know end is not 12, so we do the check
							if (hS.val() != "12" & hS.val() > hE.val()) { // if it's 12, it's OK, it's like 00, everything is fine
								hE.val(hS.val());	
							}
						}
						
						// if hours are the same, we check minutes
						if (hS.val() == hE.val()) {
							if (mS.val() > mE.val()) {
								mE.val(mS.val());
							}
						}
					}
					// if start is AM and end is PM, then it's fine, nothitg to worry about
					// else, it's start PM and end AM, that's wrong, switch end to PM also
					if (ampmS.val() == "PM" & ampmE.val() == "AM") {
						ampmE.val("PM");
					}

				} else { // 24 hour format, yey... 
					if (hS.val() > hE.val()) {
						hE.val(hS.val());
					}
					if (hS.val() == hE.val()) {
						if (mS.val() > mE.val()) {
							mE.val(mS.val());
						}
					}
				}
			}
		}
		
		$jq(function() {
		   	$jq("#description_textarea").cleditor({ width: 612, height: 113, controls: "bold italic underline bullets link unlink source"});

			//SHORT URL FUNCTIONS
			$jq( "#slugEdit" ).click(function() {
				$jq( "#slug" ).css('left', '0px');
				$jq( "#slugContainer" ).css('opacity', '0');
			});

			$jq( "#slug" ).bind('keypress', function(e) {
				var code = (e.keyCode ? e.keyCode : e.which);
				if(code == 13) { //ENTER KEY PRESSED
					$jq( ".slug" ).html($jq( "#slug" ).val());
					$jq( "#slug" ).css('left', '-9999px');
					$jq( "#slugContainer" ).css('opacity', '100');
				}
			});
			
			//DATE ELEMENTS
			$jq( ".cal1" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
			$jq( ".cal2" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
			$jq( ".cal3" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
			$jq( ".cal4" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
			$jq( ".cal5" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
			
			$jq( ".cal1" ).focus(function() {
				$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
				$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
				$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
				$jq( "#calendarTab" ).css('display', 'block');
			});
			$jq( ".cal2" ).focus(function() {
				$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
				$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
				$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
				$jq( "#calendarTab" ).css('display', 'block');
			});
			$jq( ".cal3" ).focus(function() {
				$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
				$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
				$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
				$jq( "#calendarTab" ).css('display', 'block');
			});
			$jq( ".cal4" ).focus(function() {
				$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
				$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
				$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
				$jq( "#calendarTab" ).css('display', 'block');
			});
			$jq( ".cal5" ).focus(function() {
				$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
				$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
				$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
				$jq( "#calendarTab" ).css('display', 'block');
			});
			
			$jq( ".cal1" ).blur(function() {
				$jq( "#calendarTab" ).css('display', 'none');
				$jq( ".cal1" ).css('color', '#000');
			});
			$jq( ".cal2" ).blur(function() {
				$jq( "#calendarTab" ).css('display', 'none');
				$jq( ".cal2" ).css('color', '#000');
			});
			$jq( ".cal3" ).blur(function() {
				$jq( "#calendarTab" ).css('display', 'none');
				$jq( ".cal3" ).css('color', '#000');
			});
			$jq( ".cal4" ).blur(function() {
				$jq( "#calendarTab" ).css('display', 'none');
				$jq( ".cal4" ).css('color', '#000');
			});
			$jq( ".cal5" ).blur(function() {
				$jq( "#calendarTab" ).css('display', 'none');
				$jq( ".cal5" ).css('color', '#000');
			});
			
			//TIME ELEMENTS
			$jq('.time1').focus(function() { $jq(".time1").mask("99:99"); });
			$jq('.time2').focus(function() { $jq(".time2").mask("99:99"); });
			$jq('.time3').focus(function() { $jq(".time3").mask("99:99"); });
			$jq('.time4').focus(function() { $jq(".time4").mask("99:99"); });
			$jq('.time5').focus(function() { $jq(".time5").mask("9"); });
			
			$jq('.time1').blur(function() { $jq( ".time1" ).css('color', '#000'); });
			$jq('.time2').blur(function() { $jq( ".time2" ).css('color', '#000'); });
			$jq('.time3').blur(function() { $jq( ".time3" ).css('color', '#000'); });
			$jq('.time4').blur(function() { $jq( ".time4" ).css('color', '#000'); });
			$jq('.time5').blur(function() { $jq( ".time5" ).css('color', '#000'); });
			
			//DISABLE DATEPICKER VARIABLE POSITION
			$jq.extend($jq.datepicker,{_checkOffset:function(inst,offset,isFixed){return offset}});
			
			//TURN OFF DATEPICKER ON WINDOW RESIZE
			$jq(window).resize(function() {
				var field = $jq(document.activeElement);
				if (field.is('.cal1')) { field.datepicker('hide').datepicker('show'); }
				if (field.is('#cal2')) { field.datepicker('hide').datepicker('show'); }
				if (field.is('#cal3')) { field.datepicker('hide').datepicker('show'); }
				if (field.is('#cal4')) { field.datepicker('hide').datepicker('show'); }
				if (field.is('#cal5')) { field.datepicker('hide').datepicker('show'); }
			});
			
			//INTERACTIVE FIELDS
			$jq('select[name="limit_number_of_attendees"]').change(function(){
				if ($jq(this).attr('value')=="1") { $jq('#attendees_limit').css('display', 'inline'); } 
				else { $jq('#attendees_limit').css('display', 'none'); }
			});
			
			<? if (!$event->limit_number_of_attendees) : ?>
				$jq('#attendees_limit').css('display', 'none');
			<? endif ?>

			$jq('select[name="isRecurring"]').change(function(){
				if($jq(this).attr('value')=="1") {
					$jq('#recurrCount').css('display', 'inline');
					$jq('#recurrPeriod').css('display', 'inline');
					$jq('#recurrEnd').css('display', 'inline');
				} else {
					$jq('#recurrCount').css('display', 'none');
					$jq('#recurrPeriod').css('display', 'none');
					$jq('#recurrEnd').css('display', 'none');
				}
			});
			
			<? if (!$event->end_time_enabled) : ?>
				$jq('#end_timer_h').css('display', 'none');
				$jq('#end_timer_m').css('display', 'none');
				$jq('#end_timer_ampm').css('display', 'none');
				$jq('#end_date').css('display', 'none');
			<? endif ?>

			$jq('input[name="end_time_enabled"]').change(function(){
				if($jq(this).is(":checked")) {
					// visual
					$jq('#end_date').css('display', 'inline');
					$jq('#end_timer_h').css('display', 'inline');
					$jq('#end_timer_m').css('display', 'inline');
					$jq('#end_timer_ampm').css('display', 'inline');

		
					var start_hours = parseInt($jq('select[name="start_time_h"]').val(), 10);
					var end_hours = start_hours + 6;
					var inc_date = false;
					if ($jq('select[name="end_time_ampm"]').length) { // we are in AM/PM mode
						// 12 means 00 so + 6 will be OK, just adjust it
						if (start_hours == 12) {
							end_hours = end_hours - 12;
						}
						// if we get over 11, we must check if we are in AM or PM
						if (end_hours > 11) {
						
							if ($jq('select[name="start_time_ampm"]').val() == "AM") {
								// it's AM and +6 led us into PM
								$jq('select[name="end_time_ampm"]').val("PM");
							} else { // it's PM
								$jq('select[name="end_time_ampm"]').val("AM");
								inc_date = true;
							}
							if (end_hours > 12) { // if it's 12, leave it alone, it's OK
								end_hours = end_hours - 12;
							}
						}
					} else { // 24h mode
						if (end_hours > 23) {
							console.log(end_hours, "");
							
							end_hours = end_hours - 24;
							inc_date = true;
						}
					}
					// now to set up end_timer_h to it's proper value and to increase date if needed
					if (inc_date) {
						var date2 = $jq('#date').datepicker('getDate', '+1d'); 
				  	date2.setDate(date2.getDate()+1); 
				  	$jq('#end_date').datepicker('setDate', date2);
					} else {
					  	var date2 = $jq('#date').datepicker('getDate'); 
					  	$jq('#end_date').datepicker('setDate', date2);
					}
					
					if (end_hours < 10) end_hours = "0" + end_hours;

					$jq('select[name="end_time_h"]').val(end_hours);

					// put minutes the same 
					$jq('select[name="end_time_m"]').val($jq('select[name="start_time_m"]').val())

				} else { // uncheck
					$jq('#end_timer_h').css('display', 'none');
					$jq('#end_timer_m').css('display', 'none');
					$jq('#end_timer_ampm').css('display', 'none');
					$jq('#end_date').css('display', 'none');
				}
			});

			$jq('#end_date').change(function() {
				if ($jq('#end_date').val() < $jq('#date').val()) { 
					alert('End date must be after start date');
					$jq('#end_date').val($jq('#date').val());
				}
				check_times();
			});

			$jq('#date').change(function() {
				if ($jq('#end_date').val() < $jq('#date').val()) { 
					$jq('#end_date').val($jq('#date').val());
				}
				check_times();
			});

			$jq('select[name="start_time_h"], select[name="start_time_m"], select[name="start_time_ampm"], select[name="end_time_h"], select[name="end_time_m"], select[name="end_time_ampm"]').change(function() {
				check_times();
			});
		});
	</script>

	<form action="" method="post" class="form-validate -koowa-form" id="edit-form" enctype="multipart/form-data">

		<input type="hidden" name="id" value="<?=$event->id?>" />
		<? JUtility::getToken() ?>

		<? if (!$event->id) : ?>
			<input type="hidden" id="random_id" name="random_id" value="<?=rand()%5000?>" />
		<? endif ?>

		<input type="hidden" id="latlng" name="latlng" />
		<input type="hidden" name="registration_system" value="custom" />

		<div class="clr"></div>
				
		<div id="eventWrapper" class="clearfix">
			<div id="panelWrapper">
				<div id="adminLeft">
					<div class="panel">
						<div class="panelContent">
							<table>
								<tr <? if (!JFactory::getUser()->guest) : ?>style="display:none"<?endif?>>
									<td>
										<? $default = ''; if ($event->created_by_name) { $default = $event->created_by_name; } elseif (!JFactory::getUser()->guest) { $default = JFactory::getUser()->name; } ?>
										<span class="fieldTitle"><?=@text('OHANAH_YOUR_NAME')?></span><br/><input type="text" id="created_by_name" name="created_by_name" class="text required" value="<?=htmlspecialchars(@$default)?>" />
									</td>
									<td>
										<? $default = ''; if ($event->created_by_email) { $default = $event->created_by_email; } elseif (!JFactory::getUser()->guest) { $default = JFactory::getUser()->email; } ?>
										<span class="fieldTitle"><?=@text('OHANAH_YOUR_EMAIL')?></span><br/><input style="width:230px;" type="text" id="created_by_email" name="created_by_email" class="text required validate-email" value="<?=htmlspecialchars(@$default)?>" />
									</td>
								</tr>
								<tr>
									<td style="width:60%;" >
										<span class="fieldTitle"><?=@text('OHANAH_TITLE')?></span><br/><input type="text" id="title" name="title" class="text required" value="<?=htmlspecialchars(@$event->title)?>" />
									</td>

									<td>
										<span class="fieldTitle">&nbsp;</span><br/>
										<div class="dropdownWrapper">
											<div class="dropdown size1">
												<?=@helper('com://admin/ohanah.template.helper.listbox.categories', array('selected' => $event->ohanah_category_id)) ?>
											</div>
										</div>
									</td>
								</tr>
								<? if ($event->id) : ?>
								<tr>
									<td colspan="2">
										<div class="small" id="slugContainer">http://<?=$_SERVER['HTTP_HOST'].KRequest::base()?>/<span class="slug"><?=htmlspecialchars(@$event->slug)?></span> <a href="javascript:" id="slugEdit"><?=@text('OHANAH_EDIT')?></a></div><input type="text" id="slug" name="slug" value="<?=htmlspecialchars(@$event->slug)?>" class="text" style="width:384px">
									</td>
								</tr>
								<? endif ?>
							</table>
							<table>
								<tr>
									<td colspan="2"><span class="fieldTitle"><?=@text('OHANAH_DESCRIPTION')?></span><br/>
										<? if (JComponentHelper::getParams('com_ohanah')->get('useStandardJoomlaEditor')) : ?>			
											<?= $editorResult; ?>
										<? else : ?>
											<textarea class="description" name="description" id="description_textarea" style="border: 1px lightgray solid;"><?=$event->description?></textarea>
										<? endif ?>
									</td>
								</tr>
								<tr>
									<td><span class="fieldTitle"><?=@text('OHANAH_NAME_OF_VENUE')?></span><br/><input type="text" name="venue" id="venue" class="text size5" value="<?=$this->getService('com://admin/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?>" /></td>
									<td rowspan="2">
										<span class="fieldTitle"><?=@text('OHANAH_MAP')?></span>
										<br/>
										<?= @template('com://admin/ohanah.view.common.map', array('item' => $event, 'name' => 'event')); ?>
									</td>
								</tr>
								<tr>
									<td>
										<span class="fieldTitle"><?=@text('OHANAH_ADDRESS')?></span><br/>
										<input id="address" name="address" type="text" class="text size5" value="<?=htmlspecialchars(@$event->address)?>" />
									</td>
								</tr>
								<tr>
									<td class="ohanah-start">
										<span class="fieldTitle"><?=@text('OHANAH_START')?></span><br/>
										<? if ($event->date) $day = new KDate(new KConfig(array('date' => $event->date))); else $day = new KDate()?>
										<input name='date' type='text' value='<?=$day->getDate('%Y-%m-%d')?>' class='text formDate calendar cal1 required' id="date" style="float:left" />
										
										<? $ampm = "";
											if (JComponentHelper::getParams('com_ohanah')->get('timeFormat') == '1') $ampm = "ampm";
										?>

										<? if ($ampm) : ?>
											<div class="dropdownWrapper" id="start_timer_ampm">
												<div class="dropdown size3 time <?=$ampm?>" style="float:left;">
													<?=@helper('com://admin/ohanah.template.helper.listbox.timeAMPM', array('name' => 'start_time_ampm', 'selected' => 
																intval(substr($event->start_time, 0, 2))+1 <= 12 ? "AM" : "PM")) ?>
												</div>	
											</div>
										<? endif; ?>

										<div class="dropdownWrapper" id="start_timer_m">
											<div class="dropdown size3 time <?=$ampm?>"  style="float:left; <? if ($ampm) echo "margin-right: 12px;";?>">
												<?=@helper('com://admin/ohanah.template.helper.listbox.timeM', array('name' => 'start_time_m', 'selected' => substr($event->start_time, 3, 2))) ?>
											</div>	
										</div>

										<div class="dropdownWrapper" id="start_timer_h">
											<div class="dropdown size3 time <?=$ampm?>" style="float:left; margin-right: 12px;">

												<?
													$hour = @helper('com://admin/ohanah.template.helper.time.getHour', array('time' => $event->start_time)); 
												?>
												<?=@helper('com://admin/ohanah.template.helper.listbox.timeH', array('name' => 'start_time_h', 'selected' => $hour)) ?>
											</div>	
										</div>
									</td>
									<td class="ohanah-end" style="width:340px">
										<span class="fieldTitle"><input type="checkbox" name="end_time_enabled" value="0" <? if ($event->end_time_enabled == '1') echo 'checked' ?> /> <?=@text('OHANAH_ADD_END_TIME')?></span><br/>
										<? if ($event->end_date) $day = new KDate(new KConfig(array('date' => $event->end_date))); else $day = new KDate()?>								
										<input name='end_date' type='text' value='<?=$day->getDate('%Y-%m-%d')?>' class='text formDate calendar cal2' id="end_date" />

										<? $ampm = "";
											if (JComponentHelper::getParams('com_ohanah')->get('timeFormat') == '1') $ampm = "ampm";
										?>

										<? if ($ampm) : ?>
											<div class="dropdownWrapper" id="end_timer_ampm">
												<div class="dropdown size3 time <?=$ampm?>" style="float:left;">
													<?=@helper('com://admin/ohanah.template.helper.listbox.timeAMPM', array('name' => 'end_time_ampm', 'selected' => 
																intval(substr($event->end_time, 0, 2))+1 <= 12 ? "AM" : "PM")) ?>
												</div>	
											</div>
										<? endif; ?>

										<div class="dropdownWrapper" id="end_timer_m">
											<div class="dropdown size3 time <?=$ampm?>"  style="float:left; <? if ($ampm) echo "margin-right: 10px;";?>">
												<?=@helper('com://admin/ohanah.template.helper.listbox.timeM', array('name' => 'end_time_m', 'selected' => substr($event->end_time, 3, 2))) ?>
											</div>	
										</div>

										<div class="dropdownWrapper" id="end_timer_h">
											<div class="dropdown size3 time <?=$ampm?>" style="float:left; margin-right: 10px;">
												<? $hour = @helper('com://admin/ohanah.template.helper.time.getHour', array('time' => $event->end_time)); ?>
												<?=@helper('com://admin/ohanah.template.helper.listbox.timeH', array('name' => 'end_time_h', 'selected' => $hour)) ?>
											</div>	
										</div>

									</td>
								</tr>
							</table>
							<br />
						</div>
					</div>
				</div>
				<div id="adminRight">
					
				</div>
			</div>
		</div><br />
		<div id="" class="clearfix">
			<div id="panelWrapper">
				<div id="adminLeft" class="bottom">
					<div class="panel">
						<div class="panelContent">
							<table class="ohanah-ticketing">
								<tr>
									<td class="ohanah-ticket-cost">
										<span class="fieldTitle"><?=@text('OHANAH_COST_PER_TICKET')?></span><br/>
										<input type="text" class="text seventy" name="ticket_cost" value="<?=$event->ticket_cost?>" />

										<div class="dropdownWrapper">
											<div class="dropdown size3">
												<? if ($event->payment_currency) $default = $event->payment_currency; else $default = JComponentHelper::getParams('com_ohanah')->get('payment_currency'); ?>
												<?=@helper('com://admin/ohanah.template.helper.listbox.currency', array('selected' => $default)) ?>
												<br />
											</div>
										</div>
									</td>
									<td class="ohanah-ticket-limit">
										<span class="fieldTitle"><?=@text('OHANAH_LIMITED_AVAILABILITY_OF_TICKETS')?></span><br/>
										<div class="dropdownWrapper left">
											<div class="dropdown size4">
												<?=@helper('com://admin/ohanah.template.helper.listbox.yes_or_no', array('name' => 'limit_number_of_attendees', 'selected' => $event->limit_number_of_attendees)) ?>
											</div>
										</div>
										<input type="text" class="text" style="width:154px;" id="attendees_limit" name="attendees_limit" value="<?=$event->attendees_limit?>" />
									</td>
								</tr>

								<? if ($params->get('frontend_editing') != '0') : ?>
								<tr>
									<td class="ohanah-event-status">
										<span class="fieldTitle"><?=@text('OHANAH_EVENT_STATUS')?></span><br/>
										<div class="dropdownWrapper">
											<div class="dropdown size2">
												<?=@helper('com://admin/ohanah.template.helper.listbox.published_or_draft', array('name' => 'enabled', 'selected' => $event->enabled)) ?>
											</div>
										</div>
									</td>
								</tr>
							<? endif ?>
							</table>

							<div class="block">
								<table style="m($params->get('loadJQuery') != '0')argin-bottom:14px;" class="ohanah_form_picture">
									<tr>
										<td><span class="fieldTitle"><?=@text('OHANAH_EVENT_PICTURE')?></span><br />
											<div id="eventPicture">
												
											</div>
										</td>
										<input type="hidden" name="picture" id="picture" value="<?=$event->picture?>" />
									</tr>
								</table>
								<table class="ohanah_form_photos">
									<tr>
										<td><span class="fieldTitle"><?=@text('OHANAH_PHOTOS')?><br />
											<div id="eventPhotos">
												
											</div>
										</td>
									</tr>
								</table>
							</div> 
							<br />
						</div>
					</div>
				</div>
				<div id="adminRight" class="bottom">
					<div class="panel">
						<div class="panelContent">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="calendarTab">&nbsp;</div>

	</form>
	<? if ($event->id) : ?>
		<?= @helper('button.button', array('type' => 'input', 'text' => @text('Save event'))); ?>
	<? else : ?>
		<?= @helper('button.button', array('type' => 'input', 'text' => @text('OHANAH_ADD_EVENT'))); ?>
	<? endif ?>

	

	<script>
		$jq(function() {
			$jq('.button[name="Submit"], input[name="Submit"]').click(function() {
				if ($('edit-form').validate()) {
					$jq('.button[name="Submit"], input[name="Submit"]').attr("disabled", true); 
					if (!($jq.browser.msie && ($jq.browser.version<='8.0'))) {
						<? if ($event->id) : ?>
							$jq('.button[name="Submit"], input[name="Submit"]').text('<?=@text('Saving event', true)?>');
						<? else : ?>
							$jq('.button[name="Submit"], input[name="Submit"]').text('<?=@text('OHANAH_ADDING_EVENT', true)?>');
						<? endif ?>
					}

					<? if (JComponentHelper::getParams('com_ohanah')->get('useStandardJoomlaEditor')) : ?>
						var desc = <?=$editor->getContent('description')?>
					<? endif ?>

					<? 
					$redirectURL = '';
					if ($params->get('enable_frontend')) {
						if (JComponentHelper::getParams('com_ohanah')->get('itemid')) {
							$itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); 
						} else {
							$itemid = '';
						}

						$redirectURL = @route('option=com_ohanah&view=events&layout=yours'.$itemid);
					} else {
						$redirectURL = JComponentHelper::getParams('com_ohanah')->get('redirect_after_add_event', '');
					}
					?>

					<? if ($event->id) : ?>
						$jq.ajax({
						    type: 'post', 
							url: 'http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/index.php?option=com_ohanah&view=event&id=<?=$event->id?>',
							data: $jq('#edit-form').serialize()<? if (JComponentHelper::getParams('com_ohanah')->get('useStandardJoomlaEditor')) : ?>+'&description='+desc<? endif ?>,
						    success: function (data, text) {
								alert('<?=@text('Event saved', true)?>');
								window.location = "<?=$redirectURL?>".replace('&amp;', '&');

						    }
						});
					<? else : ?>
						$jq.ajax({
						    type: 'post', 
							url: 'http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/index.php?option=com_ohanah&view=event',
							data: $jq('#edit-form').serialize()<? if (JComponentHelper::getParams('com_ohanah')->get('useStandardJoomlaEditor')) : ?>+'&description='+desc<? endif ?>,
						    success: function (data, text) {
								alert('<?=@text('OHANAH_EVENT_ADDED', true)?>');
								window.location = "<?=$redirectURL?>".replace('&amp;', '&');
						    }
						});
					<? endif ?>
				}
			});
		});
	</script>
</div>