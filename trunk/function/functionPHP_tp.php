<?php
	host();
//include"commonxx.php";
	$query="
		select	menu_id
		from	menu_detail
		where	menu_pages='$page'
	";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
	$menu_id=$row[menu_id];
	//$permission=permission($menu_id, $_SESSION[authen][ofID]);
	function headMeta(){
		global $path;
		?>
			<!-- Disable Cache [Use while developing] CSS-->
				<meta http-equiv="cache-control" content="no-cache" />
				
			<script type="text/javascript" src="<?=$path?>js/jquery-2.0.3.js"></script>
			<script type="text/javascript" src="<?=$path?>js/jquery-ui.js"></script>
			
			<link href="<?=$path?>images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
			
			<!-- Set Encoding -->
				<meta http-equiv="Content-Type"content="text/html; charset=utf-8" />
				<link type="text/css" rel="stylesheet" href="<?=$path?>css/style3.css"/>
			
			<!-- required plugins -->
				<script type="text/javascript" src="<?=$path?>js/date.js"></script>
			<!-- jquery.datePicker.js -->
				<script type="text/javascript" src="<?=$path?>js/jquery.datePicker.js"></script>
			<!-- datePicker required styles -->
				<link rel="stylesheet" type="text/css" media="screen" href="<?=$path?>css/datePicker.css">  		
			
			<link rel="stylesheet" type="text/css" href="<?=$path?>css/default.css">
			<link rel="stylesheet" type="text/css" href="<?=$path?>css/colorbox.css">
			<script type="text/javascript" src="<?=$path?>js/jquery.colorbox.js"></script>
			<link rel="stylesheet" type="text/css" href="<?=$path?>css/tpqi.css">
		<?php
	}
	
	function host(){
		global $db_host;
		global $db_user;
		global $db_pwd;
		global $db;
		global $conDB;
		global $objDB;
		$db_host="localhost";
		$db_user="rwii";
		$db_pwd="1234";
		$db="crop_calendar";
		$conDB=mysql_connect($db_host,$db_user,$db_pwd) or die ("Something is going wrong");
		$objDB=mysql_select_db($db);
		mysql_query("SET character_set_connection = UTF8")or die(mysql_error());
		mysql_query("SET character_set_client = UTF8")or die(mysql_error());
		mysql_query("SET character_set_results = UTF8")or die(mysql_error());
		mysql_query("SET NAMES UTF8")or die(mysql_error());
		
	}
	
	function get_cfgValue($cfgName){
		host("npr");
		$query="
			select	cfgValue
			from	config
			where	cfgName='$cfgName'
		";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		return $row[cfgValue];
	}
	
	function monNameENG($monNum){
		switch ($monNum){
			case "01": return "Jan";
			case "02": return "Feb";
			case "03": return "Much";
			case "04": return "Apr";
			case "05": return "May";
			case "06": return "Jun";
			case "07": return "Jul";
			case "08": return "Aug";
			case "09": return "Sep";
			case "10": return "Oct";
			case "11": return "Nov";
			case "12": return "Dec";
		}
	}
	
	function dateEncode($date){
		$temp=explode(" ", $date);
		$date=$temp[0];
		$time=$temp[1];
		
		$temp=explode("-", $date);
		$yearNum=$temp[0];
		$monNum=$temp[1];
		$dayNum=$temp[2];
		
		return $dayNum." ".monNameENG($monNum)." ".$yearNum." ".$time;
	}
	
	function authenticated(){
		host();
		$query="
			select	*
			from	officer
			where	user='".$_SESSION[authen][user]."' and
					pass='".$_SESSION[authen][pass]."'
		";
		$result=mysql_query($query);
		if(mysql_num_rows($result)>0){
			return true;
		}else{
			return false;
		}
	}
	
	function perName($perID){
		host();
		$query="
			select	*
			from	permission
			where	perID='$perID'
		";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		return $row[perName];
	}
	
	function noCache(){
		header("Cache-Control: no-cache, must-revalidate");
	}
	
	function headerEncode(){
		header('Content-Type: text/html; charset=utf-8');
	}
	
	function permission($menu_id,$ofID){
		host();
		
		$query="
			select	*
			from	officer
			where	OfID='$ofID'
		";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		$perID=$row[perID];
		
		$query="
			select	*
			from	menu_permission
			where	menu_id='$menu_id' and
					perID='$perID'
		";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		
		if(mysql_num_rows($result)>0){
			$permission[access]=true;
			
			if($row[ins]=='1'){
				$permission[ins]=true;
			}else{
				$permission[ins]=false;
			}
			
			if($row[upd]=='1'){
				$permission[upd]=true;
			}else{
				$permission[upd]=false;
			}
			
			if($row[del]=='1'){
				$permission[del]=true;
			}else{
				$permission[del]=false;
			}
			
			if($row[prt]=='1'){
				$permission[prt]=true;
			}else{
				$permission[prt]=false;
			}
		}else{
			$permission[access]=false;
		}
		
		return $permission;
	}
