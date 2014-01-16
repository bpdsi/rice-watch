<?
//include"commonRW.php";
function getDiseasePerPeriod($periodgrownm, $regionnm){
global $widthBtn;
//$widthBtn=100;
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
		$sql_loc = "SELECT t_d.location,t_d.diseasenm, t_d.prevent ,t_d.prevent_short, t_d.disease_id 
					FROM pest_management.t_disease as t_d 
					WHERE t_d.periodgrownm  LIKE '%".$row[0]."%' and (t_d.prevent_short<>'' or t_d.prevent<>'')";
		if($regionnm!="")$sql_loc.= " and t_d.location like '%$regionnm%' ";
		$r_loc = mysql_query($sql_loc)or die("error<br>$sql_loc");
		$num=mysql_num_rows($r_loc);
		if($num>1){
			$text0="<button id=\"btnDisease".$row["id"]."\" style=\"width:".$widthBtn."px;border:solid 1px #2EFE2E;background-color:#2EFE2E;\">มีโรค ".$num." ชนิด</button>";
			$text0.="<div id=\"Disease".$row["id"]."\" style=\"background-color:#FFF;\">";
		}
			$text0.="<table class='diseaseTable' style='width:".$widthBtn."px' >";
			$f=0;
			$text1="";
			while( $row2=mysql_fetch_array($r_loc)){
				$f++;
				if($num==1){
					$no="";
				}else{
					$no=$f.") ";
				}	
				$text1.="<tr><td disease_id='$row2[disease_id]' class='diseaseTD' colspan='2' style=\"\"><b>".$no.$row2[1]."</b></td></tr>";
				
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


