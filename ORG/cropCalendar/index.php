<?php
	include "../function/functionPHP.php";
	host();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/rwii.css" />
		<link rel="stylesheet" type="text/css" href="css/cropCalendar.css" />
		<meta http-equiv="Content-Type"content="text/html; charset=utf-8" />
		<script src="../js/jquery-1.10.2.js" type="text/javascript"></script>
		
		<!-- required plugins -->
			<script type="text/javascript" src="../js/date.js"></script>
		<!-- jquery.datePicker.js -->
			<link rel="stylesheet" type="text/css" media="screen" href="../css/jquery-ui.css">
	  		<script src="../js/jquery-ui.js"></script>
		<!-- datePicker required styles -->
			<link rel="stylesheet" type="text/css" media="screen" href="../css/datePicker.css">
			<link rel="stylesheet" type="text/css" media="screen" href="../css/demo.css">
			
		<script type="text/javascript">
			$('document').ready(function(){
				var d = new Date();
			    //var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);
			    var toDay = (d.getFullYear() + 543)+'-'+(d.getMonth() + 1)+'-'+d.getDate();
				$(".date-pick").datepicker({ 
					changeMonth: true, 
					changeYear: true,
					//dateFormat: 'dd/mm/yy',
					dateFormat: 'yy-mm-dd',
					isBuddhist: true, 
					defaultDate: toDay,
					dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
		            dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
		            monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
		            monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
		            onSelect: function(){
			            $('this').blur();
			        }
				});
			});
		</script>
	</head>
	<body>
		<table style="width: 100%;">
			<tr>
				<td>
					<table>
						<tr>
							<td class="form_field">พันธุ์ข้าว</td>
							<td>
								<select id="rvID"
									onclick="$('#showCropButton').click()"
								>
									<?php
										$query="
											select	*
											from	crop_calendar.rice_varieties
										";
										$result=mysql_query($query)or die(mysql_error()."<br>".$query);
										$numrows=mysql_num_rows($result);
										$i=0;
										while($i<$numrows){
											$row=mysql_fetch_array($result);
											?>
												<option value="<?php echo $row[rvID]?>"><?php echo $row[rvName]?></option>
											<?php
											$i++;
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_field">การเพาะปลูก</td>
							<td>
								<select id="rpsID"
									onclick="$('#showCropButton').click()"
								>
									<?php
										$query="
											select	*
											from	crop_calendar.rice_planting_season
										";
										$result=mysql_query($query);
										$numrows=mysql_num_rows($result);
										$i=0;
										while($i<$numrows){
											$row=mysql_fetch_array($result);
											?>
												<option value="<?php echo $row[rpsID]?>"><?php echo $row[rpsName]?></option>
											<?php
											$i++;
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_field">วิธีการปลูก</td>
							<td>
								<select id="rpmID"
									onclick="$('#showCropButton').click()"
								>
									<?php
										$query="
											select	*
											from	crop_calendar.rice_planting_method
										";
										$result=mysql_query($query);
										$numrows=mysql_num_rows($result);
										$i=0;
										while($i<$numrows){
											$row=mysql_fetch_array($result);
											?>
												<option value="<?php echo $row[rpmID]?>"><?php echo $row[rpmName]?></option>
											<?php
											$i++;
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_field">วันที่เริ่มปลูก</td>
							<td>
								<input id="startDate" class="date-pick" type="text" value="<?php echo date("Y-m-d")?>"
									style="width: 70px;text-align: center;">
								<input id="showCropButton" type="button" value="Show Crop Calendar"
									onclick="
										$.post('cropCalendar.php',{
												startDate: $('#startDate').val(),
												rvID: $('#rvID').val(),
												rpsID: $('#rpsID').val(),
												rpmID: $('#rpmID').val()
											},function(data){
												$('#tdCropCalendar').html(data);
											}
										)
									"
								>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td id="tdCropCalendar" style="padding: 2px;"></td>
			</tr>
		</table>
	</body>
</html>