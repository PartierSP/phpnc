<?php
	session_start();
	header("Cache-control: private");
	
	require_once("Smarty.class.php");
	require_once("inc_functions.php");
	require_once("inc_variables.php");
	require_once("inc_datalayer.php");
	
	$smarty=new Smarty();
	
	$action=gPost("action","");
	$program=gPost("program","");
	$startline=gPost("startline",10);
	$increment=gPost("increment",10);
	$firstline=gPost("firstline",0);
	$lastline=gPost("lastline",99999);
	$axis=gPost("axis","");
	$mod=gPost("mod","");
	$prec=gPost("prec",4);

	$message="";

	//Pretty up the program
	$program=strtoupper($program);
	
	//Renumber if required
	if($action=="renumber"){
		$program=renumber($program, $startline, $increment);
	}
	
	//Scale or Scale requested
	if(($action=="scale") || ($action=="shift")){
		list($program,$message)=scaleshift($program, $action, $axis, $mod, $prec, $firstline, $lastline);
	}
	
	$smarty->assign("program", $program);
	$smarty->assign("startline", $startline);
	$smarty->assign("increment", $increment);
	$smarty->assign("firstline", $firstline);
	$smarty->assign("lastline", $lastline);
	$smarty->assign("axis",$axis);
	$smarty->assign("mod",$mod);
	$smarty->assign("prec",$prec);
	$smarty->assign("message",$message);
	$smarty->display("editor.tpl");
	
?>
