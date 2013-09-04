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
		$jq('#ohanah-help-mobile-app').hide();
		$jq('#ohanah-help-credits').hide();
		$jq('#ohanah-help-share').hide();
	
	    $jq("#settingsLeft a").click(function(){
	    	var divname= this.name;
	    	if (divname != 'ohanah-help-support-center') {
		    	$jq("#"+divname).show().siblings().hide();
		    	$jq("#settingsLeft a").removeClass('active');
		    	this.addClass('active');
	    	}
	    });
	});
</script> 

<!-- BEGIN FORM VIEW -->
<form action="" method="post" class="form-validate -koowa-form" id="edit-form" enctype="multipart/form-data">
	<div id="settingsWrapper" class="clearfix">
		<div id="settingsLeft">
			<ul>
				<li><a href="#" name="ohanah-help-getting-started" class="active">Getting started</a></li>
				<li><a href="#" name="ohanah-help-mobile-app">Mobile app</a></li>
				<li><a href="http://support.ohanah.com" target="_blank" name="ohanah-help-support-center">Support center</a></li>
				<li><a href="#" name="ohanah-help-share">Share some love</a></li>
				<li><a href="#" name="ohanah-help-credits">Credits</a></li>
			</ul>
		</div>
		<div id="settingsRight" class="clearfix">
			<div class="panel" id="ohanah-help-getting-started">
				<div class="panelContent">
					<br />
						
						<h2>Welcome to the Ohanah help section!</h2>
						<p></p>
						<p>Below you'll find a series of shorts tutorials to kickstart with Ohanah v2.<br />For more documentation and help just click "Support Center" on the left side menu.</p>
						<div class="break"></div>
						<h3>1) Creating your first event <a href="http://www.youtube.com/embed/0EtoPg3VVC0" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/0EtoPg3VVC0?rel=0" frameborder="0" allowfullscreen></iframe>
						<br />
						<div class="break"></div>
						<h3>2) Dealing with Venues & Geolocation <a href="http://www.youtube.com/embed/i1VPCOgu9R0" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/i1VPCOgu9R0?rel=0" frameborder="0" allowfullscreen></iframe>
						<br />
						<div class="break"></div>
						<h3>3) Event Categories <a href="http://www.youtube.com/embed/wDoG9tzyoE0" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/wDoG9tzyoE0?rel=0" frameborder="0" allowfullscreen></iframe><br />
						<div class="break"></div>
						<h3>4) Quick look into the settings <a href="http://www.youtube.com/embed/njk1OTz600s" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/njk1OTz600s?rel=0" frameborder="0" allowfullscreen></iframe><br />
						<div class="break"></div>
						<h3>5) Sell your tickets through payment gateway <a href="http://www.youtube.com/embed/FFKSFsawDDA" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/FFKSFsawDDA?rel=0" frameborder="0" allowfullscreen></iframe><br />
						<div class="break"></div>
						<h3>6) Event registration & custom fields <a href="http://www.youtube.com/embed/G2OSrlIW3jQ" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/G2OSrlIW3jQ?rel=0" frameborder="0" allowfullscreen></iframe><br />
						<div class="break"></div>
						<h3>7) Managing Attendees <a href="http://www.youtube.com/embed/wsfURUsFbqU" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/wsfURUsFbqU?rel=0" frameborder="0" allowfullscreen></iframe><br />
						<div class="break"></div>
						<h3>8) Recurring Events Explained <a href="http://www.youtube.com/embed/P4fbGD-Y_sQ" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/P4fbGD-Y_sQ?rel=0" frameborder="0" allowfullscreen></iframe><br />
						<div class="break"></div>
						<h3>9) Adapting ohanah to your template <a href="http://www.youtube.com/embed/FxhkKbFyVew" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/FxhkKbFyVew?rel=0" frameborder="0" allowfullscreen></iframe><br />
						<div class="break"></div>
						<h3>10) About The module Injector <a href="http://www.youtube.com/embed/0KhK4_GKdHM" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/0KhK4_GKdHM?rel=0" frameborder="0" allowfullscreen></iframe><br /><br />
					
				</div>
			</div>

			<div class="panel" id="ohanah-help-mobile-app">
				<div class="panelContent">
					
					<br />
					
						<h2>Mobile app</h2>

						<p>The mobile app can be downloaded from our support center. <a href="http://support.ohanah.com/forums/20509468-downloads" target="_blank"> Get it here.</a></p>
						<div class="break"></div>
						<h3> Mobile App Video <a href="http://www.youtube.com/embed/XuTUIWYvLew" target="_blank" style="font-size:12px; margin-left:20px">Open in new window</a></h3>
						<iframe width="640" height="360" src="http://www.youtube.com/embed/XuTUIWYvLew?rel=0" frameborder="0" allowfullscreen></iframe><br /><br />
					
				</div>			
			</div>

			<div class="panel" id="ohanah-help-credits">
				<div class="panelContent">
					
					<br />
					
						<h2>Credits</h2>

						<p>Ohanah app for joomla is <a href="http://beyounic.com">Beyounic SA</a> product</p>
						<p>We wish to thanks all the gr8 people that worked with us and that keep insipiring us!</p>
						<br />
						
						
					
				</div>			
			</div>


			<div class="panel" id="ohanah-help-share">
				<div class="panelContent">
					
					<br />
					
						<h2>Share some Love :)</h2>
						
						<h3>On the Joomla Extension Directory - JED</h3>

						<p>We put all our love in making this extension as good as we could. If you like ohanah, or just want to leave your testimonial about your experience and the usage you do with it, feel free to <a href="http://extensions.joomla.org/extensions/calendars-a-events/events/events-management/16935" target="_blank">write a review on the Joomla Extension Directory</a>. Getting back some love is what makes us proud and happy the most, because a product without happy users is just worthless.</p>

						
						<div class="break"></div>
						<br />
						<h3>Tweet and follow us on Twitter</h3>

						<p>We are very active on the various social media and we also love to share and engage there. Here below we have inserted a few sharing buttons to make it very quickly for you to share your thoughts about Ohanah and get in touch with us on the social web.</p>

						

						<a href="https://twitter.com/intent/tweet?button_hashtag=ohanah&text=I'm%20just%20using%20ohanah%20v2%20for%20%23Joomla%20and%20love%20it.%20Check%20it%20out%20here%3A" class="twitter-hashtag-button" data-size="large" data-related="ohanahevents,beyounic" data-url="http://app.ohanah.com">Tweet #ohanah</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

						<div class="break"></div>
						<br />
						<h3>Like us on Facebook</h3>

						<br />

						<div class="fb-like" data-href="http://app.ohanah.com" data-send="false" data-width="450" data-show-faces="true" ></div><br />
						<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=105622726160861";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



					<br /><br /><br />
				</div>			
			</div>



		</div>
	</div>
</form>