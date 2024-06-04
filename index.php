<?php
	session_start();
	header('Cache-control: private');
	
	require_once('Smarty.class.php');
	require_once('inc_functions.php');
	require_once('inc_variables.php');
	require_once('inc_datalayer.php');
	
	$smarty=new Smarty();
	
	$smarty->assign('showetimport', $gshowetimport);
	$smarty->display('menu.tpl');

?>
