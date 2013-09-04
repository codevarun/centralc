<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<style src="media://com_ohanah/v2/ohanah_css/jquery.cleditor.css" />
<style src="media://com_ohanah/css/jquery-ui.css" />

<?=@helper('behavior.mootools'); ?>
<?=@helper('behavior.validator') ?>
<script src="media://lib_koowa/js/koowa.js" />
<script src="media://com_ohanah/js/jquery.cleditor.min.js" />

<?= @template('com://admin/ohanah.view.common.images', array('item' => $event, 'name' => 'event')); ?>

<?
$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';

if ($joomlaVersion == '1.5') { 
	$params = JComponentHelper::getParams('com_ohanah')->toObject();
} else {
   	$params = (json_decode(JComponentHelper::getComponent('com_ohanah')->params));
}
?>

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

	   	$jq("#description_textarea").cleditor({ width: 626, height: 113, controls: "bold italic underline bullets link unlink source"});

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

	<? if ($event->isRecurring()) : ?>
	
		<div id="toolbar-box" class="alert">
			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
			<? if ($event->recurringParent) : ?>

				<div id="toolbar" class="toolbar alert">				
					<table class="toolbar alert">
						<tbody>
							<tr>
								<td id="toolbar-about" class="button">
									<a class="toolbar" href="<?=@route('view=event&id='.$event->recurringParent)?>">
										<span title="About" class="icon-32-about"></span>
										<?=@text('OHANAH_EDIT_MASTER')?>
									</a>
								</td>

								<td id="toolbar-about" class="button">
									<a class="toolbar" href="<?=@route('view=events&recurringParent='.$event->recurringParent)?>">
									<span title="About" class="icon-32-about"></span>
										<?=@text('OHANAH_SEE_WHOLE_SERIE')?>
									</a>
								</td>

								<td id="toolbar-about" class="button">
									<a class="toolbar" href="#" id="detach-from-serie">
										<span title="About" class="icon-32-about"></span>
										<?=@text('OHANAH_DETACH_FROM_SERIE')?>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<script>
				$jq(function() {
					$jq('#detach-from-serie').click(function(){
						var input = $jq("<input>").attr("type", "hidden").attr("name", "action").val("removefromrecurringset");
						$jq('#edit-form').append($jq(input));
						$jq('#edit-form').submit();
					});
				});
				</script>

				<div class="header icon-48-alert"><?=@text('OHANAH_PART_OF_SERIES_DESC')?></div>

			<? else : ?>

				<div id="toolbar" class="toolbar alert">
					<table class="toolbar alert">
						<tbody>
							<tr>
								<td id="toolbar-about" class="button">
									<a class="toolbar" href="<?=@route('view=events&recurringParent='.$event->id)?>">
										<span title="About" class="icon-32-about"></span><?=@text('OHANAH_SEE_WHOLE_SERIE')?>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="header icon-48-alert-master"><?=@text('OHANAH_MASTER_OF_SERIES_DESC')?></div>
			<? endif ?>

				<div class="clr"></div>
			</div>

			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
		</div>
	<? endif; ?>
	<div class="clr"></div>
			
	<div id="eventWrapper" class="clearfix">
		<div id="panelWrapper">
			<div id="adminLeft">
				<div class="panel">
					<div class="panelContent">
						<table>
							<tr>
								<td style="width:60%;" >
									<span class="fieldTitle"><?=@text('OHANAH_TITLE')?></span><br/><input type="text" id="title" name="title" class="text required" value="<?=htmlspecialchars(@$event->title)?>" />

								</td>

								<td>
									<span class="fieldTitle">&nbsp;</span><br/>
									<div class="dropdownWrapper">
										<div class="dropdown size1">
											<?=@helper('com://admin/ohanah.template.helper.listbox.categories', array('name' => 'ohanah_category_id', 'selected' => $event->ohanah_category_id)) ?>
										</div>
									</div>
								</td>
							</tr>
							<? if ($event->id) : ?>
							<tr>
								<td colspan="2">
									<div class="small" id="slugContainer">http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/<span class="slug"><?=htmlspecialchars(@$event->slug)?></span> <a href="javascript:" id="slugEdit"><?=@text('OHANAH_EDIT')?></a></div><input type="text" id="slug" name="slug" value="<?=htmlspecialchars(@$event->slug)?>" class="text" style="width:384px">
								</td>
							</tr>
							<? endif ?>
						</table>
						<table>
							<tr>
								<td colspan="2"><span class="fieldTitle"><?=@text('OHANAH_DESCRIPTION')?></span><br/>
									<? if (isset($params->useStandardJoomlaEditor)) $useStandardJoomlaEditor = $params->useStandardJoomlaEditor; else $useStandardJoomlaEditor = false; ?>
									<? if ($useStandardJoomlaEditor) : ?>
										<?= @editor( array('height' => '291', 'cols' => '100', 'rows' => '20')); ?>
									<? else : ?>
										<textarea class="description" name="description" id="description_textarea"><?=$event->description?></textarea>
									<? endif ?>
								</td>
							</tr>
							<tr>
								
								<td><span class="fieldTitle"><?=@text('OHANAH_NAME_OF_VENUE')?></span><br/><input type="text" name="venue" id="venue" class="text size5" value="<? if ($event->id) echo $this->getService('com://admin/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?>" /></td>
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
								<td class="start">
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
										<div class="dropdown size3 time <?=$ampm?>"  style="float:left; <? if ($ampm) echo "margin-right: 10px;";?>">
											<?=@helper('com://admin/ohanah.template.helper.listbox.timeM', array('name' => 'start_time_m', 'selected' => substr($event->start_time, 3, 2))) ?>
										</div>	
									</div>

									<div class="dropdownWrapper" id="start_timer_h">
										<div class="dropdown size3 time <?=$ampm?>" style="float:left; margin-right: 10px;">

											<?
												$hour = @helper('com://admin/ohanah.template.helper.time.getHour', array('time' => $event->start_time)); 
											?>
											<?=@helper('com://admin/ohanah.template.helper.listbox.timeH', array('name' => 'start_time_h', 'selected' => $hour)) ?>
										</div>	
									</div>
								</td>
								
								<td style="width:340px">
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
						<div class="block">
							<? if ($event->isRecurring() && !$event->recurringParent) : ?>
							
								<table>
									<tr>
										<td>
											<span class="fieldTitle"><?=@text('OHANAH_RECURRING_EVENT')?></span><br/>
											<div class="dropdownWrapper left">
												<div class="dropdown size1">
													<select id="recurr" class="disabled" disabled><option value="Yes"><?=@text('OHANAH_YES_EVERY')?></option></select>
												</div>
											</div>
											<input type="text" name="everyNumber" class="text twenty disabled" disabled value="<? echo $event->everyNumber ? $event->everyNumber : ''; ?>" />
										</td>
										<td>
											<span class="fieldTitle">&nbsp;</span><br/>
											<div class="dropdownWrapper left">
												<div class="dropdown size4">
													<select name="everyWhat" disabled class="disabled">
														<option value="month"<? if ($event->everyWhat=='month') echo ' selected' ?>><?=@text('OHANAH_MONTHS')?></option>							
														<option value="week"<? if ($event->everyWhat=='week') echo ' selected' ?>><?=@text('OHANAH_WEEKS')?></option>
														<option value="day"<? if ($event->everyWhat=='day') echo ' selected' ?>><?=@text('OHANAH_DAYS')?></option>
														<option value="year"<? if ($event->everyWhat=='year') echo ' selected' ?>><?=@text('OHANAH_YEARS')?></option>
													</select>
												</div>
											</div>
											<input name='endOnDate' type="text" class="text formDate calendar cal5" value="<? echo $event->endOnDate ? $event->endOnDate : 'until'; ?>" >
										</td>
									</tr>
								</table>

							<? elseif (!$event->isRecurring()) : ?>

								<table>
									<tr>
										<td>
											<span class="fieldTitle"><?=@text('OHANAH_RECURRING_EVENT')?></span><br/>
											<div class="dropdownWrapper left">
												<div class="dropdown size1">
													<span id="recurr">
														<select name="isRecurring" size="1">
															<option value="1"><?=@text('OHANAH_YES_EVERY')?></option>
															<option value="0" selected="selected"><?=@text('OHANAH_NO')?></option>
														</select>
													</span>
												</div>
											</div>
											<input type="text" name="everyNumber" id="recurrCount" class="text twenty" value="<? echo $event->everyNumber ? $event->everyNumber : ''; ?>" />
										</td>
										<td>
											<span class="fieldTitle">&nbsp;</span><br/>
											<div class="dropdownWrapper left" id="recurrPeriod">
												<div class="dropdown size4">
													<select id="everyWhat" name="everyWhat">
														<option value="month"<? if ($event->everyWhat=='month') echo ' selected' ?>><?=@text('OHANAH_MONTHS')?></option>							
														<option value="week"<? if ($event->everyWhat=='week') echo ' selected' ?>><?=@text('OHANAH_WEEKS')?></option>
														<option value="day"<? if ($event->everyWhat=='day') echo ' selected' ?>><?=@text('OHANAH_DAYS')?></option>
														<option value="year"<? if ($event->everyWhat=='year') echo ' selected' ?>><?=@text('OHANAH_YEARS')?></option>
													</select>
												</div>
											</div>
											<input name='endOnDate' type="text" class="text formDate calendar cal5" value="<? echo $event->endOnDate ? $event->endOnDate : 'until'; ?>" id="recurrEnd">
										</td>
									</tr>
								</table>
							<? endif ?>
							<br />
						</div> 
						<br />
					</div>
				</div>
			</div>
			<div id="adminRight">
				<div class="panel">
					<div class="panelContent">
						<table style="margin-bottom:14px;">
							<tr>
								<td><span class="fieldTitle"><?=@text('OHANAH_EVENT_PICTURE')?></span><br />
									<div id="eventPicture">
										
									</div>
								</td>
								<input type="hidden" name="picture" id="picture" value="<?=$event->picture?>" />
							</tr>
						</table>
						<table>
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_PHOTOS')?></span><br />
									<div id="eventPhotos">
										
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
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_COST_PER_TICKET')?></span><br/>
									<input type="text" class="text seventy" name="ticket_cost" value="<?=$event->ticket_cost?>" />
									<div class="dropdownWrapper">
										<div class="dropdown size3">											
											<? if ($event->payment_currency) $default = $event->payment_currency; else $default = $params->payment_currency; ?>
											<?=@helper('com://admin/ohanah.template.helper.listbox.currency', array('selected' => $default)) ?>
											<br />
										</div>
									</div>
								</td>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_LIMITED_AVAILABILITY_OF_TICKETS')?></span><br/>
									<div class="dropdownWrapper left">
										<div class="dropdown size4">
											<?=@helper('com://admin/ohanah.template.helper.listbox.yes_or_no', array('name' => 'limit_number_of_attendees', 'selected' => $event->limit_number_of_attendees)) ?>
										</div>
									</div>
									<input type="text" class="text" style="width:154px;" id="attendees_limit" name="attendees_limit" value="<?=$event->attendees_limit?>" />

									<br />
									<? if (isset(@$event->allow_only_one_ticket)) $default = $event->allow_only_one_ticket; else { if (isset($params->allow_only_one_ticket)) $default = $params->allow_only_one_ticket; else $default = '0'; } ?>
									<span class="fieldTitle"><input type="checkbox" name="allow_only_one_ticket" value="0" <? if ($default == 1) echo 'checked' ?> /> <?=@text('Allow only 1 ticket per registration')?></span><br/>

								</td>
							</tr>
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_SYSTEM')?></span><br/>
									<table>
										<tr>
											<td>
												<div class="dropdownWrapper left">
													<div class="dropdown size1">
														<?
														$options = array();
														$option = new KObject(); $option->text = @text('OHANAH_BUILT_IN'); $option->value = 'ohanah'; $options[0] = $option;
														$option = new KObject(); $option->text = @text('OHANAH_CUSTOM'); $option->value= 'custom'; $options[1] = $option;
														?>
														<? if (@$event->registration_system) $default = $event->registration_system; else { if (isset($params->registration_system)) $default = $params->registration_system; else $default = 'ohanah'; } ?>
														<?= @helper('select.optionlist', array('name' => 'registration_system',  'options' => $options, 'selected' => $default)); ?><br />

														<script>
															$jq(function() {
																$jq('select[name="registration_system"]').change(function(){
																	if ($jq(this).attr('value')=='ohanah') { 
																		$jq('.ohanah-registration-enabled-div').show(); 
																		$jq('#ohanah-registration-disabled-div').hide(); 
																	} 
																	else { 
																		$jq('.ohanah-registration-enabled-div').hide(); 
																		$jq('#ohanah-registration-disabled-div').show(); 
																	}
																});

																<? if ($default == 'ohanah') : ?>
																	$jq('.ohanah-registration-enabled-div').show();
																	$jq('#ohanah-registration-disabled-div').hide();
																<? else : ?>
																	$jq('.ohanah-registration-enabled-div').hide();
																	$jq('#ohanah-registration-disabled-div').show();
																<? endif ?>
															});
														</script>	
													</div>
												</div>
											<td>
										</tr>
									</table>
								</td>
								<td class="ohanah-registration-enabled-div">
									<div>
										<span class="fieldTitle"><?=@text('OHANAH_REGISTRATION_FORM_CUSTOM_FIELDS')?> <a id="onemorecustomfield" style="color:#379DE7; cursor:pointer;"><?=@text('OHANAH_ADD_NEW_PARENTHESIS')?></a>
										<br /><span style="font-weight: normal"><?=@text('OHANAH_NAME_AND_EMAIL_ALREADY_ASKED')?></span>
										</span><br/>

										<ul class="registrationfield-list">
											<? if ($event->customfields) : ?>
												<? $custom_fields = new JParameter($event->customfields); ?>
												<? for ($i = 1; $i <= 10; $i++) : ?>
													<? if ($cfvalue = $custom_fields->get('custom_field_label_'.$i)) : ?>
														<? if ($cf = $custom_fields->get('cf'.$i) != null) $checked = $cf; else $checked = 0; ?>
														<? $mandatory = $custom_fields->get('custom_field_label_'.$i.'_mandatory'); ?>
														<li class="customfield">
															<img src="media://com_ohanah/v2/ohanah_images/icon-x.png" class="remove_custom_field" />
															<input type="hidden" id="custom_field_label_<?=$i?>" name="custom_field_label_<?=$i?>" value="<?=$cfvalue?>" />
															<input type="hidden" name="cf<?=$i?>" value="yes" <? if ($checked) echo 'checked'; ?> />
															<input type="text" id="custom_field_label_<?=$i?>" name="custom_field_label_<?=$i?>" class="text size5" style="width:150px!important" value="<?=$cfvalue?>" disabled />
															<input type="checkbox" name="custom_field_label_<?=$i?>_mandatory" value="yes" <? if ($mandatory) echo 'checked'; ?> /> <?=@text('OHANAH_MANDATORY')?>
														</li>
													<? endif; ?>
												<? endfor ?>
											<? else : ?>
												<? $custom_fields = new JParameter($event->customfields); ?>
												<? for ($i = 1; $i <= 10; $i++) : ?>
													<? if ($cfvalue = JComponentHelper::getParams('com_ohanah')->get('custom_field_label_'.$i)) : ?>
														<? $mandatory = JComponentHelper::getParams('com_ohanah')->get('custom_field_label_'.$i.'_mandatory'); ?>
														<li class="customfield">
															<img src="media://com_ohanah/v2/ohanah_images/icon-x.png" class="remove_custom_field" />
															<input type="hidden" id="custom_field_label_<?=$i?>" name="custom_field_label_<?=$i?>" value="<?=$cfvalue?>" />
															<input type="hidden" name="cf<?=$i?>" value="yes" checked />
															<input type="text" id="custom_field_label_<?=$i?>" name="custom_field_label_<?=$i?>" class="text size5" style="width:150px!important" value="<?=$cfvalue?>" disabled />
															<input type="checkbox" name="custom_field_label_<?=$i?>_mandatory" value="yes" <? if ($mandatory) echo 'checked'; ?> /> <?=@text('OHANAH_MANDATORY')?>
														</li>
													<? endif; ?>
												<? endfor ?>
											<? endif ?>
											<span id="onemorecustomfieldcontent"></span>

										</ul>

										<script>
											var $jq = jQuery.noConflict();  

											$jq(function() {
												if ($jq('.customfield').length >= 10) {
													$jq('#onemorecustomfield').hide();
												}
											});

											$jq(function() {
												$jq('.remove_custom_field').live('click', function(){
													$jq(this).next('input.text').val('');
													$jq(this).closest('li').remove();

													if ($jq('.customfield').length < 10) {
														$jq('#onemorecustomfield').show();
													}										
												});	
											});

											$jq(function() {
											    $jq('#onemorecustomfield').click(function() {
											    	var i = 1; 
											    	for (i = 1; i <= 10; i++) { 
											    		if ($jq('#custom_field_label_'+i).length == 0) {
															$jq('#onemorecustomfieldcontent').append('<li class="customfield"><img src="media://com_ohanah/v2/ohanah_images/icon-x.png" class="remove_custom_field" /><input type="hidden" name="cf'+i+'" value="yes" checked />&nbsp;<input type="text" id="custom_field_label_'+i+'" name="custom_field_label_'+i+'" class="text size5" style="width:150px!important" value="" /> <input type="checkbox" name="custom_field_label_'+i+'_mandatory" value="yes" /> <?=@text('OHANAH_MANDATORY')?></li>');
															break;
											    		}
											    	}
											    	if ($jq('.customfield').length >= 10) { 
														$jq('#onemorecustomfield').hide();
													}
												});
											});
										</script>
									</div>
								</td>
								<td id="ohanah-registration-disabled-div">
									<span class="fieldTitle"><?=@text('OHANAH_CUSTOM_REGISTRATION_URL')?></span><br/>
									<input type="text" class="text size5" name="custom_registration_url" value="<?=$event->custom_registration_url?>" />
								</td>
							</tr>
							<tr class="ohanah-registration-enabled-div">
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_PAYMENT_GATEWAY')?></span><br/>
											<div class="dropdownWrapper left">
												<div class="dropdown size1">
													<?
													$options = array();
													$option = new KObject(); $option->text = "PayPal"; $option->value="paypal"; $options[0] = $option;
													$option = new KObject(); $option->text = "None"; $option->value="none"; $options[1] = $option;
													$option = new KObject(); $option->text = "Custom"; $option->value="custom"; $options[2] = $option;
													?>
													<? if (@$event->payment_gateway) $default = $event->payment_gateway; else { if (isset($params->payment_gateway)) $default = $params->payment_gateway; else $default = 'paypal'; } ?>

													<?= @helper('select.optionlist', array('name' => 'payment_gateway',  'options' => $options, 'selected' => $default)); ?><br />
												</div>
											</div>
									
			
									<script>
										$jq(function() {
											$jq('select[name="payment_gateway"]').change(function(){
												if ($jq(this).attr('value')=='paypal') { 
													$jq('#custom-payment-enabled-div').hide(); 
												} 
												if ($jq(this).attr('value')=='custom') { 
													$jq('#custom-payment-enabled-div').show(); 
												} 
												else { 
													$jq('#custom-payment-enabled-div').hide(); 
												}
											});

											<? if ($default != 'custom') : ?>
												$jq('#custom-payment-enabled-div').hide();
											<? endif ?>
										});
									</script>
								</td>
								<td id="custom-payment-enabled-div">
									<span class="fieldTitle"><?=@text('OHANAH_CUSTOM_PAYMENT_URL')?></span><br/>
									<input type="text" class="text size5" name="custom_payment_url" value="<?=$event->custom_payment_url?>" />
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
						<table>
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_WHO_CAN_REGISTER')?></span><br/>
									<div class="dropdownWrapper">
										<div class="dropdown size2">
											<select name="who_can_register">
												<option value='0' <? if ($event->who_can_register=='0') echo 'selected' ?>><?=@text('OHANAH_EVERYBODY')?></option>
												<option value='1' <? if ($event->who_can_register=='1') echo 'selected' ?>><?=@text('OHANAH_SITE_MEMBERS_ONLY')?></option>
												<option value='2' <? if ($event->who_can_register=='2') echo 'selected' ?>><?=@text('OHANAH_NOBODY')?></option>
											</select>
										</div>
									</div>
								</td>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_CLOSE_REGISTRATIONS_ON')?></span><br/>
									<input type="text" name="close_registration_day" class="text formDate calendar cal4" id="enddate2" value="<? echo ($event->close_registration_day != '0000-00-00') ? $event->close_registration_day : 'day'; ?>" style="float:left; width: 91% !important;">
								</td>
							</tr>		
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_EVENT_STATUS')?></span><br/>
									<div class="dropdownWrapper">
										<div class="dropdown size2">
											<?=@helper('com://admin/ohanah.template.helper.listbox.published_or_draft', array('name' => 'enabled', 'selected' => $event->enabled)) ?>
										</div>
									</div>
								</td>
							</tr>
							<? if (isset($params->enableMailchimp)) : ?>
								<? if ($params->enableMailchimp && $params->mailchimpApiKey) : ?>
								<tr>
									<td>
										<span class="fieldTitle"><?=@text('OHANAH_MAILCHIMP_LIST_ID')?></span><br/>
										<div class="dropdownWrapper">
											<div class="dropdown size2">
												<input type="text" name="mailchimp_list_id" class="text" id="mailchimp_list_id" value="<?=@$event->mailchimp_list_id?>" style="float:left; width: 91% !important;">
											</div>
										</div>
									</td>
								</tr>
								<? endif ?>
							<? endif ?>
						</table>
					</div>
				</div>
			</div>
</div></div></span></td></tr></table></div></div></div></div></div>
	<div id="calendarTab">&nbsp;</div>
</form>


