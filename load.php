<?php
	session_start();
	header("Cache-control: private");
	
	require_once("Smarty.class.php");
	require_once("inc_functions.php");
	require_once("inc_variables.php");
	require_once("inc_datalayer.php");
	
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
		$startline=gPost("startline",10);
		$increment=gPost("increment",10);
		$firstline=gPost("firstline",0);
		$lastline=gPost("lastline",99999);
		$axis=gPost("axis","");
		$mod=gPost("mod","");
		$prec=gPost("prec",4);
		$message=gPost("message","");
		$action=gPost("action","");
		$whitesp=gPost("whitesp","");
		$tabs=gPost("tabs","");
		
		if($action=="save"){
//			echo 'The program before: ' . $program;
			$program=StripWhiteSpace($program);
//			echo 'The program is: '.$program;
			$updatearray=array(
				"editeddate"=>date("Y-m-d H:i:s"),
				"program"=>$program);
			$dl->update("programs", $updatearray, "programid=$prgid");
			
			if($whitesp=="spaces"){
				$program=AddWhiteSpace($program, $tabs);
			}
		}
		
		if($action=="open"){
			$data=$dl->select("programs", "programid=$prgid");
			$program=$data[0]['program'];
			
			if($whitesp=="spaces"){
				$program=AddWhiteSpace($program, $tabs);
			}
		}
		
		//Renumber if required
		if($action=="renumber"){
			$program=renumber($program, $startline, $increment);
		}
		
		//Scale or Scale requested
		if(($action=="scale") || ($action=="shift")){
			list($program,$message)=scaleshift($program, $action, $axis, $mod, $prec, $firstline, $lastline);
		}

		$smarty->assign("prgid", $prgid);
		$smarty->assign("program", $program);
		$smarty->assign("startline", $startline);
		$smarty->assign("increment", $increment);
		$smarty->assign("firstline", $firstline);
		$smarty->assign("lastline", $lastline);
		$smarty->assign("axis",$axis);
		$smarty->assign("mod",$mod);
		$smarty->assign("prec",$prec);
		$smarty->assign("message",$message);

		$smarty->display('editor.tpl');
	}

?>
