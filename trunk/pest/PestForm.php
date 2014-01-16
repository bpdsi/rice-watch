<?
include"commonRW.php";
$pest_id=$_GET["pest_id"];
$sql="SELECT pest_id, CommonName,ScientificName, OtherName, LocalName, Characteristics, 
			DamageMethod, CauseSymptom, SpreadingPeriod, FoundPeriod, Prevention, Curative, Pesticide  
	FROM t_pest WHERE pest_id=".$pest_id;
$rPest=mysql_query($sql);
$rowPest=mysql_fetch_array($rPest);
$CommonName=$rowPest["CommonName"];
$ScientificName=$rowPest["ScientificName"];
$OtherName=$rowPest["OtherName"];
$LocalName=$rowPest["LocalName"];
$Characteristics=$rowPest["Characteristics"];
$DamageMethod=$rowPest["DamageMethod"];
$SpreadingPeriod=$rowPest["SpreadingPeriod"];
$FoundPeriod=$rowPest["FoundPeriod"];
$Prevention=$rowPest["Prevention"];
$Curative=$rowPest["Curative"];
$Pesticide=$rowPest["Pesticide"];
?>
<form name="addPestForm" method="POST">
<table>
	<tr>
		<td>ชื่อแมลงศัตรู</td>
		<td><input type="text" name="CommonName" id="CommonName" value="<?=$CommonName?>"></td>
	</tr>
	<tr>
		<td>ชื่อวิทยาศาสตร์</td>
		<td><input type="text" name="ScientificName" id="ScientificName" value="<?=$ScientificName?>"
	</tr>
	<tr>
		<td>วงศ์/อันดับ</td>
		<td><input type="text" name="OtherName" id="OtherName" value="<?=$OtherName?>"
	</tr>
	<tr>
		<td>ชื่อท้องถิ่น</td>
		<td><input type="text" name="LocalName" id="LocalName" value="<?=$LocalName?>"
	</tr>
	<tr>
		<td>ลักษณะของแมลง</td>
		<td><textarea name="Characteristics" id="Characteristics" cols="30" rows="2"><?=$Characteristics?></textarea></td>
	</tr>
	<tr>
		<td>ลักษณะการทำลาย</td>
		<td><input type="text" name="DamageMethod" id="DamageMethod" value="<?=$DamageMethod?>"
	</tr>
	<tr>
		<td>ลักษณะหลังจากโดนทำลาย</td>
		<td><input type="text" name="CauseSymptom" id="CauseSymptom" value="<?=$CauseSymptom?>"
	</tr>
	<tr>
		<td>ระยะระบาด</td>
		<td><input type="text" name="SpreadingPeriod" id="SpreadingPeriod" value="<?=$SpreadingPeriod?>"
	</tr>
	<tr>
		<td>แพร่ระบาด</td>
		<td><input type="text" name="FoundPeriod" id="FoundPeriod" value="<?=$FoundPeriod?>"
	</tr>
	<tr>
		<td>การป้องกันกำจัด</td>
		<td><textarea name="Prevention" id="Prevention" cols="30" rows="2"><?=$Prevention?></textarea></td>
	</tr>
	<tr>
		<td>วิธีการกำจัด</td>
		<td><textarea name="Curative" id="Curative" cols="30" rows="2"><?=$Curative?></textarea></td>
	</tr>
	<tr>
		<td>สารเคมีที่ใช้</td>
		<td><input type="text" name="Pesticide" id="Pesticide" value="<?=$Pesticide?>"
	</tr>
</table>
</form>