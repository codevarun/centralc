<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<?=@helper('behavior.mootools'); ?>
<?=@helper('behavior.tooltip'); ?>

<script src="media://lib_koowa/js/koowa.js" />

<style>
#submenu-box .m { display: none;}
</style>

<? $registrations = $this->getService('com://admin/ohanah.model.registrations')->set('ohanah_event_id', KRequest::get('get.ohanah_event_id', 'string'))->set('hasPaid', KRequest::get('get.hasPaid', 'string'))->getList() ?>

<? $count = 0; ?>
<? foreach ($registrations as $registration) { if (!$registration->paid) $count++; } ?>
<? if ($count) : ?>
<div id="toolbar-box" class="alert">
	<div class="t">
		<div class="t">
			<div class="t"></div>
		</div>
	</div>
	<div class="m">
		<div id="toolbar" class="toolbar alert">				
			<table class="toolbar alert">
				<tbody>
					<tr>
						<td id="toolbar-about" class="button">
							<? $link = 'view=registrations&layout=sendmail&ohanah_event_id='.KRequest::get('get.ohanah_event_id', 'int'); ?>
							<? foreach ($registrations as $registration) if (!$registration->paid) $link .= '&id[]='.$registration->id; ?>
							<a class="toolbar" href="<?=@route($link)?>">
								<span title="About" class="icon-32-about"></span>
								<?=@text('OHANAH_SEND_A_REMINDER')?>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="header icon-48-alert-ticket">			
			<? if ($count == 1) : ?>
				<?=@text('OHANAH_PERSON_HASNT_PAID_YET_SINGULAR')?>
			<? else : ?>
				<?=JText::sprintf('OHANAH_PERSON_HASNT_PAID_YET_PLURAL', $count)?>
			<? endif ?>
		</div>
	</div>
</div>
<? endif; ?>


<form action="" method="get" class="-koowa-grid">

	<div id="filterHeader">
		<!--<div class="filter">Filter: <?=@helper('grid.search');?></div>-->
							
		<div id="selectors">
			<ul class="selector">
				<li <? if (!KRequest::get('get.hasPaid', 'string')) echo 'class="active"'; ?>><a href="<?=@route('&hasPaid=')?>"><?=@text('OHANAH_ALL')?></a></li>
				<li <? if (KRequest::get('get.hasPaid', 'string') == 'true') echo 'class="active"'; ?>><a href="<?=@route('&hasPaid=true')?>"><?=@text('OHANAH_PAID')?></a></li>
				<li <? if (KRequest::get('get.hasPaid', 'string') == 'false') echo 'class="active"'; ?>><a href="<?=@route('&hasPaid=false')?>"><?=@text('OHANAH_UNPAID')?></a></li>
			</ul>
		</div>
	</div>

	<div id="tableWrapper">
		<table>	
			<? if (count($registrations)) : ?>
				<?= @template('default_registrations', array('registrations' => $registrations)); ?>
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