function monName($monNum){  //Return month name in Thai
		$monName=array("1"=>"มกราคม","2"=>"กุมภาพันธ์","3"=>"มีนาคม","4"=>"เมษายน","5"=>"พฤษภาคม","6"=>"มิถุนายน","7"=>"กรกฎาคม","8"=>"สิงหาคม","9"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
		$monNum++;
		$monNum--;
		return $monName[$monNum];
	}
	
	function dayNum($yearNum,$monNum,$dayNum){
		$today=getdate(mktime(00,00,00,$monNum,$dayNum,$yearNum)); //mktime(hr,mm,ss,mon,day,year);
		return $today[wday];
	}
	
	function maxDate($yearNum,$monNum){
		if($monNum=='02'){
			$firstString=substr($yearNum,2,1);
			$secondString=substr($yearNum,3,1);
			if(($firstString=='0') or ($firstString=='2') or ($firstString=='4') or ($firstString=='6') or ($firstString=='8')){
				if(($secondString=='0') or ($secondString=='4') or ($secondString=='8')){
					$maxDate=29;
				}else{
					$maxDate=28;
				}
			}else{
				if(($secondString=='2') or ($secondString=='6')){
					$maxDate=29;
				}else{
					$maxDate=28;
				}
			}
		}else{
			if(($monNum=='04') or ($monNum=='06') or ($monNum=='09') or ($monNum=='11')){
				$maxDate=30;
			}else{
				$maxDate=31;
			}
		}
		return $maxDate;
	}
	
	function numConvert($numInput,$sizeNowCodeTempNum){
		$numInput++;
		$numInput--;
		for($iNumConvert=strlen($numInput);$iNumConvert<=$sizeNowCodeTempNum-1;$iNumConvert++){
			$numInput="0$numInput";
		}
		$numOutput=$numInput;
		return $numInput;
	}
	
	function dayNameThai($dayNameEng){
		if($dayNameEng=="Sunday" || $dayNameEng==0){
			return "อาทิตย์";
		}		
		if($dayNameEng=="Monday" || $dayNameEng==1){
			return "จันทร์";
		}
		if($dayNameEng=="Tuesday" || $dayNameEng==2){
			return "อังคาร";
		}
		if($dayNameEng=="Wednesday" || $dayNameEng==3){
			return "พุธ";
		}
		if($dayNameEng=="Thursday" || $dayNameEng==4){
			return "พฤหัสบดี";
		}
		if($dayNameEng=="Friday" || $dayNameEng==5){
			return "ศุกร์";
		}
		if($dayNameEng=="Saturday" || $dayNameEng==6){
			return "เสาร์";
		}
	}
	function dayNameThaSet(){
		global $dayNameThas;
		for($i=0;$i<=6;$i++){
			$dayNameThas[$i]=dayNameThai($i);
		}
	}