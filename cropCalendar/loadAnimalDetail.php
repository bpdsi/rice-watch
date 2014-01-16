<?php
	include "../function/functionPHP.php";
	noCache();
	headerEncode();
	host();
	
	$animal_id=$_POST["animal_id"];
	
	$query="
		select	*
		from	pest_management.t_animal
		where	animal_id='$animal_id'
	";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
?>
<table class="noSpacing">
	<tr>
		<td class="detailTitle">ชื่อศัตรู : </td>
		<td class="detailContent"><?php echo $row[CommonName]?> (<?php echo $row[CommonName_En]?>)</td>
	</tr>
	<!--<tr>
		<td class="detailTitle">Scientific Name : </td>
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
		<td class="detailTitle">ลักษณะของศัตรู : </td>
		<td class="detailContent"><?php echo $row[Characterisitcs]?></td>
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
	<tr>
		<td class="detailTitle">Source : </td>
		<td class="detailContent"><?php echo $row[Source]?></td>
	</tr>
</table>