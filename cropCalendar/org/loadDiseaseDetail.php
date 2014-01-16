<?php
	include "../function/functionPHP.php";
	noCache();
	headerEncode();
	host();
	
	$disease_id=$_POST["disease_id"];
	
	$query="
		select	*
		from	pest_management.t_disease
		where	disease_id='$disease_id'
	";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
?>
<table class="noSpacing">
	<tr>
		<td class="detailTitle">ชื่อโรค : </td>
		<td class="detailContent"><?php echo $row[diseasenm]?> (<?php echo $row[diseasenm_en]?>)</td>
	</tr>
	<!--<tr>
		<td class="detailTitle">Description : </td>
		<td class="detailContent"><?php echo $row[description]?></td>
	</tr>
	<tr>
		<td class="detailTitle">Pathogen : </td>
		<td class="detailContent"><?php echo $row[pathogen]?></td>
	</tr>-->
	<tr>
		<td class="detailTitle">ลักษณะอาการ : </td>
		<td class="detailContent"><?php echo $row[symptom]?></td>
	</tr>
	<!--<tr>
		<td class="detailTitle">Symptom Short : </td>
		<td class="detailContent"><?php echo $row[symptom_short]?></td>
	</tr>-->
	<tr>
		<td class="detailTitle">การแพร่ระบาด : </td>
		<td class="detailContent"><?php echo $row[outbreak]?></td>
	</tr>
	<tr>
		<td class="detailTitle">วิธีป้องกัน : </td>
		<td class="detailContent"><?php echo $row[Prevent]?></td>
	</tr>
	<!--<tr>
		<td class="detailTitle">Prevent Short : </td>
		<td class="detailContent"><?php echo $row[prevent_short]?></td>
	</tr>-->
	<tr>
		<td class="detailTitle">วิธีแก้ไข : </td>
		<td class="detailContent"><?php echo $row[treatment]?></td>
	</tr>
	<tr>
		<td class="detailTitle">สารเคมีที่ใช้ : </td>
		<td class="detailContent"><?php echo $row[medicine]?></td>
	</tr>
</table>