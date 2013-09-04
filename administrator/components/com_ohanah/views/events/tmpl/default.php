<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<?=@helper('behavior.mootools'); ?>
<?=@helper('behavior.tooltip'); ?>

<script src="media://lib_koowa/js/koowa.js" />

<form action="" method="get" class="-koowa-grid">
	<div id="filterHeader">
		<div class="filter">Filter: <?=@helper('grid.search');?></div>					
		<div class="dropdownWrapper">
			<div class="dropdown size1">
				<?= @helper('com://admin/ohanah.template.helper.listbox.categories', array('name' => 'ohanah_category_id', 'attribs' => array('onchange' => 'this.form.submit();'))); ?>
			</div>
		</div>
		<div id="selectors">
			<ul class="selector">
				<li <? if ((KRequest::get('get.filterEvents', 'string') == 'notpast' || KRequest::get('get.filterEvents', 'string') == '') && KRequest::get('get.frontend_submitted', 'string') == '' && KRequest::get('get.published', 'string') == '') echo 'class="active"'; ?>>
					<a href="<?=@route('&filterEvents=notpast&published=&frontend_submitted=&ohanah_venue_id=')?>"><?=@text('OHANAH_UPCOMING')?></a>
				</li>
				<li <? if (KRequest::get('get.filterEvents', 'string') == 'past') echo 'class="active"'; ?>>
					<a href="<?=@route('&filterEvents=past&published=&frontend_submitted=&ohanah_venue_id=')?>"><?=@text('OHANAH_PAST')?></a>
				</li>
				<? if (KRequest::get('get.published', 'string') == 'true') : ?>
					<li <? if (KRequest::get('get.published', 'string')) echo 'class="active"'; ?>>
						<a href="<?=@route('&filterEvents=&published=false&frontend_submitted=&ohanah_venue_id=')?>"><?=@text('OHANAH_UNPUBLISHED')?></a>
					</li>
				<? else : ?>
					<li <? if (KRequest::get('get.published', 'string') && !KRequest::get('get.frontend_submitted', 'string')) echo 'class="active"'; ?>>
						<a href="<?=@route('&filterEvents=&published=true&frontend_submitted=&ohanah_venue_id=')?>"><?=@text('OHANAH_PUBLISHED')?></a>
					</li>
				<? endif ?>
				<? if (JComponentHelper::getParams('com_ohanah')->get('moderation')) : ?>
					<li <? if (KRequest::get('get.published', 'string') == 'false') echo 'class="active"'; ?>>
						<a href="<?=@route('&filterEvents=&frontend_submitted=1&published=false&ohanah_venue_id=')?>"><?=@text('OHANAH_PENDING')?></a>
					</li>
				<? endif ?>
			</ul>
		</div>
	</div>
	<div id="tableWrapper">
		<table>	
			<? if (count($events)) : ?>
				<?= @template('default_events', array('events' => $events)); ?>
			<? else : ?>
				<tr>			
					<td colspan="8" align="center">
						<?= @text('OHANAH_NO_ITEMS_FOUND'); ?>
					</td>
				</tr>
			<? endif ?>
		</table>
	</div>
	<?= @helper('paginator.pagination', array('total' => $total)) ?>
</form>