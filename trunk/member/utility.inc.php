<?php
function get_style(){
return '

<style type="text/css">
		<!--
		BODY {font-family:;font-size="10"}
		A:link {text-decoration: none; color: blue }
		A:visited {text-decoration: none; color: blue }
		A:hover {text-decoration: none; color: darkorange }
		A:active {text-decoration: none; color: blue }
		p, div, td, ul li, ol li { font-family:  MS Sans Serif, Microsoft Sans Serif;  font-size: 10pt }
		-->
		</style>';
}

function gotourl_script(){
return '
<SCRIPT LANGUAGE="JavaScript">
   function gotoURL(form)  {
		box = document.forms[0].office;
		destination = box.options[box.selectedIndex].value;
		if (destination) location.href = destination;}
   </SCRIPT>'; 
}

function get_script(){
return '
<!-- Start Script Calendar -->
<script language="JavaScript" SRC="calendar/CalendarPopup.js"></script>
<script language="JavaScript">document.write(getCalendarStyles());</script>

<!-- Script Calendar -->

<script language="JavaScript">
<!--
	function ConfirmChoice() {
		answer = confirm("Do you really want to DELETE?")
		if(answer == 1) {return  true }else{ return false; }
	}
	function setList(f){
		f.submit();
	}

//-->

</script>';
}


