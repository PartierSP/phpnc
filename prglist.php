<?php
	session_start();
	header("Cache-control: private");
	
	require_once("Smarty.class.php");
	require_once("inc_functions.php");
	require_once("inc_variables.php");
	require_once("inc_datalayer.php");
	
	$smarty=new Smarty();

	$mc=gGet("mc",0);

	$dl=new DataLayer();
	$dl->connect($gserver, $gdatabaseuser, $gdatabasepass, $gdatabase) or die($dl->geterror());

	if($mc>0){
		$sql='SELECT programid, name, description, createddate, editeddate '
			.'FROM programs '
			.'WHERE machineid = '.$mc.' '
			.'ORDER BY name';
		$list=$dl->sql($sql);
	} else {
		$list[]=array(
			'programid'=>0,
			'name'=>'',
			'description'=>'Select Machine',
			'createddate'=>'',
			'editeddate'=>'');
	}

	$smarty->assign('list',$list);
	$smarty->display('prgtable.tpl');
?>
