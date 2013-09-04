<?php
/**
* @version   $Id: index-iphone.php 1617 2012-07-12 11:22:15Z arifin $
* @author    RocketTheme http://www.rockettheme.com
* @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*
* Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
*
*/
// no direct access
defined( 'GANTRY_VERSION' ) or die( 'Restricted index access' );
global $gantry;
$gantry->set('fixedheader', 0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $gantry->language; ?>" lang="<?php echo $gantry->language;?>" >
    <head>
        <?php
            $gantry->displayHead();
            $gantry->addStyles(array('template.css','iphone-gantry.css'));
			$gantry->addScript('iscroll.js');

            $gantry->addScript('roktabs.js');
			$hidden = '';
        ?>
			<?php
				$scalable = $gantry->get('iphone-scalable', 0) == "0" ? "0" : "1";
			?>
			<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=<?php echo $scalable; ?>;">

			<script type="text/javascript">
				var orient = function() {
					var dir = "rt-normal";
					switch(window.orientation) {
						case 0: dir = "rt-normal";break;
						case -90: dir = "rt-right";break;
						case 90: dir = "rt-left";break;
						case 180: dir = "rt-flipped";break;
					}
					$$(document.body, '#rt-wrapper')
						.removeClass('rt-normal')
						.removeClass('rt-left')
						.removeClass('rt-right')
						.removeClass('rt-flipped')
						.addClass(dir);
				}

				window.addEvent('domready', function() {
					orient();
					window.scrollTo(0, 1);
					new iScroll($$('#rt-menu ul.menu')[0]);
				});

			</script>
    </head>
    <body <?php echo $gantry->displayBodyTag(); ?> onorientationchange="orient()">
    	<div id="rt-page-surround">
			<?php /** Begin Drawer **/ if ($gantry->countModules('mobile-drawer')) : ?>
			<div id="rt-drawer">
				<div class="rt-container">
					<?php echo $gantry->displayModules('mobile-drawer','standard','standard'); ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php /** End Drawer **/ endif; ?>
			<?php /** Begin Menu **/ if ($gantry->countModules('mobile-navigation')) : ?>
			<div id="rt-navigation">
				<div id="rt-menu"><div class="rt-container">
					<div id="rt-left-menu"></div>
					<div id="rt-right-menu"></div>
					<?php echo $gantry->displayModules('mobile-navigation','basic','basic'); ?>
					<div class="clear"></div>
				</div></div>
			</div>
			<?php /** End Menu **/ endif; ?>
			<div class="main-bg">
				<?php /** Begin Top **/ if ($gantry->countModules('mobile-top')) : ?>
				<div id="rt-top">
					<div class="rt-container">
						<?php echo $gantry->displayModules('mobile-top','standard','standard'); ?>
						<div class="clear"></div>
					</div>
				</div>
				<?php /** End Top **/ endif; ?>
				<?php /** Begin Content Top **/ if ($gantry->countModules('mobile-content-top')) : ?>
				<div id="rt-content-top">
					<div class="rt-container">
						<?php echo $gantry->displayModules('mobile-content-top','standard','standard'); ?>
						<div class="clear"></div>
					</div>
				</div>
				<?php /** End Content Top **/ endif; ?>
				<div id="rt-container">
					<div id="rt-main-container">
						<div id="rt-body-surround">
							<?php /** Begin Breadcrumbs **/ if ($gantry->countModules('breadcrumb')) : ?>
							<div id="rt-breadcrumbs">
								<?php echo $gantry->displayModules('breadcrumb','basic','breadcrumbs'); ?>
								<div class="clear"></div>
							</div>
							<?php /** End Breadcrumbs **/ endif; ?>
							<?php /** Begin Main Body **/
								$display_mainbody = !($gantry->get("mainbody-enabled",true)==false && JRequest::getVar('view') == 'frontpage');
							?>

							<?php if ($display_mainbody): ?>
							<?php echo $gantry->displayMainbody('iphonemainbody','sidebar','standard','standard','standard','standard','standard'); ?>
							<?php endif; ?>
							<?php /** End Main Body **/ ?>
						</div>
					</div>
				</div>
				<?php /** Begin Content Bottom **/ if ($gantry->countModules('mobile-content-bottom')) : ?>
				<div id="rt-content-bottom">
					<div class="rt-container">
						<?php echo $gantry->displayModules('mobile-content-bottom','standard','standard'); ?>
						<div class="clear"></div>
					</div>
				</div>
				<?php /** End Content Bottom **/ endif; ?>
			</div>
			<div class="rt-footer-surround">
				<div class="rt-container">
					<div class="rt-footer-inner">
						<?php /** Begin Footer **/ if ($gantry->countModules('mobile-footer')) : ?>
						<div id="rt-footer">
							<?php echo $gantry->displayModules('mobile-footer','standard','standard'); ?>
							<div class="clear"></div>
						</div>
						<?php /** End Footer **/ endif; ?>
						<?php /** Begin Copyright **/ if ($gantry->countModules('mobile-copyright')) : ?>
						<div id="rt-copyright">
							<?php echo $gantry->displayModules('mobile-copyright','standard','limited'); ?>
							<div class="clear"></div>
						</div>
						<?php /** End Copyright **/ endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php /** Begin Debug **/ if ($gantry->countModules('debug')) : ?>
		<div id="rt-debug">
			<div class="rt-container">
				<?php echo $gantry->displayModules('debug','standard','standard'); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php /** End Debug **/ endif; ?>
		<?php /** Begin Analytics **/ if ($gantry->countModules('analytics')) : ?>
		<?php echo $gantry->displayModules('analytics','basic','basic'); ?>
		<?php /** End Analytics **/ endif; ?>
	</body>
</html>
