;(function($) {
    var $stickyHeight = 0;
    var $padding = 0;
    var $topOffset = 90;
    var $footerHeight = 0;

    $.fn.stickytoolbar = function(options) {
        if(jQuery(window).height() >= $stickyHeight) {
            var aOffset = jQuery('#toolbar-box').offset();
            
            if (jQuery(document).height() - $footerHeight - $padding < jQuery(window).scrollTop() + $stickyHeight) {
                var $top = jQuery(document).height() - $stickyHeight - $footerHeight - $padding;
                jQuery('#toolbar-box').attr('style', 'position:absolute; top:'+$top+'px;');
            } else if (jQuery(window).scrollTop() + $padding > $topOffset) {
                jQuery('#toolbar-box').attr('style', 'width:'+jQuery("#content-box").width()+'px; position:fixed; top:'+$padding+'px;');
                jQuery('#edit-form').attr('style', 'margin-top:77px !important;');
                 
                jQuery(window).resize(function(){
                   jQuery('#toolbar-box').attr('style', 'width:'+jQuery("#content-box").width()+'px; position:fixed; top:'+$padding+'px;');
                   jQuery('#spacer-toolbar').attr('style', 'margin-top:77px !important;');   
                });
            } else {
                jQuery('#toolbar-box').attr('style', 'position:relative;');
                jQuery('#edit-form').attr('style', 'margin-top:');
                 
                jQuery(window).resize(function(){
                    jQuery('#toolbar-box').attr('style', 'width:'+jQuery("#content-box").width()+'px; ');
                    jQuery('#edit-form').attr('style', '');
                });
            }
        }
    }
})(jQuery);

var $jq = jQuery.noConflict();  
$jq(function() {
    $jq(window).scroll(function() { 
        $jq(this).stickytoolbar();
    });
});