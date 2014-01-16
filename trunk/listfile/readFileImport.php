<?
include"commonRW.php";
$dir = "/home/vasu/public_html/mt_respository/txt/";
$dir = "../images/animal/";
$dh  = opendir($dir);
$image=0;
while (false !== ($filename = readdir($dh))) {
	if(substr($filename,-4)==".jpg" or substr($filename,-4)==".JPG" ){
		$image++;
		$pest_idA=split("\.",$filename);
		$animal_id=$pest_idA[0];
		$path_image="images/animal/".$filename;
		$sqlimage="insert into t_animal_image(animal_id,path_image)values(".$animal_id.",'".$path_image."')";
		mysql_query($sqlimage) or die(mysql_error()."<br>".$sqlimage);
	
	}
}
echo "Complete amount:=".$image;
?>