<?session_start();
	$userid = $_GET['userid'];
//	echo "userid:=".$userid;
	if($userid =="") $userid = $_POST['userid'];
    if($firstname =="") $firstname = $_GET['firstname'];
    if($lastname =="") $lastname = $_GET['lastname'];
//	echo "userid:=".$userid;
    $uname="admin";  // for check
		 
	if($userid == "") 	$userid = $_SESSION['userid'];	
//	echo "userid:=".$userid;
include "conf/config.inc.php";
include "utility.inc.php";
$link = connect_db($host,$user,$password,$dbname);
    
$cmdaction = $_GET['cmdaction'];
$dbaction = $_GET['dbaction'];
$dspstatus = $_GET['dspstatus'];
if($dbaction =="") $dbaction = "ADD";

if($cmdaction =="เพิ่ม"){
		$dbaction = "ADD";
		$uname="";		$title = "";				$userfn="";				$userln="";				
		$address="";		$provinceid="";		$amphurid="";		$tambulid="";		
		$txtsoil="";			$email="";
		$moblie="";		$typeplant="";		$firsttime="";			$username="";
		$cardid="";	 		$group = "";		$plang = "";			$rawang = "";		$npk = "";
		$savedisabled = "" ;			$undodisabled = "" ;
		$adddisabled = "disabled";			//$deldisabled = "disabled";
}else{
//"utf-8","tis-620"
	$title = $_GET['title'];	 //echo("title = $title ");
	$userfn=$_GET['userfn'];				$userln=$_GET['userln'];
	$address=$_GET['address'];			$provinceid=$_GET['provinceid'];
	$amphurid=$_GET['amphurid'];     $tambulid=$_GET['tambulid'];
	$txtsoil=$_GET['txtsoil'];				$email=$_GET['email'];
	$moblie=$_GET['moblie'];			$typeplant=$_GET['typeplant'];
	$firsttime=$_GET['firsttime'];		$username=$_GET['username'];
	$passwords=$_GET['passwords'];    $txtconfirmpass=$_GET['txtconfirmpass'];
	$cardid=$_GET['cardid'];				$npk = $_GET['npk'];
	$group = $_GET['group'];			$plang = $_GET['plang'];		$rawang = $_GET['rawang'];
}
if($cmdaction == "บันทึก")
{
$sqlsoil="SELECT province_Index FROM tprovince,t_province_new 
			WHERE Changwat  = province_name and province_id='$provinceid'";
			$r=mysql_query($sqlsoil) or die("error<br>".$sqlsoil);  
			$rowtprovince=mysql_fetch_array($r);
			//echo $sqlsoil;
	if($dbaction =="ADD"){
		if($errormsg ==""){
			$sqlm="select max(userid)as maxid from t_user";
			$r=mysql_query($sqlm) or die("error<br>".$sqlm);
			$row=mysql_fetch_array($r);
			$userid=$row[0] + 1;

			$sql="insert into t_user (title,userid,userfn, userln, address, provinceid, amphurid, tambulid, soilid, email, moblie,typeplant,username,password,Province_Index,cardid,ugroup,plang,rawang,npk) 
			values('$title','$userid','$userfn','$userln','$address',
			'$provinceid','$amphurid','$tambulid','$txtsoil','$email','$moblie','$typeplant','$username','$passwords','$rowtprovince[0]','$cardid'
			,'$group','$plang','$rawang','$npk')";
			mysql_query($sql) or die("error<br>".$sql);

			$sqls="insert into t_typeofplant (userid,typeplant,firsttime,subtypetypeplant) values('$userid','$typeplant','$firsttime','1')";
			mysql_query($sqls) or die("error<br>".$sqls);
	//	echo("sql = $sql <BR> sqls= $sqls <BR>");
			$msgtext2="Welcome to �Թ�յ�͹�Ѻ 123 ";
			$msgtext2=str_replace(" ","%20",$msgtext2);
			$cmd = "./http_request.py ".$moblie." ".$msgtext2;//	`$cmd`;
			echo "เพิ่มข้อมูลเรียบร้อย";
			$savedisabled = "disabled" ;			$undodisabled = "disabled" ;
		}
	}

	if($dbaction =="EDIT"){
		$sql = "update t_user set title = '$title',userfn='$userfn', userln='$userln', address='$address', provinceid='$provinceid', 	
				Province_Index='$rowtprovince[0]',amphurid='$amphurid'
				, tambulid='$tambulid', soilid='$txtsoil', email='$email', moblie='$moblie',typeplant='$typeplant' ,username='$username', 
				cardid='$cardid',ugroup = '$group',plang='$plang',rawang='$rawang',npk = '".$npk."'" ;
		if($pass <> "") $sql .= ",password='$passwords'";
		$sql .= " WHERE userid = '$userid'";
		//echo("sql = $sql <BR>");
		$result = mysql_query($sql) or die("Can not update data <BR>$sql ");
		 
		 $sqls="UPDATE t_typeofplant 
					SET  typeplant = '$typeplant',firsttime ='$firsttime'
					WHERE userid = '$userid'";
         mysql_query($sqls) or die("error<br>".$sqls);
		//echo("sql s = $sqls <BR>");
		echo "<center><b>แก้ไขข้อมูลเรียบร้อย</b></center>";
		$savedisabled = "disabled" ;		$undodisabled = "disabled" ;
	}
} // if($cmdaction == "บันทึก")

