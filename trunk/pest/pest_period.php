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
	//for($rex=0;$rex<count($region);$rex++){		
		//*************** ดึงสถานที่ เพื่อหาสมาชิกที่โดนผลกระทบ ******************  
		$sql_loc = "SELECT pest_id, CommonName,Prevention, Curative, Pesticide  FROM t_pest WHERE t_pest.SpreadingPeriod  LIKE 
		'%".$row[0]."%' ";// and location like '%$region[$rex]%' ";
		//echo $sql_loc."<br>";
		$r_loc = mysql_query($sql_loc)or die("error<br>$sql_loc");
		$num=mysql_num_rows($r_loc);
		//if($num>0)
		//echo"<tr><td><b><u>".$region[$rex]."</u></b></td></tr>";
		$f=0;
		while( $row2=mysql_fetch_array($r_loc)){
			$f++;
			$text1="<table>
						<tr><td colspan='2'><b>".$f.") แมลงศัตรูข้าว: ".$row2[1]."</b></td></tr>
						<tr><td colspan='2'><b>การป้องกัน:</b></td></tr>
						<tr><td>&nbsp;</td><td><div style='width: 260px;'><pre1>".$row2["Prevention"]."</pre1></div></td></tr>
						<tr><td colspan='2'><b>วิธีใช้:</b></td></tr>
						<tr><td>&nbsp;</td><td><div style='width: 260px;'><pre1>".$row2["Curative"]."</pre1></div></td></tr>
						<tr><td colspan='2'><b>สารเคมี:</b></td></tr>
						<tr><td>&nbsp;</td><td><div style='width: 260px;'><pre1>".$row2["Pesticide"]."</pre1></div></td></tr>
					</table>";
			echo"<tr><td>".$text1."</td></tr>";
		}
	//}
	echo"<tr><td><hr></td></tr>";
echo"</table></td>";
endwhile;
echo"</tr>";
echo"</table>";

?>


