<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

KLoader::loadIdentifier('com://admin/ohanah.controller.common');

class ComOhanahControllerIpn extends ComOhanahControllerCommon
{
	protected function _actionAdd(KCommandContext $context) 
	{
		$paypal_email = JComponentHelper::getParams('com_ohanah')->get('paypal_email');

		$paypal_info = JRequest::get('post');
		
		if ($paypal_info) {
		
			$paypal_ipn = new paypal_ipn($paypal_info);

			foreach ($paypal_ipn->paypal_post_vars as $key=>$value) {
				if (getType($key)=="string") {
					eval("\$$key=\$value;");
				}
			}
			
			$paypal_ipn->send_response();
			$paypal_ipn->myEmail = JComponentHelper::getParams('com_ohanah')->get('paypal_email');
			
			if (!$paypal_ipn->is_verified()) {
				$paypal_ipn->error_out("Bad order (PayPal says it's invalid)" . $paypal_ipn->paypal_response , $em_headers);
				die();
			}
			
			switch( $paypal_ipn->get_payment_status() )
			{
				case 'Pending':
				case 'Completed':

					$registration = $this->getService('com://site/ohanah.model.registrations')->id((int)$paypal_info['custom'])->getItem();
					$registration->paid = 1;
					$registration->save();

					break;
			}
		}
	}
}


class paypal_ipn
{
	var $paypal_post_vars;
	var $paypal_response;
	var $timeout;

	var $myEmail;
	
	function paypal_ipn($paypal_post_vars) {
		$this->paypal_post_vars = $paypal_post_vars;
		$this->timeout = 120;
	}

	function send_response()
	{
		//$fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 120);
		$fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 120);

		if (!$fp) { 
			$this->error_out("PHP fsockopen() error: " . $errstr , "");
		} else {
			foreach($this->paypal_post_vars AS $key => $value) {
				if (@get_magic_quotes_gpc()) {
					$value = stripslashes($value);
				}
				$values[] = "$key" . "=" . urlencode($value);
			}

			$response = @implode("&", $values);
			$response .= "&cmd=_notify-validate";

			fputs( $fp, "POST /cgi-bin/webscr HTTP/1.0\r\n" ); 
			fputs( $fp, "Content-type: application/x-www-form-urlencoded\r\n" ); 
			fputs( $fp, "Content-length: " . strlen($response) . "\r\n\n" ); 
			fputs( $fp, "$response\n\r" ); 
			fputs( $fp, "\r\n" );

			$this->send_time = time();
			$this->paypal_response = ""; 

			// get response from paypal
			while (!feof($fp)) { 
				$this->paypal_response .= fgets( $fp, 1024 ); 

				if ($this->send_time < time() - $this->timeout) {
					$this->error_out("Timed out waiting for a response from PayPal. ($this->timeout seconds)" , "");
				}
			}
			fclose( $fp );
		}
	}
	
	function is_verified() {
		if( ereg("VERIFIED", $this->paypal_response) )
			return true;
		else
			return false;
	} 

	function get_payment_status() {
		return $this->paypal_post_vars['payment_status'];
	}

	function error_out($message, $em_headers)
	{

		$date = date("D M j G:i:s T Y", time());
		$message .= "\n\nThe following data was received from PayPal:\n\n";

		@reset($this->paypal_post_vars);
		while( @list($key,$value) = @each($this->paypal_post_vars)) {
			$message .= $key . ':' . " \t$value\n";
		}
		
		mail($this->myEmail, "[$date] paypay_ipn notification", $message, $em_headers);

	}
} 