if($cmdaction == "ลบ"){
		$sql = "DELETE FROM t_user WHERE userid = '$userid'";
//		echo("sql = $sql <BR>");
		$result = mysql_query($sql) or die("Can not delete data $sql ");
		$adddisabled = "disabled";		//	$deldisabled = "disabled";
}
if($dspstatus=="displaydata"){
	$dbaction = "EDIT";
	$hiddenstring = "<INPUT TYPE=hidden name=userid value=".$userid.">";
    if($lastname!="" and $firstname!=""){
        if($firstname!="") $where =" and userfn like '%".$firstname."%'";
        if($lastname!="") $where .=" and userln like '%".$lastname."%'";
	$sql = "SELECT userid,title,userfn, userln, address, provinceid, amphurid, tambulid, soilid, email, moblie,typeplant,username,cardid,ugroup,plang,rawang,npk  
		FROM t_user WHERE userid <>'' ".$where; 
    }elseif($userid!=""){
        $sql = "SELECT userid,title,userfn, userln, address, provinceid, amphurid, tambulid, soilid, email, moblie,typeplant,username,cardid,ugroup,plang,rawang,npk  
		FROM t_user WHERE userid = '$userid'"; 
        }
        //echo $sql;
     if($sql=="") {
       // echo " <a href='./staff.php'>�������� �ա����</a>"   ;
     }
     if($sql!=""){
        $result = mysql_query($sql) or die("Can not get data $sql ") ;
        $noofrec = mysql_num_rows($result);
    }
	if($noofrec >0){
		$data = mysql_fetch_array($result);
		$title = $data['title']; $userid=$data['userid'];
		$userfn=$data['userfn'];					$userln=$data['userln'];                $address=$data['address'];
		$provinceid=$data['provinceid'];			$amphurid=$data['amphurid'];		$tambulid=$data['tambulid'];
		$txtsoil=$data['soilid'];	                $email=$data['email'];	                $moblie=$data['moblie'];
		$typeplant=$data['typeplant'];			$firsttime=$data['firsttime'];          $username=$data['username'];         $cardid=$data['cardid']; 
		$group = $data['ugroup'];					$plang = $data['plang'];			$rawang = $data['rawang'];	$npk=$data['npk'];
	}
	$sql = "SELECT userid,typeplant,firsttime,subtypetypeplant FROM t_typeofplant WHERE userid = '$userid'";
	$result = mysql_query($sql) or die("Can not get data <BR> $sql ");
	$noofrec = mysql_num_rows($result);
	if($noofrec >0){
		$data = mysql_fetch_array($result);
		$typeplant = $data['typeplant'];			$firsttime = $data['firsttime'];
	}
//	echo("firsttime = $firsttime <BR> typeofplang = $typeplant <BR>");
	$adddisabled = "disabled";		//	$deldisabled = "disabled";
} // if($dspstatus=="displaydata")
//=====================================

if($uname == "admin"){ // list all user
	$sql = "SELECT userid,concat(userfn,' ',userln)as  usernm,username	FROM t_user  ORDER BY usernm";
}else{
	$sql = "SELECT userid,concat(userfn,' ',userln)as  usernm,username	FROM t_user WHERE username = '".$username."' ORDER BY usernm";
}
	$result = mysql_query($sql) or die("Can not get staff list name $sql ");
	while($data = mysql_fetch_array($result)){
		$stafflistname .= " &nbsp; &nbsp; <a href=staff.php?userid=".$data["userid"]."&dspstatus=displaydata>".$data[1]."</a><br>";
	}
	$sql = "";
//}
$dspstatus = $_GET['dspstatus'] ; $chkstatus = $_POST['chkstatus'];
	
$event = " onChange=\"document.register.submit()\"";
$sql = "SELECT province_id,province_name FROM t_province_new  ORDER BY province_name";
$sltprovince =gen_dropdownx($sql,"provinceid",$provinceid,$event);		

