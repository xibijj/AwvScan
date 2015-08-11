<?php
function index() {
	global $db;
	
	#$sql = "SELECT * FROM scan_list as a,target_info as b where a.hash = b.hash";
	$sql = "SELECT * FROM scan_list LEFT JOIN target_info ON scan_list.hash = target_info.hash order by createtime desc";
	$results = $db->query($sql);
	if (mysql_num_rows($results) > 0){
		$i = 1;
		while ($fs = $db->fetch_array($results))
		{
			$id = $i;
			$url = $fs["1"];
			$user = $fs["3"];
			$pointserver = $fs["4"];
			$hash = $fs["11"];
			$finishtime = $fs["16"];
			$banner = $fs["17"];
			$responsive = $fs["18"];
			$technologies = $fs["20"];
			$os = $fs["19"];
			$high = get_severity($hash,'high');
			$middle = get_severity($hash,'middle');
			$low = get_severity($hash,'low');
			
			if (strtolower($responsive) == 'true'){
				$class = 'success';
				$responsive = "正常";
			}else if (strtolower($responsive) == 'false'){
				$class = 'error';
				$responsive = "错误";
			}else{
				$class = '';
			}
			
			$html_str .= "
									<tr class=\"$class\">
										<td>
											$id
										</td>
										<td style=\"word-break:break-all; word-wrap:break-word;\">
											<a href=\"?m=info&p={$hash}\">$url</a>
										</td>
										<td>
											$user
										</td>
										<td>
											$responsive
										</td>
										<td>
											$pointserver
										</td>
										<td>
											<a href=\"?m=info&p={$hash}&c=high\"><font color=\"red\">$high</font></a>
										</td>
										<td>
											<a href=\"?m=info&p={$hash}&c=middle\"><font color=\"orange\">$middle</font></a>
										</td>
										<td>
											<a href=\"?m=info&p={$hash}&c=low\"><font color=\"green\">$low</font></a>
										</td>
										<td>
											$banner
										</td>
										<td>
											$os
										</td>
										<td>
											$finishtime
										</td>
										<td>
											<a href=\"?m=info&p={$hash}\">详情</a>|<a href=\"?m=edit&p={$hash}\">编辑</a>|<a href=\"javascript:del('{$hash}')\">删除</a>|<a href=\"javascript:exportexcel('{$hash}')\">报告</a>
										</td>
									</tr>\r\n";
			$i ++;
		}
		
		return $html_str;
	}else{
		return "";
	
	}
}

function scan() {
	global $db;
	
	//print_r($_POST);
	
	if(!empty($_POST['url'])){
		
		$pointserver = specify_server();
		if (!empty($pointserver)){
		
			$in_arr['url'] = $_POST['url'];
			$in_arr['createtime'] = date('Y-m-d');
			$in_arr['user'] = $_SESSION['username'];//当前session用户
			$in_arr['pointserver'] = specify_server();//分配节点服务器ip
			$in_arr['group'] = "";//项目组名称
			$in_arr['siteuser'] = $_POST['user'];
			$in_arr['sitepwd'] = $_POST['pwd'];
			$in_arr['cookie'] = $_POST['cookie'];
			$in_arr['rule'] = $_POST['rule'];
			$in_arr['status'] = 'new';
			$in_arr['hash'] = md5($in_arr['url'].time().authkey);
			
			if ( $_POST['auth'] == 'on' ) nginx_vhost( $in_arr['url'] , $in_arr['cookie'] );
			
			$insert = $db->insert_into("scan_list",$in_arr);
			
		}else{
			Message(" 请配置节点服务器 ","?m=point",0,3000);
		}
	}
}

function info() {
	global $db;
	
	$action = $_GET['c'];
	$hash = $_GET['p'];
	
	if (empty($action)){
		$sql = "SELECT * FROM target_vul where hash='{$hash}' order by Severity";
	}else if ($action == 'high'){
		$sql = "SELECT * FROM target_vul where hash='{$hash}' and Severity='high' order by Severity";
	}else if ($action == 'middle'){
		$sql = "SELECT * FROM target_vul where hash='{$hash}' and Severity='middle' order by Severity";
	}else if ($action == 'low'){
		$sql = "SELECT * FROM target_vul where hash='{$hash}' and Severity='low' order by Severity";
	}
	
	$results = $db->query($sql);
	if (mysql_num_rows($results) > 0){
		$i = 1;
		while ($fs = $db->fetch_array($results))
		{
			$id = $i;
			$Name = $fs["name"];
			$Affects = $fs["affects"];
			$Parameter = $fs["parameter"];
			$Severity = $fs["severity"];
			$details = $fs["details"];
			$Request = str_replace("\n",'<br>',$fs["request"]);
			//$Response = str_replace("\n",'<br>',$fs["response"]);
			
			if (strtolower($Severity) == 'high'){
				$class = 'error';
			}else if(strtolower($Severity) == 'middle'){
				$class = 'warning';
			}else if(strtolower($Severity) == 'low' or strtolower($Severity) == 'info'){
				$class = 'info';
			}
			
			if ($Parameter == 'Array'){
				$Parameter = '';
			}
			
			if ($Request == 'Array'){
				$Request = '';
			}
			
			if ($Response == 'Array'){
				$Response = '';
			}
			
			$html_str .= "
									<tr class=\"$class\">
										<td>
											$id
										</td>
										<td>
											$Name
										</td>
										<td>
											$Severity
										</td>
										<td>
											$Affects
										</td>
										<td>
											$Parameter
										</td>
										<td>
											$details
										</td>
										<td>
											$Request
										</td>
									</tr>\r\n";
			$i ++;
		}
		
		return $html_str;
	}else{
		return "";
	}
}

