<html>
<head>
</head>
<body>
<table>
<tr>
<th>Description</th>
<th>File Name</th>
<th>Date</th>
</tr>

<?php
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
			echo('<tr><td>'.$desc.'</td><td>'.$file.'</td><td>'.$month.'/'.$day.'/'.$year.'</td></tr>');
		}
	}
?>
</table>
</body>
</html>
