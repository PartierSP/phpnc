<?php
	session_start();
	header("Cache-control: private");
	
	require_once("Smarty.class.php");
	require_once("inc_functions.php");
	require_once("inc_variables.php");
	require_once("inc_datalayer.php");

	$smarty=new Smarty();
	
	$action=gPost("action","");
	$sbfile=gPost("sbfile","");
	$cb1=gPost("cb1","");
	$cb2=gPost("cb2","");

	if($action=="open" && $sbfile>""){

		$handle=fopen('data/'.$sbfile, "rb");
		$program="";
		while (!feof($handle)){
			$program.=fread($handle,512);

			//Abort while if no data is read
			$stream_meta_data = stream_get_meta_data($handle);
			if($stream_meta_data['unread_bytes'] <= 0){
				break;
			}

		}
		if($cb1=="spaces"){
			$program=AddWhiteSpace($program, $cb2);
		}
		//Repair Fadal newline oddity.
		$program=str_replace(chr(10).chr(13),chr(13).chr(10),$program);

		$url = 'editor.php';
		$data = array('program' => htmlspecialchars($program));

		$smarty->assign("program",$program);
		$smarty->assign("url",$url);
		$smarty->assign("data",$data);
		$smarty->display("redirect.tpl");

	} else {

		$filelist=importET();
		
		foreach($filelist as $d_row){
			if($d_row['desc']==""){
				$desc[]=$d_row['file'] . ' - ' . $d_row['date'];
			} else {
				$desc[]=$d_row['desc'] . ' - ' . $d_row['date'];
			}
			$file[]=$d_row['file'];
		}
		
		$smarty->assign("filename",$file);
		$smarty->assign("desc",$desc);
		$smarty->display("open.tpl");
	}

	
function importET(){
	$filename="data/ETPARTS.DAT";
	
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
			//echo('<tr><td>'.$desc.'</td><td>'.$file.'</td><td>'.$month.'/'.$day.'/'.$year.'</td></tr>');
			$array[]=array(
				"desc"=>$desc,
				"file"=>$file,
				"date"=>$year.'/'.$month.'/'.$day
			);
		}
	}
	return $array;
}
?>