function edit() {
	global $db;
	
	$hash = $_GET['p'];
	
	if (!empty($hash)){
		$sql = "SELECT * FROM scan_list where hash='{$hash}'";
		
		$results = $db->fetch_assoc($sql);
		
		return $results;
	}

}

function point() {
	global $db;
	
	$action = $_GET['c'];
	
	if ($action == 'new'){
		//新添加
		//print_r($_POST);
		if(!empty($_POST['ip'])){
			
			$in_arr['pointip'] = $_POST['ip'];
			$in_arr['pointport'] = $_POST['port'];
			$in_arr['status'] = $_POST['status'];
			$in_arr['hash'] = md5($in_arr['pointip'].$in_arr['pointport']);
			
			$insert = $db->insert_into("point_server",$in_arr);
		}
	}else if ($action == 'update'){
		//更新
		//print_r($_POST);
		$key = $_GET['p'];
		if(!empty($_POST['ip']) and !empty($key)){
			
			$in_arr['pointip'] = $_POST['ip'];
			$in_arr['pointport'] = $_POST['port'];
			$in_arr['status'] = $_POST['status'];
			
			$update = $db->update("point_server",$in_arr,"hash='{$key}'");
		}
	}
	
	$sql = "SELECT * FROM point_server";
	
	$results = $db->query($sql);
	if (mysql_num_rows($results) > 0){
		$i = 1;
		while ($fs = $db->fetch_array($results))
		{
			$id = $i;
			$ip = $fs["pointip"];
			$port = $fs["pointport"];
			$level = $fs["level"];
			$status = $fs["status"];
			$hash = $fs["hash"];
			
			if ($status == '1'){
				$class = 'success';
				$status = '启用';
			}else{
				$class = 'warning';
				$status = '禁用';
			}
			
			$html_str .= "
									<tr class=\"$class\">
										<td>
											$id
										</td>
										<td>
											$ip
										</td>
										<td>
											$port
										</td>
										<td>
											$level
										</td>
										<td>
											$status
										</td>
										<td>
											<a id=\"modal-978241\" href=\"#$hash\" role=\"button\" class=\"btn\" data-toggle=\"modal\">修改</a>
										</td>
									</tr>\r\n";
			$i ++;
		}
		
		return $html_str;
	}else{
		return "";
	}

}


function set() {
	global $db;
	
	$action = $_GET['c'];
	
	if ($action == 'new'){
		//新添加
		//print_r($_POST);
		if(!empty($_POST['username']) and !empty($_POST['passwd'])){
			
			$in_arr['username'] = $_POST['username'];
			$in_arr['passwd'] = $_POST['passwd'];
			$in_arr['phone'] = $_POST['phone'];
			$in_arr['email'] = $_POST['mail'];
			$in_arr['status'] = $_POST['status'];
			$in_arr['ctime'] = time();
			
			$insert = $db->insert_into("user",$in_arr);
		}
	}else if ($action == 'update'){
		//更新
		//print_r($_POST);
		if(!empty($_POST['username'])){
			
			$in_arr['username'] = $_POST['username'];
			//$in_arr['passwd'] = $_POST['passwd'];
			$in_arr['phone'] = $_POST['phone'];
			$in_arr['email'] = $_POST['mail'];
			$in_arr['status'] = $_POST['status'];
			
			$update = $db->update("user",$in_arr,"username='{$in_arr['username']}'");
		}
	}
	
	$sql = "SELECT * FROM user";
	
	$results = $db->query($sql);
	if (mysql_num_rows($results) > 0){
		$i = 1;
		while ($fs = $db->fetch_array($results))
		{
			$id = $i;
			$username = $fs["username"];
			$email = $fs["email"];
			$phone = $fs["phone"];
			$status = $fs["status"];
			$hash = md5($username);
			
			if ($status == '1'){
				$class = 'success';
				$status = '启用';
			}else{
				$class = 'warning';
				$status = '禁用';
			}
			
			$html_str .= "
									<tr class=\"$class\">
										<td>
											$id
										</td>
										<td>
											$username
										</td>
										<td>
											$email
										</td>
										<td>
											$phone
										</td>
										<td>
											$status
										</td>
										<td>
											<a id=\"modal-978241\" href=\"#$hash\" role=\"button\" class=\"btn\" data-toggle=\"modal\">修改</a>
										</td>
									</tr>\r\n";
			$i ++;
		}
		
		return $html_str;
	}else{
		return "";
	}

}


function login() {
	global $db;
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	//print_r($_POST);
	
	if (!empty($username) and !empty($password)){
		$sql = "SELECT * FROM `user` where username='{$username}' and passwd='{$password}'";
		
		$results = $db->fetch_assoc($sql);
		$rows = $db->db_num_rows($sql);
		if ($rows > 0 and $results['status'] == 1){
			$_SESSION['username'] = $results['username'];
			$_SESSION['r_ip'] = $_SERVER['REMOTE_ADDR'];
			
			$up_arr['lasttime'] = time();
			$update = $db->update("user",$up_arr,"username='{$username}'");
			
			Message(" $username 登录成功! 正在跳转... ","?m=index",0,3000);
		}else if ($rows > 0 and $results['status'] == 0){
			Message(" 账号被禁用，请联系管理员 ","?m=login",0,3000);
		}
	}

}

function logout() {
	unset($_SESSION['username']);
	header("Location: ?m=login");
}

?>