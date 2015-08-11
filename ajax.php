<?php
require(dirname(__FILE__).'/include/config.inc.php');

$m_arr = array('cpasswd','del','rescan','export');

$mode = $_GET['m'];

if(in_array($mode,$m_arr)){
	call_user_func($mode);
}
?>