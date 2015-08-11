<?php
require(dirname(__FILE__).'/include/config.inc.php');

$m_arr = array('index','scan','login','point','set','info','edit','logout');

$mode = $_GET['m'];

Checklogin($mode);

if(in_array($mode,$m_arr)){
	$html_str = call_user_func($mode);
	include("html/$mode.html");
}else{
	$html_str = index();
	include('html/index.html');
}

?>