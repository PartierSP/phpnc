<?php
	function gPost($name, $default){
		if(isset($_POST[$name])){
			return $_POST[$name];
		} else {
			return $default;
		}
	}
	
	function gGet($name, $default){
		if(isset($_GET[$name])){
			return $_GET[$name];
		} else {
			return $default;
		}
	}

	function renumber($program, $startline, $increment){
		$lines=explode("\n", $program);
		$program="";
		$i=$startline;
		foreach($lines as $line){
			$parsed=getLineVarValue($line,"N");
			if($parsed==false){
				$program.=$line . "\n";
			} else {
				$program.=$parsed["start"] . $i . $parsed["end"];
				$i=$i+$increment;
			}
		}
		return($program);
	}

	function getLineVarValue($line, $variable){
		for($i=0;$i=strlen($line);$i++){
			$variable=strtoupper($variable);
			$pos=strpos($line,$variable);
			if($pos===false){
				return false;
			} else {
				$start=substr($line,0,$pos+1);
				$value="";
				$c="";
				do {
					$value.=$c;
					$pos++;
					$c=substr($line,$pos,1);
				}while((ord($c)>47 && ord($c)<58) || ord($c)==45 || ord($c)==46);
				if($value==""){
					return false;
				}
				$end=substr($line,$pos);
				$retn=array(
					"start"=>$start,
					"value"=>$value,
					"end"=>$end);
				return $retn;
			}
		}
	}

	function scaleshift($program, $action, $axis, $mod, $prec, $firstline, $lastline){
		if($mod==""){
			$message="No changes made. Modification value was not set.";
		} else {
			$axis=strtoupper($axis);
			$lines=explode("\n",$program);
			$program="";
			$changes=0;
			switch($axis){
				case "F":
				case "I":
				case "J":
				case "K":
				case "X":
				case "Y":
				case "Z":
					foreach($lines as $line){
						$t=getLineVarValue($line,"N");
						if($t==false){
							$program.=$line;
						} else {
							if((intval($t["value"])>=intval($firstline)) && (intval($t["value"])<=intval($lastline))){
								$parsed=getLineVarValue($line,$axis);
								if($parsed==false){
									$program.=$line;
								} else {
									if($action=="scale"){
										$newval=$parsed["value"]*$mod;
									} else {
										$newval=$parsed["value"]+$mod;
									}
									$newval=round($newval,$prec);
									if(($newval==intval($newval)) && ($newval<>0)){
										$program.=$parsed["start"] . $newval . "." . $parsed["end"];
									} else {
										$program.=$parsed["start"] . $newval . $parsed["end"];
									}
									$changes++;
								}
							} else {
								$program.=$line;
							}
						}
					}
					break;
				default:
			}
			if($action=="scale"){
				$msgdesc="Scaled";
			} else {
				$msgdesc="Shifted";
			}
			$message= $msgdesc . " ". $axis . " by " . $mod . " in " . $changes . " place(s).";
		}
		$results=array($program,$message);
		return $results;
	}

	function AddWhiteSpace($program, $tabs){
		$clast="";
		$prg="";
		if($tabs=="tabs"){
			$wschr=9;
		} else {
			$wschr=32;
		}
		for($i=0;$i<=strlen($program);$i++){
			$c=substr($program,$i,1);
			if(((ord($c)>64 && ord($c)<91) || ord($c)==40) && ((ord($clast)>45) && (ord($clast)<58))){
				$prg.=chr($wschr) . $c;
			} else {
				$prg.=$c;
			}
			$clast=$c;
		}
		return($prg);
	}

	function StripWhiteSpace($program){
		$whitespace=array(' ', "\t");
		$prg='';
		$lines=explode("\n", $program);
//		$ii=0;
		foreach($lines as $line){
//			echo "Line $ii: $line<br/>\n";
//			$ii++;
			if(strpos($line, '(')===false){
				$prg.=str_replace($whitespace, '', $line);
			} else {
				$l=explode('(', $line);
				foreach($l as $i=>$portion){
					if($i==0){
						$prg.=str_replace($whitespace, '', $portion);
					} else {
						$prg.='('.$portion;
					}
				}
			}
		}
		return $prg;
	}
?>
