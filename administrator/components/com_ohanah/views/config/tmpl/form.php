<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<style src="media://com_ohanah/v2/ohanah_css/jquery.cleditor.css" />
<style src="media://com_ohanah/css/jquery-ui.css" />

<?=@helper('behavior.mootools'); ?>
<?=@helper('behavior.validator') ?>
<script src="media://lib_koowa/js/koowa.js" />

<style>
#submenu-box .m { display: none;}
</style>

<script>
	$jq(function() {    
		$jq('#ohanah-config-layoutcomposer').hide();
		$jq('#ohanah-config-email').hide();
		$jq('#ohanah-config-injector').hide();
		$jq('#ohanah-config-registration').hide();
		$jq('#ohanah-config-time').hide();
		$jq('#ohanah-config-frontend').hide();
	
	    $jq("#settingsLeft a").click(function(){
	    	var divname= this.name;
	    	$jq("#"+divname).show().siblings().hide();
	    	$jq("#settingsLeft a").removeClass('active');
	    	this.addClass('active');
	    });
	});
</script> 

<!-- BEGIN FORM VIEW -->
<form action="" method="post" class="form-validate -koowa-form" id="edit-form" enctype="multipart/form-data">
	<div id="settingsWrapper" class="clearfix">
		<div id="settingsLeft">
			<ul>
				<li><a href="#" name="ohanah-config-layout" class="active"><?=@text('OHANAH_LAYOUT');?></a></li>
				<li><a href="#" name="ohanah-config-layoutcomposer"><?=@text('Layout composer');?></a></li>
				<li><a href="#" name="ohanah-config-email"><?=@text('OHANAH_EMAIL_CUSTOMIZATION');?></a></li>
				<li><a href="#" name="ohanah-config-injector"><?=@text('OHANAH_MODULE_INJECTOR');?></a></li>
				<li><a href="#" name="ohanah-config-registration"><?=@text('OHANAH_REGISTRATION_AND_PAYMENT');?></a></li>
				<li><a href="#" name="ohanah-config-time"><?=@text('OHANAH_TIME');?></a></li>
				<li><a href="#" name="ohanah-config-frontend"><?=@text('OHANAH_FRONTEND_SUBMISSION');?></a></li>
			</ul>
		</div>
		<div id="settingsRight" class="clearfix">
			<div class="panel" id="ohanah-config-layout">
				<?= @template('form_layout', array('params' => $params)); ?>
			</div>

			<div class="panel" id="ohanah-config-layoutcomposer">
				<?= @template('form_layoutcomposer', array('params' => $params)); ?>
			</div>


			<div class="panel" id="ohanah-config-email">
				<?= @template('form_email', array('params' => $params)); ?>
			</div>

			<div class="panel" id="ohanah-config-injector">
				<?= @template('form_injector', array('params' => $params)); ?>
			</div>

			<div class="panel" id="ohanah-config-registration">
				<?= @template('form_registration', array('params' => $params)); ?>
			</div>

			<div class="panel" id="ohanah-config-time">
				<?= @template('form_time', array('params' => $params)); ?>
			</div>

			<div class="panel" id="ohanah-config-frontend">
				<?= @template('form_frontend', array('params' => $params)); ?>
			</div>
		</div>
	</div>
</form>