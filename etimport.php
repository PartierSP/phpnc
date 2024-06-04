<?php
	session_start();
	header("Cache-control: private");
	
	require_once("Smarty.class.php");
	require_once("inc_functions.php");
	require_once("inc_variables.php");
	require_once("inc_datalayer.php");
	
	$smarty=new Smarty();

	$dl=new DataLayer();
	$dl->connect($gserver, $gdatabaseuser, $gdatabasepass, $gdatabase) or die($dl->geterror());

	if(!isset($_POST['dir'])){

		$root="data";
		
		if ($handle = opendir($root)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					if(is_dir($root.'/'.$entry)){
						$dirs[]=$entry;
					}
				}
			}
			closedir($handle);
		}

		$machines=$dl->select("machines");
		foreach($machines as $d_row){
			$machine[]=$d_row['name'];
			$machineid[]=$d_row['machineid'];
		}

		$smarty->assign("dirs", $dirs);
		$smarty->assign("machine",$machine);
		$smarty->assign("machineid",$machineid);
		$smarty->display("selectdir.tpl");

	} else {

		$count=0;
		$filename="data/" . $_POST['dir'] . "/ETPARTS.DAT";
		
		$handle=fopen($filename, "rb");
		$content="";
		while (!feof($handle)){
			$content=fread($handle, 67);

			//Abort while if no data is read
			$stream_meta_data = stream_get_meta_data($handle);
			if($stream_meta_data['unread_bytes'] <= 0){
				break;
			}

			$desc="";
			for($i=0;$i<32;$i++){
				$temp=substr($content,$i,1);
				if($temp=="\0"){
					break;
				}
				$desc.=$temp;
			}
			$file="";
			for($i=34;$i<47;$i++){
				$temp=substr($content,$i,1);
				if($temp=="\0"){
					break;
				}
				$file.=$temp;
			}
			while($temp<>"."){
				$i++;
				$temp=substr($content,$i,1);
			}
			$month="";
			for($ii=$i+1;$ii<$i+3;$ii++){
				$temp=substr($content,$ii,1);
				$month.=$temp;
			}
			$day="";
			for($ii=$i+4;$ii<$i+6;$ii++){
				$temp=substr($content,$ii,1);
				$day.=$temp;
			}
			$year="";
			for($ii=$i+7;$ii<$i+10;$ii++){
				$temp=substr($content,$ii,1);
				if(($temp=="\0") OR ($temp==" ")){
					break;
				}
				$year.=$temp;
			}
			//OMG! Y2K Bug
			$year=intval($year)+1900;
			//Assuming dates > 2050 are wrong.
			if($year>2050){
				$year=$year-100;
			}
			if($file<>"NCDUMMY.XYZ"){

				$progfile="data/" . $_POST['dir'] . "/" . $file;

				$hdl=fopen($progfile, "rb");
				$prg="";
				while (!feof($hdl)){
					$pro=fread($hdl, 256);
					$prg.=$pro;

					//Abort while if no data is read
					$stream = stream_get_meta_data($hdl);
					if($stream['unread_bytes'] <= 0){
						break;
					}
				}
				$pro="";

				//Clean carrage returns.
				$prg=str_replace("\r",'',$prg);

				$data=array(
					'name'=>$file,
					'description'=>$desc,
					'createddate'=>$year.'-'.$month.'-'.$day,
					'editeddate'=>$year.'-'.$month.'-'.$day,
					'machineid'=>$_POST['machine'],
					'program'=>$prg
				);

				$dl->insert("programs",$data);
				$count++;
			}
		}
		echo("Imported $count files.");
	}
?>
