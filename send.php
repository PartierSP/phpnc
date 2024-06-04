<?php
	session_start();
	header("Cache-control: private");
	
	require_once("Smarty.class.php");
	require_once("inc_functions.php");
	require_once("inc_variables.php");
	require_once("inc_datalayer.php");
	require_once("inc_phpserial.php");
	
	$smarty=new Smarty();

	$mc=gPost("mc",0);
	$prgid=gPost("prgid",0);

	$dl=new DataLayer();
	$dl->connect($gserver, $gdatabaseuser, $gdatabasepass, $gdatabase) or die($dl->geterror());

	if($prgid==0) {
		$machines=$dl->select("machines");
		$machine[]="----";
		$machineid[]=0;
		foreach($machines as $d_row){
			$machine[]=$d_row['name'];
			$machineid[]=$d_row['machineid'];
		}

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

		$smarty->assign('mc',$mc);
		$smarty->assign("machine",$machine);
		$smarty->assign("machineid",$machineid);
		$smarty->assign('list',$list);
		$smarty->display('load.tpl');
	} else {
		$action=gPost("action","");
		$program=gPost("program","");

		if($program==""){
			$program=$dl->select("programs", "programid=$prgid");
			$program=$program[0]['program'];
		}

		if($action=="send"){
			#Lets do this.

			$serial=new PhpSerial;

			$sql='SELECT t1.machineid AS id, t1.name AS name, t1.newline AS newline, t1.sendcomments AS comments, t1.port AS port, t2.baudrate AS baud, t3.parity AS parity, t4.size AS datasize, t5.stop AS stop, t6.flow AS flow '
				.'FROM machines AS t1 '
				.'LEFT JOIN baud AS t2 ON t1.baud=t2.baudid '
				.'LEFT JOIN parity AS t3 ON t1.parity=t3.parityid '
				.'LEFT JOIN datasize AS t4 ON t1.datasize=t4.sizeid '
				.'LEFT JOIN stopsize AS t5 ON t1.stopsize=t5.stopid '
				.'LEFT JOIN flowcontrol AS t6 ON t1.flowcontrol=t6.flowid '
				.'WHERE t1.machineid = '.$mc;
			$machine=$dl->sql($sql);

			$serial->deviceSet($machine[0]['port']);
			$serial->confBaudRate($machine[0]['baud']);
			$serial->confCharacterLength($machine[0]['datasize']);
			$serial->confStopBits($machine[0]['stop']);
			$serial->confFlowControl($machine[0]['flow']);

			$serial->deviceOpen();

			$serial->sendMessage($program);
		}

		$smarty->assign("prgid", $prgid);
		$smarty->assign("program", $program);
		$smarty->assign("mc", $mc);

		$smarty->display('send.tpl');
	}

?>
