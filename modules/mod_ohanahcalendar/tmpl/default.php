<? 
if(!function_exists('getDaysBetweenDates')) {
	function getDaysBetweenDates($event) {  
		$days[] = substr($event->date,0,10);
		
		if ($event->end_time_enabled) {

			$sStartDate = $event->date;
			$sEndDate = $event->end_date;

			$sStartDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($event->date)));  	

			$sCurrentDate = $event->date;

			if (substr($event->date,0,10) != substr($event->end_date,0,10)) {
				while(substr($sCurrentDate,0,10) < substr($event->end_date,0,10)){  
					$oldCurrentDate = $sCurrentDate;
					if ($oldCurrentDate == gmdate("Y-m-d", strtotime("+1 days", strtotime($sCurrentDate)))) 
						$sCurrentDate = gmdate("Y-m-d", strtotime("+2 days", strtotime($sCurrentDate)));
					else 
				  		$sCurrentDate = gmdate("Y-m-d", strtotime("+1 days", strtotime($sCurrentDate)));
				  	$days[] = $sCurrentDate;  
				}
			}
		}	

		return $days; 
	}
}
?>


<? if ((JComponentHelper::getParams('com_ohanah')->get('loadJQuery') != '0')) : ?>
	<script src="media://com_ohanah/js/jquery.min.js" />
	<? JFactory::getApplication()->set('jquery', true); ?>
<? endif; ?>

<style src="media://com_ohanah/css/calendartheme.css" />
<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />


<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = ''; ?>

<? $uniqueModuleId = (rand()%9999);?>
<style>
	<? if ($activecalbgcolor = $params->get('activecalbgcolor', 'green')) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> a.ui-state-hover,
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .markedDay a.ui-state-default {
		background: <?=$activecalbgcolor?> !important;
		<? endif; ?>
		<? if ($activecaltextcolor = $params->get('activecaltextcolor', 'black')) : ?>
		color: <?=$activecaltextcolor?> !important ;
		text-shadow:none !important;

	}
	<? endif; ?>
	
	<? if ($activecaltextcolor = $params->get('activecaltextcolor', 'black')) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .markedDay a.ui-state-hover,
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .markedDay a.ui-state-default {
		color: <?=$activecaltextcolor?> !important ;

		text-shadow:none !important;
	}
	<? endif; ?>

	<? if ($params->get('showheader') == 0) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .ui-datepicker .ui-datepicker-header {
	 display: none;
	}
	<? endif; ?>

	<? if ($params->get('prevnext') == 0) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .ui-datepicker-prev, 
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .ui-datepicker-next {
		display: none;
	}
	<? endif; ?>

	<? if ($width = $params->get('width')) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .ui-datepicker {
		width: <?=$width?>px !important;
	}
	<? endif; ?>


</style>

<?
$date = new KDate();
$year = $date->getDate('%Y');
if ($params->get('year'))
	$year = $params->get('year');

$month = $date->getDate('%m');
if ($params->get('month'))
	$month = $params->get('month');
?>


<?
$config =& JFactory::getConfig();
$language = $config->getValue('config.language');
$orig_language = $language;
$languagesSupportedByjQueryUI = array('af', 'ar', 'az', 'bg', 'bs', 'ca', 'cs', 'da', 'de-CH', 'de', 'el', 'en-GB', 'eo', 'es', 'et', 'eu', 'fa', 'fi', 'fo', 'fr-CH', 'fr', 'he', 'hr', 'hu', 'hy', 'id', 'is', 'it', 'ja', 'ko', 'lt', 'lv', 'ms', 'nl-BE', 'nl', 'no', 'pl', 'pt-BR', 'ro', 'ru', 'sk', 'sl', 'sq', 'sr-SR', 'sr', 'sv', 'ta', 'th', 'tr', 'uk', 'vi', 'zh-CN', 'zh-HK', 'zh-TW');

if (in_array($orig_language, $languagesSupportedByjQueryUI)) {
	$language = $orig_language;
}
else {

	if (in_array(strtolower(substr($orig_language, -2, 2)), $languagesSupportedByjQueryUI)) {
		$language = strtolower(substr($orig_language, -2, 2));
	} else {
		if (in_array(substr($orig_language, 0, 2), $languagesSupportedByjQueryUI))
			$language = substr($orig_language, 0, 2);
		else
			$language = 'en';
	}
}
// fix because googlecode don't have portuguese (portugal) as language and brazilian and portuguese are the same in this matter
if ($orig_language == "pt-PT") {$language = "pt-BR";}

?>

<script src="http://jquery-ui.googlecode.com/svn/trunk/ui/i18n/jquery.ui.datepicker-<?=$language?>.js" />

<script>
var $jq = jQuery.noConflict();  
$jq(function() {
	
	$jq.datepicker.setDefaults( $jq.datepicker.regional[ "<?=$language?>" ] );
	
	$jq("#ohanah-module-calendar-date-<?=$uniqueModuleId?>").datepicker({
        dateFormat: 'yy-mm-dd',
        firstDay: '<?=$params->get('firstDay')?>',
        showOtherMonths: 'true',
        beforeShowDay: daysToMark,
   		onSelect: daySelected<?=$uniqueModuleId?>,
		changeMonth: false,
		changeYear: false
	});

	<?
	$daysWithEvents = array();

	if (($params->get('allevents')) == 0 && $params->get('eventcatid'))
		foreach (@service('com://site/ohanah.model.events')->set('enabled', 1)->set('ohanah_category_id', $params->get('eventcatid'))->getList() as $event)
			$daysWithEvents = array_merge($daysWithEvents, getDaysBetweenDates($event));
	else
		foreach (@service('com://site/ohanah.model.events')->set('enabled', 1)->getList() as $event)
			$daysWithEvents = array_merge($daysWithEvents, getDaysBetweenDates($event));

	$daysWithEvents = array_unique($daysWithEvents);
	?>

	function daySelected<?=$uniqueModuleId?>(dateText, inst) {
		
		var formattedDate = dateText;
		var arrayOfDates = [<?$first = true; foreach ($daysWithEvents as $day) { if (!$first) echo ','; echo "'".$day."'"; $first = false;}?>];

		if ($jq.inArray(formattedDate, arrayOfDates) != -1) {
			window.location = 'http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/index.php?option=com_ohanah&view=events&calendar_start_date='+dateText+'&calendar_end_date='+dateText+'<?=$itemid?>&filterEvents=';
		}
	}

	function daysToMark(date) {		
		var dayDate = date.getDate();
		if (dayDate < 10) dayDate = '0'+dayDate;
		var monthDate = date.getMonth() + 1;
		if (monthDate < 10) monthDate = '0'+monthDate;

		var formattedDate = (date.getFullYear() + '-'+monthDate+'-' + dayDate);
		var arrayOfDates = [<?$first = true; foreach ($daysWithEvents as $day) { if (!$first) echo ','; echo "'".$day."'"; $first = false;}?>];

		if ($jq.inArray(formattedDate, arrayOfDates) != -1) {
		    return [true, 'markedDay', ""];
		} else return [true, '', ""]; //return false to disable the box if the day is not marked
	}
});
</script>

<div id='ohanah-module-calendar-date-<?=$uniqueModuleId?>'></div>
<div id='ohanah-module-calendar-after-calendar-<?=$uniqueModuleId?>'></div>