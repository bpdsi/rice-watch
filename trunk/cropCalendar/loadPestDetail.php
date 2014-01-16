<?php
	include "../function/functionPHP.php";
	noCache();
	headerEncode();
	host();
	
	$pest_id=$_POST["pest_id"];
	
	$query="
		select	*
		from	pest_management.t_pest
		where	pest_id='$pest_id'
	";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
?>
<table class="noSpacing">
	<tr>
		<td class="detailTitle">ชื่อแมลง : </td>
		<td class="detailContent"><?php echo $row[CommonName]?></td>
	</tr>
	<!--<tr>
		<td class="detailTitle">Sciencetific Name : </td>
		<td class="detailContent"><?php echo $row[ScientificName]?></td>
	</tr>-->
	<tr>
		<td class="detailTitle">ชื่อท้องถิ่น : </td>
		<td class="detailContent"><?php echo $row[LocalName]?></td>
	</tr>
	<!--<tr>
		<td class="detailTitle">Other Name : </td>
		<td class="detailContent"><?php echo $row[OtherName]?></td>
	</tr>-->
	<tr>
		<td class="detailTitle">ลักษณะของแมลง : </td>
		<td class="detailContent"><?php echo $row[Characteristics]?></td>
	</tr>
	<tr>
		<td class="detailTitle">ลักษณะการทำลาย : </td>
		<td class="detailContent"><?php echo $row[DamageMethod]?></td>
	</tr>
	<!--<tr>
		<td class="detailTitle">Cause Symptom : </td>
		<td class="detailContent"><?php echo $row[CauseSymptom]?></td>
	</tr>-->
	<tr>
		<td class="detailTitle">การป้องกันกำจัด : </td>
		<td class="detailContent"><?php echo $row[Prevention]?></td>
	</tr>
	<tr>
		<td class="detailTitle">วิธีการกำจัด : </td>
		<td class="detailContent"><?php echo $row[Curative]?></td>
	</tr>
	<tr>
		<td class="detailTitle">สารเคมีที่ใช้ : </td>
		<td class="detailContent"><?php echo $row[Pesticide]?></td>
	</tr>
</table>