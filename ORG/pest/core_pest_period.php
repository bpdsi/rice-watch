<?
function getPestPerPeriod($periodgrownm, $regionnm){
global $widthBtn;
if($periodgrownm=="ระยะน้ำนมและข้าวสุก")$periodgrownm="ระยะออกรวง";
if($periodgrownm=="ระยะตั้งท้อง")$periodgrownm="ระยะออกดอก";
	$region=array("ทุกภาค","ภาคกลาง", "ภาคเหนือ", "ภาคตะวันออกเฉียงเหนือ", "ภาคใต้", "ภาคตะวันตก", "ภาคตะวันออก");
	//*************** เชคระยะการเติบโต ******************
	$sql="SELECT grow.periodgrownm, grow.id FROM pest_management.t_periodgrow as grow where grow.periodgrownm<>''";
	if($periodgrownm!="")$sql.= " and grow.periodgrownm like '%".$periodgrownm."%'";
	$r = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($r);
	if($row[0]!=""){	
		//*************** ดึงสถานที่ เพื่อหาสมาชิกที่โดนผลกระทบ ******************  
		$sql_loc = "SELECT t_p.pest_id, t_p.CommonName, t_p.Prevention, t_p.Curative, t_p.Pesticide  FROM pest_management.t_pest as t_p WHERE t_p.SpreadingPeriod  LIKE 
			'%".$row[0]."%' ";
		//echo $sql_loc;
		//if($regionnm!="")$sql_loc.= " and t_p.location like '%$regionnm%' ";
			$r_loc = mysql_query($sql_loc)or die("error<br>$sql_loc");
			$num=mysql_num_rows($r_loc);
		if($num>1){
			$text0="<button id=\"btnPest".$row["id"]."\" style=\"width:".$widthBtn."px;border:solid 1px #5882FA;background-color:#5882FA;\">มีจำนวน ".$num." แมลง</button>";
			$text0.="<div id=\"Pest".$row["id"]."\" style=\"background-color:#FFF;\">";
		}
			$text0.="<table>";
			$f=0;
			$text1="";
			while( $row2=mysql_fetch_array($r_loc)){
				$f++;
				if($num==1){
					$no="";
				}else{
					$no=$f.") ";
				}				
				$text1.="<tr><td colspan='2' width='".$widthBtn."px' style=\"border:solid 1px #5882FA;background-color:#5882FA;\"><b>".$no.$row2[1]."</b></td></tr>";
				
				$text2="<tr><td colspan='2'><b>การป้องกัน:</b></td></tr>
							<tr><td>&nbsp;</td><td><div style='width: 260px;'><pre1>".$row2["Prevention"]."</pre1></div></td></tr>";
			}
			echo $text0.$text1;
		if($num>1){	
			echo"</table></div>";
		}else{
			echo"</table>";
		}
	}
}
?>