if($provinceid != ""){
	$sql = "SELECT amphurid ,amphurname FROM t_amphur   WHERE provinceid ='".$provinceid."' ORDER BY amphurname";
	$sltamphur = gen_dropdownx($sql,"amphurid",$amphurid,$event);		
}

if(($provinceid != "") and ($amphurid != "")){
		$sql = "SELECT tambolid ,tambolname FROM t_tambol  WHERE   provinceid ='".$provinceid."'  AND amphurid = '".$amphurid."'	ORDER BY tambolname";
		$slttumbol = gen_dropdownx($sql,"tambulid",$tambulid,"");
}
	
	if($provinceid !=""){
		$sql = "SELECT province_name FROM t_province_new WHERE province_id = '".$provinceid."'";
		$provincename = getdetail($sql);
		$sql = "select soilid,soilname from thsoildb";
	/*	$sql = "SELECT thsoildb.soilid, thsoildb.soilname 
					FROM  tprovince,tfercal ,thsoildb
					WHERE tprovince.province_index = tfercal.province_index AND tfercal.soil_id = thsoildb.soilid 
					AND tprovince.changwat='".$provincename."'";*/
		$sltsoil = gen_dropdownx($sql,"txtsoil",$txtsoil,"");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Staff</title>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+=' ต้องเป็น e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+=' ช่องเงินเดือน ต้องเป็นตัวเลขเท่านั้น.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+'  ต้องเป็นตัวเลข '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert(' เกิดข้อผิดพลาดขึ้น :\n'+errors);
  document.MM_returnValue = (errors == '');
}
	function Confirm() {
		answer = confirm("ยีนยันการลบข้อมูลนี้ หรือไม่?")
		if(answer == 1) {return  true }else{ return false; }
	}
function chk() {
		if(document.getElementById('firstname').value == "" || document.getElementById('lastname').value=="") {
            alert("กรุณากรอกทั้งชื่อ-นามสกุล");
            document.getElementById('firstname').value =document.getElementById('firstname').value 
            document.getElementById('lastname').value=document.getElementById('lastname').value
            return  false;
        }else{
            return true;
        }
}
//-->
</script>

<script language="JavaScript" src="js/calendar3.js"></script>
</head>


<table class='table_01'  id=\"tblElement\" style='margin-left:auto;margin-right: auto;margin-top: 5px;width:1000px'>
<tr>
<td width="300px"></td>
<td>
<table class="table_01" style="margin-left: auto;width: 600px;">
<tr>
	<td class="table_header table_topRadius" colspan="2"><h3>Search</h3></td>
</tr>
<form name="search"  method="get">
<tr>
    <td>ชื่อ :</td>
    <td><input type="text" name="firstname" value="<?=$firstname?>"></td>
</tr>
<tr>
    <td>นามสกุล :</td>
    <td><input type="text" name="lastname" value="<?=$lastname?>"></td>
</tr>
<tr>
    <td><input type="hidden" name="dspstatus" value="displaydata"><input type="submit" name="search" value="ค้นหา" onclick='return chk();'></td>
    <td><input type="reset" name="cancelx" value="ยกเลิก"></td>
</tr>
</form>
</table>
</td>
</tr>
</table>
<br>
<table class='noSpacingx table_01' style='margin-left:auto;margin-right: auto;margin-top: 5px;width: 100%;'>
<form name="register" action="" method="get">
	<input type =hidden name =id value=<?=$id?>>
	<input type =hidden name = dbaction value=<?=$dbaction?>>
	<input type=hidden name=chkstatus value="1">
	<?=$hiddenstring?>
<? if($errmsg <> ""){	echo("<b>เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้ </b><br>$errmsg	");	 }
	//$tabwidth  = "100%";
	if($stafflistname <> ""){
		$tabwidth = 700;
	//	$stafftitle = '<td align="center" bgcolor="#FFCC00">ผู้ใช้งานระบบ</td>';
		$stafftitle = 'ผู้ใช้งานระบบ';
	
	  //	$stafflistname  = "<td rowspan=15 width=200 valign=top bgcolor='#FFCC00'>$stafflistname</td>";
		$opt2 = " rowspan=15 width=200 valign=top bgcolor='#FFCC00'";
	}
?>


 <tr>
 <?if($_GET['modex']!=""){?>
		<td align="center" bgcolor="#FFCC00"><?=$stafftitle?></td>
<?}?>
		<td colspan="2"  class='table_header'> <strong>
			<?=$errmsg?>
			<font color="#FFFFFF" size="2" face="MS Sans Serif, Tahoma, sans-serif">&nbsp;&nbsp;กรุณากรอกรายละเอียดของคุณด้วยครับ&nbsp;&nbsp;</font>
			</strong>
		</td>
