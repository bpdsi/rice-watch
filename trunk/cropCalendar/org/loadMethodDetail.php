<?php
	include "../function/functionPHP.php";
	noCache();
	headerEncode();
	host();
	
	$rvID=$_POST["rvID"];
	$rpsID=$_POST["rpsID"];
	$rpmID=$_POST["rpmID"];
	$periodgrownm=$_POST["periodgrownm"];
	
	$sqlVariety="select rvName from crop_calendar.rice_varieties
			where rvID=".$rvID;
	$rVariety = mysql_query($sqlVariety) or die(mysql_error());
	$rowVariety = mysql_fetch_array($rVariety);
	$rice_variety=$rowVariety["rvName"];

	$sqlSeason="select rpsName from crop_calendar.rice_planting_season
				where rpsID=".$rpsID;
	$rSeason = mysql_query($sqlSeason) or die(mysql_error());
	$rowSeason = mysql_fetch_array($rSeason);
	$season=$rowSeason["rpsName"];

	$sqlMethod="select rpmName from crop_calendar.rice_planting_method
				where rpmID=".$rpmID;
	$rMethod = mysql_query($sqlMethod) or die(mysql_error());
	$rowMethod = mysql_fetch_array($rMethod);
	$rice_method=$rowMethod["rpmName"];
	$sql="select rice_procedure.id_method, rice_procedure_detail.method_detail  
		from rice_procedure, rice_procedure_detail
		where rice_procedure_detail.id_method=rice_procedure.id_method";
	if($periodgrownm!="")$sql.= " and rice_procedure_detail.periodgrownm like '%".$periodgrownm."%'";
	if($rice_variety!="")$sql.= " and rice_procedure.rice_variety = '".$rice_variety."'";
	if($season!="")$sql.= " and rice_procedure.season like '%".$season."%'";
	if($rice_method!="")$sql.= " and rice_procedure.rice_method like '%".$rice_method."%'";

	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
?>
<table class="noSpacing">
	<tr>
		<td class="detailTitle">วิธีการดูแล</td>
		<td class="detailContent"><?php echo $row[method_detail]?></td>
	</tr>
</table>