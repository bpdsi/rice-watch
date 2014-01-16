<?
//include"commonRW.php";
function getMethodPerPeriod($periodgrownm, $rvID, $rpsID, $rpmID){
global $widthBtn;
//$widthBtn=100;
//echo "periodgrownm:=".$periodgrownm."<hr>";
//if($periodgrownm=="ระยะน้ำนมและข้าวสุก")$periodgrownm="ออกรวง";
//if($periodgrownm=="ระยะตั้งท้อง")$periodgrownm="ออกดอก";

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
//*************** เชคระยะการเติบโต ******************
$sql="select rice_procedure.id_method, rice_procedure_detail.method_detail, rice_procedure_detail.periodgrownm  
		from rice_procedure, rice_procedure_detail
		where rice_procedure_detail.id_method=rice_procedure.id_method";
if($periodgrownm!="")$sql.= " and rice_procedure_detail.periodgrownm like '%".$periodgrownm."%'";
if($rice_variety!="")$sql.= " and rice_procedure.rice_variety = '".$rice_variety."'";
if($season!="")$sql.= " and rice_procedure.season like '%".$season."%'";
if($rice_method!="")$sql.= " and rice_procedure.rice_method like '%".$rice_method."%'";

//echo "<br>".$sql."<hr>";
$r = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($r);
	$text0.="<table class='methodTable' style='width:".$widthBtn."px' >";

	//$text1.="<tr><td method_id='$row[id]' class='methodTD' colspan='2' style=\"\"><b>".$no.$row[1]."</b></td></tr>";
	$text1.="<tr><td periodgrownm='$row[periodgrownm]' class='methodTD' colspan='2' style=\"\"><b>วิธีการดูแล".$periodgrownm."</b></td></tr>";
	echo $text0.$text1;
	echo"</table>";
}

?>


