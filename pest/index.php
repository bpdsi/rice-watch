<?
include"commonRW.php";
$region=array("ทุกภาค","ภาคกลาง", "ภาคเหนือ", "ภาคตะวันออกเฉียงเหนือ", "ภาคใต้", "ภาคตะวันตก", "ภาคตะวันออก");
echo "<table class='table_01'  id=\"tblElement\" style='margin-left:auto;margin-right: auto;margin-top: 5px;width:600px'>";
echo "<tr class='table_header table_topRadius'>
		<td  width='30%'>ระยะเวลาของการปลูก</td><td>แมลงศัตรูข้าว</td>
	</tr>";
//*************** เชคระยะการเติบโต ******************
$sql="SELECT periodgrownm FROM t_periodgrow order by id";

$r = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($r)):
	echo"<tr valign='top'>";
	echo "<td>".$row[0]."</td>";
		//*************** ดึงสถานที่ เพื่อหาสมาชิกที่โดนผลกระทบ ******************  
		$sql_loc = "SELECT pest_id, CommonName,Prevention, Curative, Pesticide  FROM t_pest WHERE t_pest.SpreadingPeriod  LIKE 
		'%".$row[0]."%' ";// and location like '%$region[$rex]%' ";
		//echo $sql_loc."<br>";
		$r_loc = mysql_query($sql_loc)or die("error<br>$sql_loc");
		$num=mysql_num_rows($r_loc);
		$f=0;
		echo"<td><table>";
		while( $row2=mysql_fetch_array($r_loc)){
			$f++;
			echo"<tr><td colspan='2'><b><a href=\"?page=pest/PestDetail.php&pest_id=".$row2[0]."\">".$f.")".$row2[1]."</a></b></td></tr>";
		}
		echo"</table></td>";
	echo"</tr>";
endwhile;
echo"</table>";

?>


