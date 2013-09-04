<? 
$xml = simplexml_load_file(JPATH_ADMINISTRATOR .'/components/com_ohanah/manifest.xml');
if(!isset($xml->updateUrl)) { echo 'Cannot find Ohanah version (symlinked?)'; exit(); }
$url = (string) $xml->updateUrl;

//get the url
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

$response = strstr($response, '<div class="caption">Version</div><div class="data">');
$version = trim(str_replace('Version', '', strip_tags(substr($response, 0, strpos($response, '<i>')))));

if(version_compare($xml->version, $version, '<'))
{
	$msg = sprintf(JText::_('OHANAH_NEW_VERSION_AVAILABLE'), $version);
}
else
{
	$msg = sprintf(JText::_('OHANAH_LATEST_VERSION'));
}

echo $msg;

exit(); 