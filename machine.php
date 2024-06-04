<?php
	session_start();
	header("Cache-control: private");
	
	require_once("Smarty.class.php");
	require_once("inc_functions.php");
	require_once("inc_variables.php");
	require_once("inc_datalayer.php");
	
	$smarty=new Smarty();

	$mc=gPost('mc',0);
	$port=gPost('port','');
	$bd=gPost('bd',0);
	$par=gPost('par',0);
	$dat=gPost('dat',0);
	$stp=gPost('stp',0);
	$flw=gPost('flw',0);
	$action=gPost('action','');

	$dl=new DataLayer();
	$dl->connect($gserver, $gdatabaseuser, $gdatabasepass, $gdatabase) or die($dl->geterror());

	$machines=$dl->select("machines");
	$machine[]="----";
	$machineid[]=0;
	$machine[]="--NEW--";
	$machineid[]=-1;
	foreach($machines as $d_row){
		$machine[]=$d_row['name'];
		$machineid[]=$d_row['machineid'];
	}

	$bauds=$dl->select("baud");
	$baud[]="----";
	$baudid[]=0;
	foreach($bauds as $d_row){
		$baud[]=$d_row['baudrate'];
		$baudid[]=$d_row['baudid'];
	}
	
	$parities=$dl->select('parity');
	$parity[]="----";
	$parityid[]=0;
	foreach($parities as $d_row){
		$parity[]=$d_row['parity'];
		$parityid[]=$d_row['parityid'];
	}
	
	$datasizes=$dl->select("datasize");
	$datasize[]="----";
	$datasizeid[]=0;
	foreach($datasizes as $d_row){
		$datasize[]=$d_row['size'];
		$datasizeid[]=$d_row['sizeid'];
	}

	$stops=$dl->select("stopsize");
	$stop[]="----";
	$stopid[]=0;
	foreach($stops as $d_row){
		$stop[]=$d_row['stop'];
		$stopid[]=$d_row['stopid'];
	}

	$flows=$dl->select("flowcontrol");
	$flow[]="----";
	$flowid[]=0;
	foreach($flows as $d_row){
		$flow[]=$d_row['flow'];
		$flowid[]=$d_row['flowid'];
	}

	
	if($mc>0){
		if($action=='save'){
			$updatearray=array(
				'port'=>$port,
				'baud'=>$bd,
				'parity'=>$par,
				'datasize'=>$dat,
				'stopsize'=>$stp,
				'flowcontrol'=>$flw
			);
			$t=$dl->update('machines', $updatearray, "machineid=$mc");
		}
		$mcsetting=$dl->select('machines',"machineid=$mc");
		$port=$mcsetting[0]['port'];
		$bd=$mcsetting[0]['baud'];
		$par=$mcsetting[0]['parity'];
		$dat=$mcsetting[0]['datasize'];
		$stp=$mcsetting[0]['stopsize'];
		$flw=$mcsetting[0]['flowcontrol'];
	}

	$smarty->assign('mc',$mc);
	$smarty->assign('port',$port);
	$smarty->assign('bd',$bd);
	$smarty->assign('par',$par);
	$smarty->assign('dat',$dat);
	$smarty->assign('stp',$stp);
	$smarty->assign('flw',$flw);

	$smarty->assign('machine',$machine);
	$smarty->assign('machineid',$machineid);
	$smarty->assign('baud',$baud);
	$smarty->assign('baudid',$baudid);
	$smarty->assign('parity',$parity);
	$smarty->assign('parityid',$parityid);
	$smarty->assign('datasize',$datasize);
	$smarty->assign('datasizeid',$datasizeid);
	$smarty->assign('stop',$stop);
	$smarty->assign('stopid',$stopid);
	$smarty->assign('flow',$flow);
	$smarty->assign('flowid',$flowid);

	$smarty->display('machine.tpl');

?>
