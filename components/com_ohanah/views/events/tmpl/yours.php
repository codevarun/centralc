<?
// Load language file
$lang = &JFactory::getLanguage();
$lang->load('com_ohanah');
$lang->load('com_ohanah', JPATH_ADMINISTRATOR);
?>

<ul>
<? foreach (@service('com://site/ohanah.model.events')->set('created_by', $user->id)->getList() as $event) : ?>
  <li>
    <? if ($event->enabled) : ?>
      <a href="<?=@route('view=event&id='.$event->id)?>"><?=$event->title?></a> 
    <? else : ?>
      <?=$event->title?>
    <? endif ?>

    (<?=$event->date?>) 
    <? if (!$event->enabled) : ?>
      <span style="color:red"> [<?=@text('OHANAH_UNPUBLISHED')?>]</span>
    <? else : ?>
      <span style="color:green"> [<?=@text('OHANAH_PUBLISHED')?>]</span>
    <? endif ?>
    <a href="<?=@route('view=event&layout=form&id='.$event->id)?>">[edit]</a>
  </li>
<? endforeach; ?>
</ul>
