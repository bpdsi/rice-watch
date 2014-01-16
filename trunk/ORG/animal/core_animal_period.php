<?
function getAnimalPerPeriod($periodgrownm, $regionnm){
global $widthBtn;
if($periodgrownm=="ระยะน้ำนมและข้าวสุก")$periodgrownm="ออกรวง";
if($periodgrownm=="ระยะตั้งท้อง")$periodgrownm="ออกดอก";
$region=array("ทุกภาค","ภาคกลาง", "ภาคเหนือ", "ภาคตะวันออกเฉียงเหนือ", "ภาคใต้", "ภาคตะวันตก", "ภาคตะวันออก");
$region=array("ภาคเหนือ");
//*************** เชคระยะการเติบโต ******************
$sql="SELECT grow.periodgrownm, grow.id FROM pest_management.t_periodgrow as grow where grow.periodgrownm<>''";
if($periodgrownm!="")$sql.= " and grow.periodgrownm like '%".$periodgrownm."%'";

$r = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($r);
	if($row[0]!=""){
		$sql_loc = "SELECT t_a.Region,t_a.CommonName, t_a.Prevention FROM pest_management.t_animal as t_a WHERE t_a.FoundPeriod  LIKE '%".$row[0]."%' ";
		if($regionnm!="")$sql_loc.= " and t_a.Region like '%$regionnm%' ";
		$r_loc = mysql_query($sql_loc)or die("error<br>$sql_loc");
		$num=mysql_num_rows($r_loc);
		if($num>1){
			$text0="<button id=\"btnAnimal".$row["id"]."\" style=\"width:".$widthBtn."px;border:solid 1px #FE642E;background-color:#FE642E;\">มีจำนวน ".$num." ตัว</button>";
			$text0.="<div id=\"Animal".$row["id"]."\" style=\"background-color:#FFF;\">";
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
				$text1.="<tr><td colspan='2' style=\"width:".$widthBtn."px;border:solid 1px #FE642E;background-color:#FE642E;\"><b>".$no.$row2[1]."</b></td></tr>";
				
				$text2="<tr><td colspan='2'><b>การป้องกัน:</b></td></tr>
							<tr><td>&nbsp;</td><td><div style='width: 260px;'><pre1>".$row2[2]."</pre1></div></td></tr>";
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


