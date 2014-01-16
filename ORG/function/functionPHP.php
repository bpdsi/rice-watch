<?php
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
	
	function noCache(){  //Disable caching on client computer
		header("Cache-Control: no-cache, must-revalidate");
	}
	
	function headerEncode(){  //Set character code to TIS620 (by php header)
		header("Content-Type: text/plain; charset=UTF-8");
	}
	
	function metaEncode(){  //Set character code to TIS620 (by meta of HTML)
		?> <meta http-equiv="content-type" content="text/html; charset=utf-8" /> <?
	}
	
	function get_cfgValue($cfgName){
		host("npr");
		$query="
			select	cfgValue
			from	crop_calendar.config
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
	
	function dateEncodeEN($date){
		$temp=explode(" ", $date);
		$date=$temp[0];
		$time=$temp[1];
		
		$temp=explode("-", $date);
		$yearNum=$temp[0];
		$monNum=$temp[1];
		$dayNum=$temp[2];

		return $dayNum." ".monNameENG($monNum)." ".$yearNum." ".$time;
	}
	
	function dateEncodeTH($date){
		$temp=explode(" ", $date);
		$date=$temp[0];
		$time=$temp[1];
		
		$temp=explode("-", $date);
		$yearNum=$temp[0];
		$monNum=$temp[1];
		$dayNum=$temp[2];
		$dayNum=intval($dayNum);

		return $dayNum." ".monNameTH($monNum)." ".($yearNum+543)." ".$time;
	}
	
	function dateEncodeCrop($date){
		$temp=explode(" ", $date);
		$date=$temp[0];
		$time=$temp[1];
		
		$temp=explode("-", $date);
		$yearNum=$temp[0];
		$monNum=$temp[1];
		$dayNum=$temp[2];
		$dayNum=intval($dayNum);

		return $dayNum." ".monNameTH($monNum)." ";
	}
	
	function monNameTHFull($monNum){  //Return month name in Thai
		$monName=array("1"=>"มกราคม","2"=>"กุมภาพันธ์","3"=>"มีนาคม","4"=>"เมษายน","5"=>"พฤษภาคม","6"=>"มิถุนายน","7"=>"กรกฎาคม","8"=>"สิงหาคม","9"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
		$monNum++;
		$monNum--;
		return $monName[$monNum];
	}
	
	function monNameTH($monNum){  //Return month name in Thai
		$monName=array("1"=>"ม.ค.","2"=>"ก.พ.","3"=>"มี.ค.","4"=>"เม.ย.","5"=>"พ.ค.","6"=>"มิ.ย.","7"=>"ก.ค.","8"=>"ส.ค.","9"=>"ก.ย.","10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");
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
	
	function rice_crop(){
		host();
		$query="
			select	*
			from	crop_calendar.rice_crop
		";
		$result=mysql_query($query);
		$numrows=mysql_num_rows($result);
		$i=0;
		while($i<$numrows){
			$row=mysql_fetch_array($result);
			$temp[rcID]=$row[rcID];
			$temp[rcName]=$row[rcName];
			$i++;
		}
		return $temp;
	}
	
	function rice_planting_method(){
		host();
		$query="
			select	*
			from	crop_calendar.rice_planting_method
		";
		$result=mysql_query($query);
		$numrows=mysql_num_rows($result);
		$i=0;
		while($i<$numrows){
			$row=mysql_fetch_array($result);
			$temp[rpmID]=$row[rpmID];
			$temp[rpmName]=$row[rpmName];
			$i++;
		}
		return $temp;
	}
	
	function rice_planting_season(){
		host();
		$query="
			select	*
			from	crop_calendar.rice_planting_season
		";
		$result=mysql_query($query);
		$numrows=mysql_num_rows($result);
		$i=0;
		while($i<$numrows){
			$row=mysql_fetch_array($result);
			$temp[rpsID]=$row[rpsID];
			$temp[rpsName]=$row[rpsName];
			$i++;
		}
		return $temp;
	}