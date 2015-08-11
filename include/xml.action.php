<?php
function get_xml($url) {
	global $db;
	$xml_str = file_get_contents($url);
	if (strlen($xml_str) > 300){
		$xml = xml2array($xml_str);
		$tmp_arr = explode("=",$url);
		$hash = $tmp_arr[1];
		
		$site = $xml['ScanGroup']['Scan']['StartURL'];
		$FinishTime = $xml['ScanGroup']['Scan']['FinishTime'];
		$ScanTime = $xml['ScanGroup']['Scan']['ScanTime'];
		$Banner = $xml['ScanGroup']['Scan']['Banner'];
		$Responsive = $xml['ScanGroup']['Scan']['Responsive']; //True扫描对象能连通，False扫描对象没反应error
		$Os = $xml['ScanGroup']['Scan']['Os'];
		$Technologies = $xml['ScanGroup']['Scan']['Technologies'];
		
		$in_target_info_arr['url'] = $site;
		$in_target_info_arr['FinishTime'] = $FinishTime;
		$in_target_info_arr['ScanTime'] = $ScanTime;
		$in_target_info_arr['Banner'] = $Banner;
		$in_target_info_arr['Responsive'] = $Responsive;
		$in_target_info_arr['Os'] = $Os;
		$in_target_info_arr['Technologies'] = $Technologies;
		$in_target_info_arr['hash'] = $hash;
		
		$insert = $db->insert_into("target_info",$in_target_info_arr);
		
		
		$ReportItems = $xml['ScanGroup']['Scan']['ReportItems']['ReportItem'];
	
		for ($i = 1; $i <= count($ReportItems); $i++) {
			######## 漏洞详情 #########
			$ld_Name = $ReportItems[$i]['Name'];
			if ( !empty($ld_Name) ){
				$ld_ModuleName = $ReportItems[$i]['ModuleName'];
				$ld_Details = $ReportItems[$i]['Details'];
				//$ld_Details = "";
				$ld_Affects = $ReportItems[$i]['Affects'];
				$ld_Parameter = $ReportItems[$i]['Parameter'];
				$ld_Severity = $ReportItems[$i]['Severity'];
				$ld_Request = str_replace("\n","<br>",$ReportItems[$i]['TechnicalDetails']['Request']);
				$ld_Response = str_replace("\n","<br>",$ReportItems[$i]['TechnicalDetails']['Response']);
				###########################
				
				$in_target_vul_arr['Name'] = $ld_Name;
				$in_target_vul_arr['ModuleName'] = $ld_ModuleName;
				$in_target_vul_arr['Details'] = $ld_Details;
				$in_target_vul_arr['Affects'] = $ld_Affects;
				$in_target_vul_arr['Parameter'] = $ld_Parameter;
				$in_target_vul_arr['Severity'] = $ld_Severity;
				$in_target_vul_arr['Request'] = $ReportItems[$i]['TechnicalDetails']['Request'];
				$in_target_vul_arr['Response'] = $ReportItems[$i]['TechnicalDetails']['Response'];
				$in_target_vul_arr['hash'] = $hash;
				$in_target_vul_arr['unique'] = MD5($in_target_vul_arr['Request'].$hash);
				
				
				if ($ld_Severity != 'info'){
					//$info = "$site <br> $FinishTime <br> $ScanTime <br> $Responsive <br> $Banner <br> $Os <br> $Technologies <br> $ld_Name <br> $ld_ModuleName <br> $ld_Details <br> $ld_Affects <br> $ld_Parameter <br> $ld_Severity <p> $ld_Request <p> $ld_Response";
					
					//echo $info;
					
					$insert = $db->insert_into("target_vul",$in_target_vul_arr);
				}
			}
		}
		
		$up_arr['status'] = 'ok';
		$update = $db->update('scan_list',$up_arr,"status='ing' and hash='{$hash}'");
		
		$sql = "SELECT point_server.hash,point_server.level FROM `scan_list` LEFT JOIN `point_server` ON scan_list.pointserver = point_server.pointip where scan_list.hash='{$hash}'";
		$results = $db->fetch_assoc($sql);
		$iphash = $results['hash'];
		
		$up_arr1['level'] = $results['level'] - 1;
		if ( $up_arr1['level'] > 0 ){
			$update = $db->update("point_server",$up_arr1,"hash='{$iphash}'");
		}
	}
}

?>