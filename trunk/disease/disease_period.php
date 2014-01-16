<title>Mr.CyBerBrain</title>
<link rel="stylesheet" type="text/css" href="./style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
body {
	background-color: #F93;
}
-->
</style>
<?
include"commonRW.php";
//include"setfont.php";
//setfont();
$region=array("ทุกภาค","ภาคกลาง", "ภาคเหนือ", "ภาคตะวันออกเฉียงเหนือ", "ภาคใต้", "ภาคตะวันตก", "ภาคตะวันออก");
echo "<table>";
echo"<tr valign='top'>";
//*************** เชคระยะการเติบโต ******************
$sql="SELECT periodgrownm FROM t_periodgrow order by id";

$r = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($r)):
	echo "<td>
			<table>
				<tr><td>ระยะเวลาของการปลูก : ".$row[0]."</td></tr>
				<tr><td><hr></td></tr>";
	for($rex=0;$rex<count($region);$rex++){		
		//*************** ดึงสถานที่ เพื่อหาสมาชิกที่โดนผลกระทบ ******************  
		$sql_loc = "SELECT location,diseasenm, prevent ,prevent_short FROM t_disease WHERE t_disease.periodgrownm  LIKE 
		'%".$row[0]."%' and (prevent_short<>'' or prevent<>'') and location like '%$region[$rex]%' ";
		if($periodgrownm!="")$sql_loc .= " and periodgrownm='".$periodgrownm."'";
		//echo $sql_loc."<br>";
		$r_loc = mysql_query($sql_loc)or die("error<br>$sql_loc");
		$num=mysql_num_rows($r_loc);
		if($num>0)
		echo"<tr><td><b><u>".$region[$rex]."</u></b></td></tr>";
		$f=0;
		while( $row2=mysql_fetch_array($r_loc)){
			$f++;
			/*if($row2[3]=="")
			 $row2[3]=str_replace(iconv("tis-620","utf-8","<br>"),iconv("tis-620","utf-8",""),trim($row2[2]));*/

			$text1="<table>
						<tr><td colspan='2'><b>".$f.") โรค: ".$row2[1]."</b></td></tr>
						<tr><td colspan='2'><b>การป้องกัน:</b></td></tr>
						<tr><td>&nbsp;</td><td><div style='width: 260px;'><pre1>".$row2[2]."</pre1></div></td></tr>
					</table>";
			
			echo"<tr><td>".$text1."</td></tr>";

			$loc=split(",",$row2[0]);
			$where="";
			$cou= count($loc);
			$nameLocation="";
			for($x=0;$x<count($loc);$x++){
				$lovnm=str_replace(iconv("tis-620","utf-8","อีสาน"),iconv("tis-620","utf-8","ตะวันออกเฉียงเหนือ"),trim($loc[$x]));
				$lovnm=str_replace(iconv("tis-620","utf-8","ภาค"),iconv("tis-620","utf-8",""),trim($lovnm));
				//$lovnm=iconv("tis-620","utf-8","ภาค").trim($lovnm);
				$lovnm="ภาค".trim($lovnm);
				$lovnm=str_replace("ภาคภาค","ภาค",trim($lovnm));
				if($nameLocation==""){
					$nameLocation=$lovnm;
				}else{
					$nameLocation.=", ".$lovnm;
				}
				if($cou>1){
					if($x==0)
						$where.=" and (region_name LIKE '%".$lovnm."%'";
					elseif($x<$cou-1)
							$where.=" or region_name LIKE '%".$lovnm."%'";
					elseif($x==$cou-1)
							$where.=" or region_name LIKE '%".$lovnm."%')";
					else
							$where=" and (region_name LIKE '%".$lovnm."%')";
				}
			}
		}
	}echo"<tr><td><hr></td></tr>";
echo"</table></td>";
endwhile;
echo"</tr>";
echo"</table>";

?>


