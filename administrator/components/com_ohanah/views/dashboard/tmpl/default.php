<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<script>
	$jq(function() {
		$jq('#toolbar-updates').click(function() {	
			$jq('#toolbar-updates').hide();
			$jq('#toolbar-dashboard').append('<img class="loader-image" src="http://<?=$_SERVER['HTTP_HOST'].str_replace('/administrator', '', KRequest::base())?>/media/com_ohanah/images/loader.gif" />');
			$jq.get('index.php?option=com_ohanah&view=dashboard&layout=checkversion',
				'',
				function(response, status) {
					$jq('.loader-image').hide();
					$jq('#toolbar-updates').show();
					alert(response);
				}
			);
		});
	});
</script>

<style>
#submenu-box .m { display: none;}
</style>

<div id="dashboard">
	<div class="bigIcon">
		<a href="<?=@route('view=events')?>" class="events-icon"><div><?=@text('EVENTS')?></div></a>
	</div>
	<div class="bigIcon">
		<a href="<?=@route('view=venues')?>" class="venues-icon"><div><?=@text('VENUES')?></div></a>
	</div>
	<div class="bigIcon">
		<a href="<?=@route('view=categories')?>" class="categories-icon"><div><?=@text('CATEGORIES')?></div></a>
	</div>
	<div class="bigIcon">
		<a href="<?=@route('view=config')?>" class="settings-icon"><div><?=@text('SETTINGS')?></div></a>
	</div>
	<div class="bigIcon">
		<a href="<?=@route('view=help')?>" class="extensions-icon"><div><?=@text('HELP')?></div></a>
	</div>
</div>

<div class="clr"></div>

<p class="copyright">
	ohanah app for joomla  

<?
$xml = simplexml_load_file(JPATH_ADMINISTRATOR .'/components/com_ohanah/manifest.xml');
if ($xml) echo $xml->version;
?>
</p>