</tr>
 <tr valign="top">
 <?if($_GET['modex']!=""){?>
		<td <?=$opt2?> >	<?=$stafflistname?></td>  
<?}?>
		<td>
				<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#0066CC">
				  <tr bgcolor="#FFFFFF">
					<td class="form_field">คำนำหน้าชื่อ</td>
					<td><input name="title" type="text" id="userfn" size="30" maxlength="20" VALUE="<?=$title?>"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td class="form_field">ชื่อ</td>
					<td><input name="userfn" type="text" id="userfn" size="30" maxlength="20" VALUE="<?=$userfn?>"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td class="form_field">นามสกุล</td>
					<td><input name="userln" type="text" id="userln" size="30" maxlength="20" VALUE="<?=$userln?>"/></td>
				  </tr>
                  <tr bgcolor="#FFFFFF">
					<td class="form_field">เลขบัตรประจำตัวประชาชน</td>
					<td><input name="cardid" type="text" id="cardid" size="30" maxlength="13" VALUE="<?=$cardid?>"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td valign="top" class="form_field">ที่อยู่</td>
					<td><label>
					  <textarea name="address" cols="60" rows="3" id="address"><?=$address?></textarea>
					</label></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td class="form_field">จังหวัด</td>
					<td><?=$sltprovince?>   </td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td class="form_field">อำเภอ</td>
					<td><?=$sltamphur?></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td class="form_field">ตำบล</td>
					<td><?=$slttumbol?></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td class="form_field">ชุดดิน</td>
					<td><?=$sltsoil?>
					  <input type="button" name="btnsoil"  value="เลือกจากคุณสมบัติ" onclick="window.open('soilselect.php',null,
					'height=300,width=450,status=yes,toolbar=no,menubar=no,location=no');"> 
						</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td class="form_field">e-mail</td>
					<td><input name="email" type="text" id="email"  size="30" maxlength="30"  VALUE="<?=$email?>"/>		</td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td class="form_field">มือถือ</td>
					<td><input name="moblie" type="text" id="moblie" size="15" maxlength="10"  VALUE="<?=$moblie?>"/></td>
				  </tr>
				  <!-- <tr bgcolor="#FFFFFF">
					<td>พืชที่ปลูก</td>
					<td><input name="typeplant" type="text" id="typeplant" size="25" maxlength="20"  VALUE="<?=$typeplant?>"/></td>
				  </tr> -->
				  
				  <tr  bgcolor="#FFFFFF">
							<td class="form_field">พืชที่ปลูก</td>
							<td>
								<select id="typeplant" name="typeplant" >
									<?php
										$query="
											select	*
											from	crop_calendar.rice_varieties order by rvName
										";
										$result=mysql_query($query)or die(mysql_error()."<br>".$query);
										$numrows=mysql_num_rows($result);
										$i=0;
										while($i<$numrows){
											$row=mysql_fetch_array($result);
											$selected="";
											if($typeplant==$row[rvID])$selected="selected";
											?>
												<option value="<?php echo $row[rvID]?>" <?=$selected?>><?php echo $row[rvName]?></option>
											<?php
											$i++;
										}
									?>
								</select>
							</td>
						</tr>
				<tr bgcolor="#FFFFFF">
					<td valign=top class="form_field">NPK(กรอก ตัวเลข 3 ตัว)</td>
					<td><input type="text" name="npk" value="<?=$npk?>" maxlength="5"></td>
				  </tr>	
				   <tr bgcolor="#FFFFFF">
					<td class="form_field">กลุ่ม/ระวาง</td>
					<td><input name="group" type="text" id="group" size="25" maxlength="20"  VALUE="<?=$group?>"/></td>
				  </tr> 
				   <tr bgcolor="#FFFFFF">
					<td class="form_field">แปลง</td>
					<td><input name="plang" type="text" id="v" size="25" maxlength="20"  VALUE="<?=$plang?>"/></td>
				  </tr> 
				   <tr bgcolor="#FFFFFF">
					<td class="form_field">ระวาง(มาตรส่วน 1:4000)</td>
					<td><input name="userid" type="hidden" id="userid"   VALUE="<?=$userid?>"/><input name="rawang" type="text" id="rawang" size="25" maxlength="20"  VALUE="<?=$rawang?>"/></td>
				  </tr> 
				  <tr bgcolor="#FFFFFF">
					<td class="form_field">วันที่เริ่มปลูก</td>
					<td><input name="firsttime" type="text" id="firsttime" size="15"  VALUE="<?=check_time_edit($firsttime)?>" readonly/>
					<a href="javascript:cal1.popup();"><img src='images/cal.gif' border='0'></a></td>
				  </tr>
				  <!--<tr bgcolor="#FFCCFF"> 
					  <td colspan="2" bgcolor="#FFFF66"> <div align="center"> 
						  <strong><font size="2" face="MS Sans Serif, Tahoma, sans-serif">รายละเอียดในการเข้าสู่ระบบ</font></strong> 
					  </div></td>
					</tr>
					<tr> 
					  <td colspan="2" bgcolor="#FFFFFF"><table border="0" align="left" cellpadding="3" cellspacing="0">
						  <tr> 
							<td width="150"  bgcolor="#FFFFFF">ชื่อผู้ใช้</td>
							<td><input name="username" type="text" id="username" size="20" maxlength="50"  VALUE="<?=$username?>" <?=$enabled?> >
							<font color="#FF0000" size="2" face="MS Sans Serif, Tahoma, sans-serif">&nbsp;**</font>
							</td>
							<td width="10"> <div align="center"></div></td>
							<td colspan="2"> 
							  - <font size="2" face="MS Sans Serif, Tahoma, sans-serif">ข้อมูลเหล่านี้จะใช้ในการเข้าสู่ระบบนะครับ 
							  - </font></td>
					 </tr>
					 <tr> 
							<td width="150"  bgcolor="#FFFFFF">รหัสผ่าน</td>
							<td><input name="passwords" type="password" id="passwords" size="20" maxlength="50"  VALUE="<?=$passwords?>" <?=$enabled?> >
							<font color="#FF0000" size="2" face="MS Sans Serif, Tahoma, sans-serif">&nbsp;**</font>
							</td>
							<td>&nbsp;</td>
							<td><font size="2" face="MS Sans Serif, Tahoma, sans-serif">ยืนยันรหัสผ่าน</font></td>
							<td><input name="txtconfirmpass" type="password" id="txtconfirmpass" size="20" maxlength="30"> &nbsp;<font color="#FF0000" size="2" face="MS Sans Serif, Tahoma, sans-serif">**</font></td>
					</tr>-->
				  <tr bgcolor="#0066CC" >
					<td align="center" colspan=6>

				<?	if($uname == "admin"){?>
					  <input name="cmdaction" type="submit"  value="เพิ่ม" <?=$adddisabled?>>
					  <?}?>
					  <input name="cmdaction" type="submit"  value="บันทึก" <?=$savedisabled?>>
					  <?	if($uname == "admin"){?>
					 <input type='submit' name=cmdaction value='ลบ'  onclick='return Confirm();' <?=$deldisabled?>>
					 <?}?>
					  <!--<input name="cmdcancel" type="reset" id="cmdcancel" value="ยกเลิก" onclick=location.href='./search.php'>-->
					  <input name="cmdcancel" type="reset" id="cmdcancel" value="ยกเลิก" <?=$undodisabled?>>
					</td>
				  </tr>
				</table>		
		</td>
  </tr>
 </table>


