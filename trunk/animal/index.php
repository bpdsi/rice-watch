<?
$region=array("ทุกภาค","ภาคกลาง", "ภาคเหนือ", "ภาคตะวันออกเฉียงเหนือ", "ภาคใต้", "ภาคตะวันตก", "ภาคตะวันออก");
echo "<table class='table_01'  id=\"tblElement\" style='margin-left:auto;margin-right: auto;margin-top: 5px;width:600px'>";
echo "<tr class='table_header table_topRadius'>
		<td  width='30%'>ระยะเวลาของการปลูก</td><td>ศัตรูข้าว</td>
	</tr>";
//*************** เชคระยะการเติบโต ******************
$sql="SELECT grow.periodgrownm, grow.id FROM pest_management.t_periodgrow as grow where grow.periodgrownm<>''";
if($periodgrownm!="")$sql.= " and grow.periodgrownm like '%".$periodgrownm."%'";

$r = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($r)):
	echo"<tr valign='top'>";
	echo "<td>".$row[0]."</td>";
		//*************** ดึงสถานที่ เพื่อหาสมาชิกที่โดนผลกระทบ ******************  
		$sql_loc = "SELECT t_a.Region,t_a.CommonName, t_a.Prevention, t_a.animal_id FROM pest_management.t_animal as t_a WHERE t_a.FoundPeriod  LIKE '%".$row[0]."%' ";
		if($regionnm!="")$sql_loc.= " and t_a.Region like '%$regionnm%' ";
		//echo $sql_loc."<br>";
		$r_loc = mysql_query($sql_loc)or die("error<br>$sql_loc");
		$num=mysql_num_rows($r_loc);
		$f=0;
		echo"<td><table>";
		while( $row2=mysql_fetch_array($r_loc)){
			$f++;
			echo"<tr><td colspan='2'><b><a href=\"?page=animal/AnimalDetail.php&animal_id=".$row2["animal_id"]."\">".$f.")".$row2["CommonName"]."</a></b></td></tr>";
		}
		echo"</table></td>";
	echo"</tr>";
endwhile;
echo"</table>";

?>


