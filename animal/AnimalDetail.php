<?
//include"commonRW.php";
$animal_id=$_GET["animal_id"];
$sql = "SELECT * 
	FROM pest_management.t_animal as t_a 
	WHERE t_a.animal_id=".$animal_id;
$rPest=mysql_query($sql)or die(mysql_error()."<br>".$sql);
$rowPest=mysql_fetch_array($rPest);
$CommonName=$rowPest["CommonName"]." ".$rowPest["CommonName_En"];
$ScientificName=$rowPest["ScientificName"];
$OtherName=$rowPest["OtherName"];
$LocalName=$rowPest["LocalName"];
$Characteristics=$rowPest["Characteristics"];
$DamageMethod=$rowPest["DamageMethod"];
$Region=$rowPest["Region"];
$FoundPeriod=$rowPest["FoundPeriod"];
$Prevention=$rowPest["Prevention"];
$Curative=$rowPest["Curative"];
$Pesticide=$rowPest["Pesticide"];

function vertical_Image($imgList){
	$contnt='
				<tr>';
	if(count($imgList)-1>0){
		$widthx=390/(count($imgList)-1);
	}else{
		$widthx=390;	
	}
	//echo $widthx."=".count($imgList)."<hr>";
	for($i=0;$i<count($imgList);$i++){
		$path_img=$imgList[$i];
		if($i==0){
			$image[$i]='<div style="width:398px;height:264px;">
							<img class="img" src="'.$path_img.'" style="left:-17px;" width="400" height="264">
						</div>';
		}else{
			$image[$i]='<div style="width:'.$widthx.'px;height:'.$widthx.'px;">
							<img class="_46-i img" src="'.$path_img.'" style="left:-5px; top:0px;" width="'.$widthx.'" height="'.$widthx.'">
						</div>';
		}
	}
	$contnt.="<td>".$image[0]."</td></tr>
			  <tr>
				<td><table>
						<tr>";
						for($i=1;$i<count($imgList);$i++){
							$contnt.="<td>".$image[$i]."</td>";
						}
						$contnt.="</tr>
				</table></td>";
	$contnt.="</tr>";
	return $contnt;
}
function horizontal_Image($imgList){
		$contnt='
				<tr>';
	if(count($imgList)-1>0){
		$widthx=390/(count($imgList)-1);
	}else{
		$widthx=390;	
	}
	//echo $widthx."=".count($imgList)."<hr>";
	for($i=0;$i<count($imgList);$i++){
		$path_img=$imgList[$i];
		if($i==0){
			$image[$i]='<div class="_46-h _5pc3" style="width:264px;height:398px;">
							<img class="_46-i img" src="'.$path_img.'" style="left:-5px; top:0px;" width="274" height="400">
						</div>';
		}else{
			$image[$i]='<div class="_46-h _5pc3" style="width:'.$widthx.'px;height'.$widthx.'px;">
							<img class="_46-i img" src="'.$path_img.'" style="left:-61px; top:0px;" width="'.$widthx.'" height="'.$widthx.'">
						</div>';
		}
	}
	$contnt.="<td>".$image[0]."</td>
			  <td>
				<table>";
					for($i=1;$i<count($imgList);$i++){
							$contnt.="<tr><td>".$image[$i]."</td></tr>";
					}
				$contnt.="</table>
			</td>";
	$contnt.="</tr>";
	return $contnt;
}


$sqlimge="select path_image from pest_management.t_animal_image where animal_id=".$animal_id;
$rImge=mysql_query($sqlimge)or die(mysql_error());
$listImages="<table border=1>";
$listImages.="<tr><td>รูปภาพ</td></tr>";
$img=0;
while($rowImge=mysql_fetch_array($rImge)):
	//$listImages.="<tr><td><img src='".$rowImge["path_image"]."' width='300px'></td></tr>";
	$filename=$rowImge["path_image"]; 
	if (file_exists($filename)) {
		$path_img[$img]=$filename;
		$img++;
	}
endwhile;
	/*list($width, $height, $type, $attr) = getimagesize($path_img[0]);
	if($width>$height){
		$listImages.= vertical_Image($path_img);
	}else{
		$listImages.= horizontal_Image($path_img);
	}*/
	if(count($path_img)<4){
		list($width, $height, $type, $attr) = getimagesize($path_img[0]);
		if($width>$height){
			$listImages.=  vertical_Image($path_img);
		}else{
			$listImages.=  horizontal_Image($path_img);
		}
	}else{
		for($i=0;$i<4;$i++){
			$path_img1[$i]=$path_img[$i];
		}
		list($width, $height, $type, $attr) = getimagesize($path_img1[0]);
		if($width>$height){
			$listImages.=  vertical_Image($path_img1);
		}else{
			$listImages.=  horizontal_Image($path_img1);
		}
		$listImages.=  "<hr>";
		$n=0;
		for($i=4;$i<count($path_img);$i++){
			$path_img2[$n]=$path_img[$i];
			$n++;
		}
		list($width, $height, $type, $attr) = getimagesize($path_img2[0]);
		if($width>$height){
			$listImages.=  vertical_Image($path_img2);
		}else{
			$listImages.=  horizontal_Image($path_img2);
		}
	}
$listImages.="</table>";

?>
<table class='table_01'  id=\"tblElement\" border=1 style='margin-left:auto;margin-right: auto;margin-top: 5px;width:1000px'>
	<tr valign="top">
		<td width="200px" class='table_header'>ชื่อศัตรูข้าว</td>
		<td><?=$CommonName?></td>
		<td rowspan="12"><? echo $listImages;?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>ชื่อวิทยาศาสตร์</td>
		<td><?=$ScientificName?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>วงศ์/อันดับ</td>
		<td><?=$OtherName?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>ชื่อท้องถิ่น</td>
		<td><?=$LocalName?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>ลักษณะของศัตรู</td>
		<td><?=$Characteristics?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>ลักษณะการทำลาย</td>
		<td><?=$DamageMethod?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>ระยะระบาด</td>
		<td><?=$FoundPeriod?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>พื้นที่ระบาด</td>
		<td><?=$Region?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>การป้องกันกำจัด</td>
		<td><?=$Prevention?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>วิธีการกำจัด</td>
		<td><?=$Curative?></td>
	</tr>
	<tr valign="top">
		<td width="200px" class='table_header'>สารเคมีที่ใช้</td>
		<td><?=$Pesticide?></td>
	</tr>
	<tr valign="top">
		<td colspan="2" align="right"><a href="?page=animal/index.php">กลับหน้ารายการ</a></td>
	</tr>
</table>