</form>
<script language="JavaScript">
		var cal1 = new calendar3(document.forms['register'].elements['firsttime']);
		//var cal2 = new calendar3(document.forms['register'].elements['txtstartworkdate']);
</script>


<?
function gen_dropdownx($p_sql,$p_sltname,$p_selectvalue,$pevent){
	$p_data = mysql_query($p_sql) or die("Can not get selection $p_sql <BR>");;
	$num=mysql_numrows($p_data);
	$i=0;
   	$returnstr = "\n<select name=\"$p_sltname\" $pevent> \n";
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

function check_time_edit( $dttm ){
		if ($dttm=='0000-00-00'){
			$dttm = '';
			return $dttm;
		} else {
			//$dttm = date('d F Y', strtotime($dttm));
			return $dttm;
		}
	}

	function chkuser($name){
		$sql = "select count(*) as num  FROM t_user WHERE username = '$username'";

		$result = mysql_query($sql) or die("Can not chk data $sql ");
		$row=mysql_fetch_array($result);
		if($row[0]==1 &&  $dbaction == "ADD")	{
			$username="";
			$chknm="false";
			echo"<script language='JavaScript'>";
			echo"alert('User name นี้มีคนอื่นใช้แล้วกรุณา เปลี่ยนชื่อใหม่');";
			//echo"document.getElementById('txtusername').value='';";
			$username = '';
			echo"</script>";
			$cmdaction ="";
		}else{
			$chknm="true";
		}
		return $chknm;
	}
?>
