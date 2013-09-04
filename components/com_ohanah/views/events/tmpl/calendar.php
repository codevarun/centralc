<? defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="ohanah">
	<? if ((JComponentHelper::getParams('com_ohanah')->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
		<script src="media://com_ohanah/js/jquery.min.js" />
		<? JFactory::getApplication()->set('jquery', true); ?>
	<? endif; ?>
	<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />
	<script src="media://com_ohanah/js/fullcalendar.min.js" />
	<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<style src="media://com_ohanah/css/calendartheme.css" />
	<style src="media://com_ohanah/css/screen.css" />
	<style src="media://com_ohanah/css/fullcalendar.css" />

	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-list-events-1', 'position' => $params->get('listEventsModulePosition1'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-list-events-2', 'position' => $params->get('listEventsModulePosition2'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-list-events-3', 'position' => $params->get('listEventsModulePosition3'))) ?>	

	<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = ''; ?>

	<script>
		var $jq = jQuery.noConflict();  
		$jq(function () {
			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();
			
			$jq('#calendar').fullCalendar({
				<? if ($year = JFactory::getApplication()->getPageParameters()->get('year')) : ?>year: <?=$year?>,<? endif; ?>
				<? if ($month = JFactory::getApplication()->getPageParameters()->get('month')) : ?>month: <?=$month-1?>,<? endif; ?>
				<? if ($day = JFactory::getApplication()->getPageParameters()->get('day')) : ?>date: <?=$day?>,<? endif; ?>
				theme: true,
				firstDay: <?=JFactory::getApplication()->getPageParameters()->get('firstDay', '1')?>,
				<? if (JFactory::getApplication()->getPageParameters()->get('dayBeforeTheMonth') == '1') : ?>
				columnFormat: {
				    month: 'ddd',    // Mon
				    week: 'ddd d/M', // Mon 9/7
				    day: 'dddd d/M'
				},
				<? endif; ?>
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: false,
				defaultView: '<?=JFactory::getApplication()->getPageParameters()->get('defaultView', 'month')?>',
				allDayDefault: false,
				allDaySlot: false,
				slotMinutes: 60,
				events: '<?=KRequest::root()?>/index.php?option=com_ohanah&view=events&format=json&layout=calendar<? if (JFactory::getApplication()->getPageParameters()->get('showAddressOfEvents') == '1') : ?>&showAddressOfEvents=1<?endif;?>',			
    			eventRender: function(event, element, view) {
    				if (event.limit_number_of_attendees !== "0" && (event.numberOfAttendees >= event.attendees_limit)) {
    					element.addClass('event-is-full');
    				}
				},
				timeFormat: '<? if (JFactory::getApplication()->getPageParameters('com_ohanah')->get('showTime', 1) != '0') : ?><? if (JComponentHelper::getParams('com_ohanah')->get('timeFormat') == '1') : ?>h(:mm)tt<? else : ?>HH:mm<? endif; ?><?endif;?>', // uppercase H for 24-hour clock			    
				axisFormat: '<? if (JComponentHelper::getParams('com_ohanah')->get('timeFormat', '12hours') == '1') : ?>h(:mm)tt<? else : ?>HH:mm<? endif; ?>', // uppercase H for 24-hour clock			    
				eventClick: function(event) {
					var url = '<?=KRequest::root()?>/index.php?option=com_ohanah&view=event&id='+ event.id+'&Itemid=<?=$itemid?>';
					if (url) {
						window.open(url,'_parent');
						return false;
					}
				},
				buttonText: {
					month: '<?=addslashes(@text('Month'))?>',
					day: '<?=addslashes(@text('Day'))?>',
					year: '<?=addslashes(@text('Year'))?>',
					today: '<?=addslashes(@text('Today'))?>',
					week: '<?=addslashes(@text('Week'))?>'
				},
				allDayText: '<?=addslashes(@text('OHANAH_ALL_DAY'))?>',
				monthNames: [				
					'<?=addslashes(@text('January'))?>',
					'<?=addslashes(@text('February'))?>',
					'<?=addslashes(@text('March'))?>',
					'<?=addslashes(@text('April'))?>',
					'<?=addslashes(@text('May'))?>',
					'<?=addslashes(@text('June'))?>',
					'<?=addslashes(@text('July'))?>',
					'<?=addslashes(@text('August'))?>',
					'<?=addslashes(@text('September'))?>',
					'<?=addslashes(@text('October'))?>',
					'<?=addslashes(@text('November'))?>',
					'<?=addslashes(@text('December'))?>'
				],
				dayNames: [				
					'<?=addslashes(@text('Sunday'))?>',				
					'<?=addslashes(@text('Monday'))?>',				
					'<?=addslashes(@text('Tuesday'))?>',				
					'<?=addslashes(@text('Wednesday'))?>',				
					'<?=addslashes(@text('Thursday'))?>',				
					'<?=addslashes(@text('Friday'))?>',				
					'<?=addslashes(@text('Saturday'))?>'				
				],
				dayNamesShort: [				
					'<?=addslashes(@text('Sun'))?>',
					'<?=addslashes(@text('Mon'))?>',
					'<?=addslashes(@text('Tue'))?>',
					'<?=addslashes(@text('Wed'))?>',
					'<?=addslashes(@text('Thu'))?>',
					'<?=addslashes(@text('Fri'))?>',
					'<?=addslashes(@text('Sat'))?>'
				]
			});
		});
	</script>
	
	<div id='calendar'></div>
</div>