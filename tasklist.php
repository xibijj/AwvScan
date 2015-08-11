<?php
require(dirname(__FILE__).'/include/config.inc.php');

$sql = "select * from scan_list where status='new'";
$results = $db->fetch_assoc($sql);

$url = $results['url'];
$pointserver = $results['pointserver'];
$rule = $results['rule'];
$siteuser = $results['siteuser'];
$sitepwd = $results['sitepwd'];
$cookie = $results['cookie'];
$hash = $results['hash'];

if ( $db->db_num_rows($sql) > 0 ){
	if ( $pointserver == $_SERVER['REMOTE_ADDR'] or $_SERVER['REMOTE_ADDR'] == '127.0.0.1' or $_SERVER['REMOTE_ADDR'] == '::1' ){
	
		$up_arr['status'] = 'ing';
		
		//echo "$url|$pointserver|$rule|$siteuser|$sitepwd|$cookie|$hash";
		
		$scan_arr['target_url'] = $url;
		$scan_arr['scan_rule'] = $rule;
		$scan_arr['siteuser'] = $siteuser;
		$scan_arr['sitepwd'] = $sitepwd;
		$scan_arr['sitecookie'] = $cookie;
		$scan_arr['hash'] = $hash;
		
		echo base64_encode(json_encode($scan_arr));
		
		
		$update = $db->update('scan_list',$up_arr,"status='new' and hash='{$hash}'");
	}
}else{
	$sql = "select * from `scan_list` where status='ing'";
	$sf = $db->fetch_assoc($sql);
	$get_hash = $sf['hash'];
	if (!empty($get_hash)){
		$url = "http://10.0.13.58/file.php?p=$get_hash";
		//echo $url;
		get_xml($url);
	}
}
?>