function genhtml_header($title,$scriptstr,$body){
return('
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="tis-620">
<style type="text/css">
		<!--
		BODY {font-family:;font-size="10"}
		A:link {text-decoration: none; color: blue }
		A:visited {text-decoration: none; color: blue }
		A:hover {text-decoration: none; color: darkorange }
		A:active {text-decoration: none; color: blue }
		p, div, td, ul li, ol li { font-family:  MS Sans Serif, Microsoft Sans Serif;  font-size: 10pt }
		-->
		</style>
		'.$scriptstr.'
</head>
<title>'.$title.'</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=TIS-620\">

<script language="javascript" src="js/message.js"></script>
<script language="javascript" src="js/clsUtility.js"></script>
<script language="javascript" src="js/clseditmask.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
	function ConfirmChoice() {
		answer = confirm("Do you really want to DELETE?")
		if(answer == 1) {return  true }else{ return false; }
	}

//-->

</script>
</head>
<body'. $body.'>
');

}


function genhtml_footer(){
	return "</body>\n
		</html>\n";
}

function connect_db($host,$user,$password,$dbname){
	$dblink = mysql_connect($host,$user,$password) or
	die("Can not connect to database server");
	
	mysql_select_db($dbname) or die("Can not select database");
  	
$charset = "SET character_set_results=utf8"; 
mysql_query($charset) or die('Invalid query2: ' . mysql_error());
        $charset = "SET character_set_client=utf8"; 
mysql_query($charset) or die('Invalid query2: ' . mysql_error());
        //$charset = "SET character_set_results=tis620"; mysql_query($charset) or die('Invalid query: ' . mysql_error());
$charset = "SET character_set_connection=utf8"; mysql_query($charset)or die('Invalid query: ' . mysql_error());

	return $dblink;
}

function closedb($dblink){
	mysql_close($dblink);
}

function genselect($ptab,$pfield,$plink,$txtid){
	$sql = "SELECT * FROM $ptab";
	$result = mysql_query($sql,$plink) or die("Can not get data form $sql ");
	$numrow = mysql_num_rows($result);
	if($numrow > 0){
		$ret_str = "<select name=txt".$txtid." %disabled%>\n
					<option value=''>เลือก </option>\n";
		while($row = mysql_fetch_row($result)){
			$ret_str .= "<option value=$row[0]>$row[1]</option>\n";
		}
		$ret_str .= "</select>\n"; 
	}
	return $ret_str;	
}

function gen_dropdown($psql,$p_link,$p_sltname,$p_selectvalue,$p_event,$disabled){
	$p_data = mysql_query($psql,$p_link) or die("Can not get selection $psql <BR>");;
	$num=mysql_numrows($p_data);
	$i=0;
   	$returnstr = "<select name=\"$p_sltname\" $disabled $p_event> \n";
    $returnstr .= "\t<option value=''></option>\n";
	while ($i < $num) {
		$rowdata = mysql_fetch_row($p_data);
		$optvalue=$rowdata[0];
		$optdesc = $rowdata[1];
	   	if($optvalue==$p_selectvalue){
	   		$selectvalue = "selected";
		}else{
			$selectvalue = "";
		}
		if($selectvalue<>""){
   			$returnstr .= "\t<option value=$optvalue $selectvalue>$optdesc</option>\n";
		}else{
   			$returnstr .= "\t<option value='$optvalue'>$optdesc</option>\n";
		}
   		++$i;
	}
	//mysql_free_result($rowdata);
    $returnstr .= "</select>\n";
    return $returnstr;
}
function showpage($page,$pagelen,$dataresult,$link,$parm){
	$num_rows = mysql_num_rows($dataresult);
	$rt = $num_rows%$pagelen;
	if($rt!=0) {
		$totalpage = floor($num_rows/$pagelen)+1;
	}else {
		$totalpage = floor($num_rows/$pagelen);
	}

	$pagestr =  "<b>หน้าที่: </b>$page/$totalpage <b> ไปหน้าที่ :</b> ";
	For ($i=1 ; $i<=$totalpage ; $i++) {
		if ($i == $page ) {
			$pagestr .= " [<b><font size =+1 color=#990000>$i</font></b>] ";
		} else  {
			$pagestr .= " <a href=$link?page=$i&cmdsubmit=search&$parm>$i</a> ";
		}
	}
	return $pagestr;
}

function getdetail($query){
  $myresult = mysql_query($query) or die("Query failed $query");
  $returnstr = "";
  while($rowdata = mysql_fetch_row($myresult)) {
       $returnstr = $rowdata[0];
  }
  mysql_free_result($myresult);
  return $returnstr;
}

function getresearchname($researchid){
	$query="SELECT researchid, researchname
			FROM t_research
			WHERE researchid ='$researchid'";
	$myresult = mysql_query($query) or die("Query Fail");
	$rowdata = mysql_fetch_row($myresult);
	mysql_free_result($myresult);
	return $rowdata[1];
	}

function thaidate($parmdate){
  $thmonthname[1] = "ม.ค.";
  $thmonthname[2] = "ก.พ.";
  $thmonthname[3] = "มี.ค.";
  $thmonthname[4] = "เม.ย.";
  $thmonthname[5] = "พ.ค.";
  $thmonthname[6] = "มิ.ย.";
  $thmonthname[7] = "ก.ค.";
  $thmonthname[8] = "ส.ค.";
  $thmonthname[9] = "ก.ย.";
  $thmonthname[10] = "ต.ค.";
  $thmonthname[11] = "พ.ย.";
  $thmonthname[12] = "ธ.ค.";
	$parmdate = substr($parmdate,0,10);
		list( $cThaiYear , $cMonth , $cDay ) = split( '-' , $parmdate ,3) ;
		$monthname = $thmonthname[intval($cMonth)];
		return $cDay." ".$monthname." ". ($cThaiYear+543) ;
}


function setstyle(){
	return("
<style type='text/css'>
<!--
thead {  margin: 0px  0px; padding: 0px  0px;  font-family: Tahoma, Verdana, Arial;  font-size: 13px; font-weight :bold;color: #ffffff;background-color: #b0c4de; text-decoration: none}
tbody {  margin: 0px  0px; padding: 0px  0px;  font-family: Tahoma, Verdana, Arial;  font-size: 13px; color: #000077;background-color: #F0F6FA; text-decoration: none}

body {  margin: 0px  0px; padding: 0px  0px;  font-family: Tahoma, Verdana, Arial;  font-size: 11px; color: #000000; text-decoration: none}
a:link {  font-family: Tahoma, Verdana, Arial;  font-size: 13px; color: #393939; text-decoration: none}
a:visited { font-family: Tahoma, Verdana, Arial;  font-size: 13px; ; color: #393939; text-decoration: none}
a:active {  font-family: Tahoma, Verdana, Arial;  font-size: 13px;  color: #005CA2; text-decoration: none}
a:hover {  font-family: Tahoma, Verdana, Arial;  font-size: 13px;  color: #EE5CA2; text-decoration: none}

.Bold
        			{
        				font-family :Tahoma, Verdana, Arial;
        				font-size :11px;
        				color :#393939;
        				font-weight :bold;
        				text-decoration: none;
        			}
.Normal
        			{
        				font-family :Tahoma, Verdana, Arial;
        				font-size :11px;
        				color :#393939;
        				font-weight :normal;
        				text-decoration: none;
        			}
-->
</style>
<style type=\"text/css\"><!--
.TextField {
background-color: ffffff;
border-color: cccccc;
border-style: Solid;
border-width: 1;
color: 393939;
font-size: 11;
font-family: Tahoma, Verdana, Arial;
font-weight: normal;
}
.Botton {
background-color: F2EEEE;
border-color: cccccc;
border-style: Solid;
border-width: 1;
color: 393939;
font-size: 11;
font-family: Tahoma, Verdana, Arial;
font-weight: normal;
}

--></style>");

}
function get_field($eqid,$link,$porderno){	
	$sql = "SELECT eqid,fid,fname ,fmeasure,relate_table,link_field,ftype,fsize,objtype
			FROM tbl_fields 
			WHERE eqid = '$eqid'  order by fid	" ;
//	echo("sql = $sql <BR>");
	$result = mysql_query($sql,$link) or die("can not query data");
	$num=mysql_numrows($result);
	if($num > 0){	
		$i=0;
		$dsp_str .= "
<table border=0 width=800 align=center>
	<tr>
		<td></td>
		<td></td>
		<td></td>
	</tr> ";	
		while($row=mysql_fetch_row($result)){
			$i++;
			$porderno++;
			$txtname = $row[0]."_".$row[1];
			if($row[7] <>""){
				$txtsize = "size = '" .($row[6] + 10)."'";
				$txtmaxsize = "maxsize = '". $row[6]."'";
			}else{
				$txtsize = " size = 80 ";
			}
			switch($row[8]){
				case "text":
					$obj = "<input type=text name=txt_".$txtname." ". $txtsize. $txtmaxsize." %disabled% value='%txt_".$txtname."%'>";
					break;
				case "textarea":
					$obj = '<textarea name=txt_'.$txtname.' cols="80" rows="5" %disabled%>%txt_'.$txtname.'%</textarea>';					
					break;
				case "select":
					$obj = "<input type=text name=txt_".$txtname." size=40 0 %disabled% value='%txt_".$txtname."%'>
							<INPUT type=button name=cmd".$txtname." value='...' onclick=browse()>";				
					break;
				default:
					$obj = "<input type=text name=txt_".$txtname. " ". $txtsize. $txtmaxsize." %disabled% value='%txt_".$txtname."%'>";
					break;
			}
			$dsp_str .= "
		<td valign=top align=right><b>$row[2]</b></td>
		<td valign=top>&nbsp;</td>
		<td valign=top>$obj</td>
	</tr> ";			
		}//========= while ========
	$dsp_str .= "
</table>
<input type=hidden name=nooffield".$eqid." value='".$i."'>	";
	}//---------------- if ----------------
	$dsp_str .= "###$$$".$porderno;
//	echo("porder = $porderno <BR>");
	return $dsp_str;
}

function get_child($parentid,$flink,$porderno){
	$sql = "SELECT eqid,eqname,parent_eqid,eqdesc,multiple,haschild 
			FROM tbl_eq 
			WHERE parent_eqid = '$parentid' 
			ORDER BY eqid	" ;	
//	echo("sql = $sql <BR>");
	$result = mysql_query($sql,$flink) or die("Can not get child data");
	$num=mysql_numrows($result);
	if($num > 0){
		$orderno = $porderno;	
		$i=0;
		while($row=mysql_fetch_array($result)){
//			$orderno++;
			$eqid = $row["eqid"];
			$ret_str .= "
<table border=0 width=100% align=center>
	<tr bgcolor='#ffcc00'>
		<td><b>".$row['eqname']."</b></td>
	</tr>
</table>";
	$raw_dsp_str = get_field($eqid,$flink,$orderno);
	$raw_dsp_str_arr = explode("###$$$",$raw_dsp_str);
	$ret_str .= $raw_dsp_str_arr[0];
	$orderno = $raw_dsp_str_arr[1];
//xxxxxxxxxxxxxxxxxxxxxxx				
			if($row["haschild"] !=0){
				$ret_str.=get_child($eqid,$flink,$orderno);
			}
		} // ---- while ----------
	}//------ if ------------
	return $ret_str."###$$$".$orderno;
}

function return_child_name($parentid,$flink){
	$sql = "SELECT eqid,eqname,parent_eqid,eqdesc,multiple,haschild 
			FROM tbl_eq 
			WHERE parent_eqid = '$parentid' 
			ORDER BY eqid	" ;
	$result = mysql_query($sql,$flink) or die("Can not get child data");
	$num=mysql_numrows($result);
	if($num > 0){
		while($row=mysql_fetch_array($result)){
			$eqid = $row["eqid"];
			$pstr .= ",".return_field_name($eqid,$flink);
			if($row["haschild"] !=0){
				$pstr=return_child_name($eqid,$flink);
			}
		} // ---- while ----------
	}//------ if ------------
//		echo($pstr);
	return $pstr;
}
function return_field_name($eqid,$link){	
	$sql = "SELECT eqid,fid,fname ,fmeasure,relate_table,link_field,ftype,fsize,objtype
			FROM tbl_fields 
			WHERE eqid = '$eqid'  order by fid	" ;
	$result = mysql_query($sql,$link) or die("can not query data");
	$num=mysql_numrows($result);
	if($num > 0){	
		while($row=mysql_fetch_row($result)){
			$txtname = "txt_".$row[0]."_".$row[1]."";
			$return_str .= ",".$txtname ;
//			echo("txtname = $txtname <BR> value  = ".$$txtname ."<BR>");
		}//========= while ========
	}
//		echo($dsp_str);
	return $return_str;
}

function xdates_interconv($date_format1, $date_format2, $date_str)  {

      $base_struc     = split('[:/.\ \-]', $date_format1);
      $date_str_parts = split('[:/.\ \-]', $date_str );
    
      // print_r( $base_struc ); echo "\n"; // for testing
      // print_r( $date_str_parts ); echo "\n"; // for testing
    
      $date_elements = array();
    
      $p_keys = array_keys( $base_struc );
      foreach ( $p_keys as $p_key )
      {
          if ( !empty( $date_str_parts[$p_key] ))
          {
              $date_elements[$base_struc[$p_key]] = $date_str_parts[$p_key];
          }
          else
              return false;
      }
    
      // print_r($date_elements); // for testing
     
      if (array_key_exists('M', $date_elements)) {
        $Mtom=array(
          "Jan"=>"01",
          "Feb"=>"02",
          "Mar"=>"03",
          "Apr"=>"04",
          "May"=>"05",
          "Jun"=>"06",
          "Jul"=>"07",
          "Aug"=>"08",
          "Sep"=>"09",
          "Oct"=>"10",
          "Nov"=>"11",
          "Dec"=>"12",
        );
        $date_elements['m']=$Mtom[$date_elements['M']];
      }
     
      // print_r($date_elements); // for testing
    
      $dummy_ts = mktime(
        $date_elements['H'],
        $date_elements['i'],
        $date_elements['s'],
        $date_elements['m'],
        $date_elements['d'],
        $date_elements['Y']
      );
    
      return date( $date_format2, $dummy_ts );
  }

//  It returns an array of the valid dates between two parameter dates.  enjoy.


function DatesBetween($startDate, $endDate){
    // get the number of days between the two given dates.
    $days = (strtotime($endDate) - strtotime($startDate)) / 86400 + 1;
    $startMonth = date("m", strtotime($startDate));
    $startDay = date("d", strtotime($startDate));
    $startYear = date("Y", strtotime($startDate));   
    $dates;//the array of dates to be passed back
    for($i=0; $i<$days; $i++){
        $dates[$i] = date("n/j/Y", mktime(0, 0, 0, $startMonth , ($startDay+$i), $startYear));
    }
    return $dates;   
}

function date_diff($d1, $d2){
    $d1 = (is_string($d1) ? strtotime($d1) : $d1);
    $d2 = (is_string($d2) ? strtotime($d2) : $d2);

    $diff_secs = abs($d1 - $d2);
    $base_year = min(date("Y", $d1), date("Y", $d2));

    $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
    return array(
        "years" => date("Y", $diff) - $base_year,
        "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
        "months" => date("n", $diff) - 1,
        "days_total" => floor($diff_secs / (3600 * 24)),
        "days" => date("j", $diff) - 1,
        "hours_total" => floor($diff_secs / 3600),
        "hours" => date("G", $diff),
        "minutes_total" => floor($diff_secs / 60),
        "minutes" => (int) date("i", $diff),
        "seconds_total" => $diff_secs,
        "seconds" => (int) date("s", $diff)
    );
}
//Here is my function to count the number days, weeks, months, and year. I tried it below 1970 and it works.


function ConDateFormat($pdate,$pformat){
	if($pdate =="00-00-0000") $pdate = "";
	if($pdate =="0000-00-00") $pdate = "";

	if($pdate == ""){
		$returndate = "";
	}else{
		if($pformat == "1"){ //=== input  => 2007/12/01  to 01/12/2550
			$returndate =(substr($pdate,8,2))."/".substr($pdate,5,2)."/".(substr($pdate,0,4)+543);
		}
		if($pformat == "0"){ //=== input => 02/12/2550 to 2007/12/02
			$returndate = (substr($pdate,6,4)-543)."/".substr($pdate,3,2)."/".substr($pdate,0,2);
		}
	}	
	return $returndate;
}

function datecal($date,$return_value)
{
$date = explode("/", $date);
$month_begin = $date[0];
$month_begin_date = $date[1];
$year1 = $date[2];
$month_end = date("n");
$month_end_date = date("j");
$year2 = date("Y");
$days_old = 0;
$years_old = 0;
$months_old = 0;
if($month_begin==12)
{
  $month = 1;
  $year = $year1+1;
}
else
{
  $month = $month_begin+1;
  $year = $year1;
}
$begin_plus_days = cal_days_in_month(CAL_GREGORIAN, $month_begin, $year1) - $month_begin_date;
$end_minus_days = cal_days_in_month(CAL_GREGORIAN, $month_end, $year2) - $month_end_date;
while ($year <= $year2) 
{    
     if($year == $year2)
    {
      $days_old = $days_old + cal_days_in_month(CAL_GREGORIAN, $month, $year);     
      if($month < $month_end)
        { 
         $months_old = $months_old + 1;    
         $month = $month + 1;
        }
          elseif ($month==$month_end and $month_end_date >= $month_begin_date)
            { 
         $year = $year2+1;    
        }
      else
        {    
         $year = $year2+1;    
        }
    }
    else
    {
     $days_old = $days_old + cal_days_in_month(CAL_GREGORIAN, $month, $year);
         if ($month <= 11) 
            {
         $month = $month + 1;
         $months_old = $months_old + 1;    
            }
         else
            {
         $month = 1; 
         $year = $year + 1;
         $months_old = $months_old + 1;        
            }     
    }
}
$days_old = ($days_old + $begin_plus_days) - $end_minus_days;
if($return_value == "d")
  { return $days_old; }
elseif ($return_value == "w")
  { return intval($days_old/7); }
elseif ($return_value == "m")
  { return $months_old; }
elseif ($return_value == "y")
  { return intval($months_old/12); }
}

//echo datecal("08/13/1975","m");


/* Converts a date and time string from one format to another (e.g. d/m/Y => Y-m-d, d.m.Y => Y/d/m, ...)
   *
   * @param string $date_format1
   * @param string $date_format2
   * @param string $date_str
   * @return string
  */
  function dates_interconv($date_format1, $date_format2, $date_str)
  {

      $base_struc     = split('[:/.\ \-]', $date_format1);
      $date_str_parts = split('[:/.\ \-]', $date_str );
     
      // print_r( $base_struc ); echo "\n"; // for testing
      // print_r( $date_str_parts ); echo "\n"; // for testing
     
      $date_elements = array();
     
      $p_keys = array_keys( $base_struc );
      foreach ( $p_keys as $p_key )
      {
          if ( !empty( $date_str_parts[$p_key] ))
          {
              $date_elements[$base_struc[$p_key]] = $date_str_parts[$p_key];
          }
          else
              return false;
      }
     
      // print_r($date_elements); // for testing
      
      if (array_key_exists('M', $date_elements)) {
        $Mtom=array(
          "Jan"=>"01",
          "Feb"=>"02",
          "Mar"=>"03",
          "Apr"=>"04",
          "May"=>"05",
          "Jun"=>"06",
          "Jul"=>"07",
          "Aug"=>"08",
          "Sep"=>"09",
          "Oct"=>"10",
          "Nov"=>"11",
          "Dec"=>"12",
        );
        $date_elements['m']=$Mtom[$date_elements['M']];
      }
      
      // print_r($date_elements); // for testing
     
      $dummy_ts = mktime(
        $date_elements['H'], 
        $date_elements['i'], 
        $date_elements['s'], 
        $date_elements['m'],
        $date_elements['d'],
        $date_elements['Y']
      );
     
      return date( $date_format2, $dummy_ts );
  }

function dayofweek() {
	$days = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
	return array_search(date("D"), $days) + 1;
}

function getmonthname($monthno){
	$monthname['01'] = "ม.ค.";
	$monthname['02'] = "ก.พ.";
	$monthname['03'] = "มี.ค.";
	$monthname['04'] = "เม.ย.";
	$monthname['05'] = "พ.ค.";
	$monthname['06'] = "มิ.ย.";
	$monthname['07'] = "ก.ค.";
	$monthname['08'] = "ส.ค.";
	$monthname['09'] = "ก.ย.";
	$monthname['10'] = "ต.ค.";
	$monthname['11'] = "พ.ย.";
	$monthname['12'] = "ธ.ค.";
	return $monthname[$monthno];
}


function getdayname($pengdayname){
	$dayname['Saturday'] = 'ส.';
	$dayname['Sunday'] = 'อา.';
	$dayname['Monday'] = 'จ.';
	$dayname['Tuesday'] = 'อ.';
	$dayname['Wednesday'] = 'พ.';
	$dayname['Thursday'] = 'พฤ.';
	$dayname['Friday'] = 'ศ.';
	return $dayname[$pengdayname];
}
?>
