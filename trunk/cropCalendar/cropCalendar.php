<?php
	include "../function/functionPHP.php";
	host();
	headerEncode();
	include"../disease/core_disease_period.php";
	include"../pest/core_pest_period.php";
	include"../animal/core_animal_period.php";
	include"core_method.php";
	$regionnm="ภาคตะวันออกเฉียงเหนือ";
	//$rice_crop=rice_crop();
	$rice_planting_method=rice_planting_method();
	$rice_planting_season=rice_planting_season();
	
	$startDate=$_POST["startDate"];
	$startYear=substr($startDate,0,4)-543;
	$startDate=$startYear.substr($startDate,4,strlen($startDate));
	$rvID=$_POST["rvID"];
	$rpsID=$_POST["rpsID"];
	$rpmID=$_POST["rpmID"];
	
	$query="
		select	*
		from	crop_calendar.rice_varieties
		where	rvID='$rvID'
	";
	$result=mysql_query($query)or die(mysql_error()."<br>".$query);
	$rice_varieties=mysql_fetch_array($result);
	
	$adate = date($startDate);
/*	echo date("Y-m-d",strtotime("+1 days",strtotime($adate)));*/
	
	$cropCalendar[pxPerDate]=10;
	$cropCalendar[displayPerDate]=10;
	
	$queryCropDuration="
		select	crop_calendar.crop_duration.*, crop_calendar.rice_crop.rcName
		from	crop_calendar.crop_duration,crop_calendar.rice_crop
		where	rvID='$rvID' and
				rpsID='$rpsID' and
				rpmID='$rpmID'
				and crop_calendar.crop_duration.rcID=crop_calendar.rice_crop.rcID
	";
	$resultCropDuration=mysql_query($queryCropDuration)or die(mysql_error());
	$numrowsCropDuration=mysql_num_rows($resultCropDuration);
	$iCropDuration=0;
	while($iCropDuration<$numrowsCropDuration){
		$rowCropDuration=mysql_fetch_array($resultCropDuration);
		$cropCalendar[crop][$iCropDuration+1]=$rowCropDuration[duration];
		$cropCalendar[preriod][$iCropDuration+1]=$rowCropDuration[rcName];
		$iCropDuration++;
	}
	
	if($numrowsCropDuration==0){
		exit();
	}
	
	
	
	$cropCalendar[cropDate][0]=1;
	$cropCalendar[cropDate][1]=$cropCalendar[crop][1];
	$cropCalendar[cropDate][2]=$cropCalendar[cropDate][1]+$cropCalendar[crop][2];
	$cropCalendar[cropDate][3]=$cropCalendar[cropDate][2]+$cropCalendar[crop][3];
	$cropCalendar[cropDate][4]=$cropCalendar[cropDate][2]+$cropCalendar[crop][3];
	
	$cropCalendar[summary]=array_sum($cropCalendar[crop]);
	$cropCount=count($cropCalendar[crop]);
	
	if($cropCalendar[summary]*$cropCalendar[pxPerDate]>1200){
		$cropCalendar[pxPerDate]=7;
	}
	
	$riceImg[1][file]="img/rice1.png";
	$riceImg[1][size]=getimagesize($riceImg[1][file]);
	
	$riceImg[2][file]="img/rice2.png";
	$riceImg[2][size]=getimagesize($riceImg[2][file]);
	
	$riceImg[3][file]="img/rice3.png";
	$riceImg[3][size]=getimagesize($riceImg[3][file]);
	
	$riceImg[4][file]="img/rice4.png";
	$riceImg[4][size]=getimagesize($riceImg[4][file]);
	
	$riceImg[5][file]="img/rice5.png";
	$riceImg[5][size]=getimagesize($riceImg[5][file]);
	
	$riceImg[1][left]=(
		(
			($cropCalendar[crop][1]*$cropCalendar[pxPerDate])/2
		)-($riceImg[1][size][0]/2)-110
	);
	$riceImg[2][left]=(
		(
			$cropCalendar[crop][1]*$cropCalendar[pxPerDate]
		)+(
			(
				$cropCalendar[crop][2]*$cropCalendar[pxPerDate]
			)/3
		)-($riceImg[2][size][0]/2)-25-120
	);
	$riceImg[3][left]=(
		(
			($cropCalendar[crop][1]*$cropCalendar[pxPerDate])
		)+(
			((
				$cropCalendar[crop][2]*$cropCalendar[pxPerDate]
			)/3)*2
		)-($riceImg[3][size][0]/2)+20-100
	);
	$riceImg[4][left]=(
		(
			($cropCalendar[crop][1]*$cropCalendar[pxPerDate])+
			($cropCalendar[crop][2]*$cropCalendar[pxPerDate])
		)+(
			(
				$cropCalendar[crop][3]*$cropCalendar[pxPerDate]
			)/2
		)-($riceImg[4][size][0]/2)-80
	);
	$riceImg[5][left]=(
		(
			($cropCalendar[crop][1]*$cropCalendar[pxPerDate])+
			($cropCalendar[crop][2]*$cropCalendar[pxPerDate])+
			($cropCalendar[crop][3]*$cropCalendar[pxPerDate])
		)+(
			(
				$cropCalendar[crop][4]*$cropCalendar[pxPerDate]
			)/2
		)-($riceImg[5][size][0]/2)-80
	);
	global $widthBtn;
?>
		<div 
			style="
				padding-top: 20px;
				position: relative;
				margin-left: auto;
				margin-right: auto;
				width: <?php echo $cropCalendar[summary]*$cropCalendar[pxPerDate]?>px;
			"
		>
			<img id="rice1" src="img/rice1.png"
				style="
					position: absolute;
					bottom: 200px;
					left: <?php echo $riceImg[1][left]?>px;
				">
			
			<div  id="method1x" 
				style="
					position: absolute;
					bottom: 120px;
					left: 0px;
				"
			>
			<?
				
				$widthBtn=$cropCalendar[pxPerDate]*$cropCalendar[crop][1];
				//$widthBtn=$riceImg[1][left]+$riceImg[2][left];
				$periodgrownm=$cropCalendar[preriod][1];
				if($periodgrownm!=""){	
					getMethodPerPeriod($periodgrownm, $rvID, $rpsID, $rpmID);
				}
			?>
			</div>
			<div  id="disease1x" 
				style="
					position: absolute;
					bottom: 100px;
					left: 0px;
				"
			>
			<?
				$widthBtn=$cropCalendar[pxPerDate]*$cropCalendar[crop][1];
				//$widthBtn=$riceImg[1][left]+$riceImg[2][left];
				$periodgrownm=$cropCalendar[preriod][1];
				if($periodgrownm!=""){
					getDiseasePerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<div  id="pest1x" 
				style="
					position: absolute;
					bottom: 80px;
					left: 0px;
				"
			>
			<?
				$periodgrownm=$cropCalendar[preriod][1];
				if($periodgrownm!=""){
					getPestPerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<div  id="animal1x" 
				style="
					position: absolute;
					bottom: 60px;
					left: 0px;
				"
			>
			<?
				$periodgrownm=$cropCalendar[preriod][1];
				if($periodgrownm!=""){
					getAnimalPerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<img id="rice1" src="img/rice2.png"
				style="
					position: absolute;
					bottom: 200px;
					left: <?php echo $riceImg[2][left]?>px;
				"
			>
			<img id="rice1" src="img/rice3.png"
				style="
					position: absolute;
					bottom: 200px;
					left: <?php echo $riceImg[3][left]?>px;
				"
			>
			<div  id="method2x" 
				style="
					position: absolute;
					bottom: 120px;
					left: <?php echo ($cropCalendar[crop][1]*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				
				$widthBtn=$cropCalendar[pxPerDate]*$cropCalendar[crop][2];
				$periodgrownm=$cropCalendar[preriod][2];
				if($periodgrownm!=""){	
					getMethodPerPeriod($periodgrownm, $rvID, $rpsID, $rpmID);
				}
			?>
			</div>
			<div  id="disease2x" 
				style="
					position: absolute;
					bottom: 100px;
					left: <?php echo ($cropCalendar[crop][1]*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				//$widthBtn=$riceImg[3][left]-$riceImg[1][left]-25;
				$widthBtn=$cropCalendar[pxPerDate]*$cropCalendar[crop][2];
				$periodgrownm=$cropCalendar[preriod][2];
				if($periodgrownm!=""){
					getDiseasePerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<div  id="pest2x" 
				style="
					position: absolute;
					bottom: 80px;
					left: <?php echo ($cropCalendar[crop][1]*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				$periodgrownm=$cropCalendar[preriod][2];
				if($periodgrownm!=""){
					getPestPerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<div  id="animal2x" 
				style="
					position: absolute;
					bottom: 60px;
					left: <?php echo ($cropCalendar[crop][1]*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				$periodgrownm=$cropCalendar[preriod][2];
				if($periodgrownm!=""){
					getAnimalPerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<img id="rice1" src="img/rice4.png"
				style="
					position: absolute;
					bottom: 200px;
					left: <?php echo $riceImg[4][left]?>px;
				"
			>
			<div  id="method3x" 
				style="
					position: absolute;
					bottom: 120px;
					left: <?php echo (($cropCalendar[crop][1]+$cropCalendar[crop][2])*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				
				$widthBtn=$cropCalendar[pxPerDate]*$cropCalendar[crop][3];
				//$widthBtn=$riceImg[1][left]+$riceImg[2][left];
				$periodgrownm=$cropCalendar[preriod][3];
				if($periodgrownm!=""){	
					getMethodPerPeriod($periodgrownm, $rvID, $rpsID, $rpmID);
				}
			?>
			</div>
			<div  id="disease3x" 
				style="
					position: absolute;
					bottom: 100px;
					left: <?php echo (($cropCalendar[crop][1]+$cropCalendar[crop][2])*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				$widthBtn=$cropCalendar[pxPerDate]*$cropCalendar[crop][3];
				$periodgrownm=$cropCalendar[preriod][3];
				if($periodgrownm!=""){
					getDiseasePerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<div  id="pest3x" 
				style="
					position: absolute;
					bottom: 80px;
					left: <?php echo (($cropCalendar[crop][1]+$cropCalendar[crop][2])*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				$periodgrownm=$cropCalendar[preriod][3];
				if($periodgrownm!=""){
					getPestPerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<div  id="animal3x" 
				style="
					position: absolute;
					bottom: 60px;
					left: <?php echo (($cropCalendar[crop][1]+$cropCalendar[crop][2])*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				$periodgrownm=$cropCalendar[preriod][3];
				if($periodgrownm!=""){
					getAnimalPerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<img id="rice1" src="img/rice5.png"
				style="
					position: absolute;
					bottom: 200px;
					left: <?php echo $riceImg[5][left]?>px;
				"
			>
			<div  id="method4x" 
				style="
					position: absolute;
					bottom: 120px;
					left: <?php echo (($cropCalendar[crop][1]+$cropCalendar[crop][2]+$cropCalendar[crop][3])*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				
				$widthBtn=$cropCalendar[pxPerDate]*$cropCalendar[crop][4];
				//$widthBtn=$riceImg[1][left]+$riceImg[2][left];
				$periodgrownm=$cropCalendar[preriod][4];
				if($periodgrownm!=""){	
					getMethodPerPeriod($periodgrownm, $rvID, $rpsID, $rpmID);
				}
			?>
			</div>
			<div  id="disease4x"
				style="
					position: absolute;
					bottom: 100px;
					left: <?php echo (($cropCalendar[crop][1]+$cropCalendar[crop][2]+$cropCalendar[crop][3])*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				$periodgrownm=$cropCalendar[preriod][4];
				if($periodgrownm!=""){
					getDiseasePerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<div  id="pest4x" 
				style="
					position: absolute;
					bottom: 80px;
					left: <?php echo (($cropCalendar[crop][1]+$cropCalendar[crop][2]+$cropCalendar[crop][3])*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				$widthBtn=$cropCalendar[pxPerDate]*$cropCalendar[crop][4];
				$periodgrownm=$cropCalendar[preriod][4];
				if($periodgrownm!=""){
					getPestPerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<div  id="animal4x" 
				style="
					position: absolute;
					bottom: 60px;
					left: <?php echo (($cropCalendar[crop][1]+$cropCalendar[crop][2]+$cropCalendar[crop][3])*$cropCalendar[pxPerDate])?>px;
				"
			>
			<?
				$periodgrownm=$cropCalendar[preriod][4];
				if($periodgrownm!=""){
					getAnimalPerPeriod($periodgrownm,$regionnm);		
				}
			?>
			</div>
			<table class="noSpacing" 
				style="
					width: <?php echo $cropCalendar[summary]*$cropCalendar[pxPerDate]?>px;
					border-left: 1px solid #000;
				"
			>
				<tr>
					<?php
						$dayCount=1;
						for($i=1;$i*$cropCalendar[pxPerDate]<=$cropCalendar[summary]*$cropCalendar[pxPerDate];$i++){
							?>
								<td 
									style="
										border-right: 1px solid #000;
										height: 5px;
										<?php
											if(
												$dayCount==$cropCalendar[displayPerDate] ||
												$i==$cropCalendar[cropDate][0] ||
												$i==$cropCalendar[cropDate][1] ||
												$i==$cropCalendar[cropDate][2] ||
												$i==$cropCalendar[cropDate][3] ||
												$i==$cropCalendar[cropDate][4] ||
												$i==$cropCalendar[summary]
											){
												echo "background-color: #ddd;";
											} 
										?>
									"
									onmouseover="
										this.style.backgroundColor='#0f0';
										this.style.cursor='pointer';
										$('#dayDisplay<?php echo $i;?>').css('background-color','#fff');
										$('#dayDisplay<?php echo $i;?>').css('border','1px solid #000');
										$('#dayDisplay<?php echo $i;?>').css('display','');
										$('#dayDisplay<?php echo $i;?>').css('z-index','1000');
									"
									onmouseout="
										<?php
											if($dayCount==$cropCalendar[displayPerDate] ||
												$i==$cropCalendar[cropDate][0] ||
												$i==$cropCalendar[cropDate][1] ||
												$i==$cropCalendar[cropDate][2] ||
												$i==$cropCalendar[cropDate][3] ||
												$i==$cropCalendar[cropDate][4] ||
												$i==$cropCalendar[summary]
											){
												echo "this.style.backgroundColor='#ddd';";
												?>
													$('#dayDisplay<?php echo $i;?>').css('display','');
													$('#dayDisplay<?php echo $i;?>').css('z-index','');
													$('#dayDisplay<?php echo $i;?>').css('border','1px solid #fff');
												<?php
											}else{
												echo "this.style.backgroundColor='';";
												?>
													$('#dayDisplay<?php echo $i;?>').css('display','none');
													$('#dayDisplay<?php echo $i;?>').css('z-index','');
													$('#dayDisplay<?php echo $i;?>').css('border','1px solid #fff');
												<?php
											} 
										?>
										
									"
								>
									<div id="dayBlock<?php echo $i;?>" style="position: relative">
										<div id="dayDisplay<?php echo $i;?>"
											style="
												<?php
													if(
														$dayCount==$cropCalendar[displayPerDate] ||
														$i==$cropCalendar[cropDate][0] ||
														$i==$cropCalendar[cropDate][1] ||
														$i==$cropCalendar[cropDate][2] ||
														$i==$cropCalendar[cropDate][3] ||
														$i==$cropCalendar[cropDate][4] ||
														$i==$cropCalendar[summary]
													){
														echo "display:;";
														$dayCount=0;
													}else{
														echo "display: none;";
													}
												?>
												position: absolute;
												top: -25px;
												font-size: 17px;
												width: 50px;
												text-align: center;
												border: 1px solid #fff;
											"
										>
											<?php
												$temp=$i-1;
												echo dateEncodeCrop(date("Y-m-d",strtotime("+$temp days",strtotime($adate)))); 
											?>
										</div>
									</div>
									<script type="text/javascript">
										$('document').ready(function(){
											var	blockWidth=parseInt($('#dayBlock<?php echo $i;?>').css('width'));
											var width=parseInt($('#dayDisplay<?php echo $i;?>').css('width'));
											var minus=Math.abs(blockWidth-width)+2;
											var left=(minus/2)*-1;
											$('#dayDisplay<?php echo $i;?>').css('left',left);
										});
									</script>
								</td>
							<?php
							$dayCount++;
						} 
					?>
				</tr>
			</table>
			<table class="noSpacing" 
				style="
					width: <?php echo $cropCalendar[summary]*$cropCalendar[pxPerDate]?>px;
					border: 1px solid #000;
					margin-left: auto;
					margin-right: auto;
					height: 500px;
					background-image: url('img/verticalLine.png'), <?php
						for($i=1;$i<=$cropCount;$i++){
							?>url('img/verticalLine.png')<?php
							if($cropCalendar[crop][$i+1]!=""){
								echo ",";
							}else{
								echo ";";
							}
						} 
					?>
					background-repeat: repeat-y, <?php
						for($i=1;$i<=$cropCount;$i++){
							echo "repeat-y";
							if($cropCalendar[crop][$i+1]!=""){
								echo ",";
							}else{
								echo ";";
							}
						} 
					?>
					background-position: 0px 0px, <?php
						$cropWidth=0;
						for($i=1;$i<=$cropCount;$i++){
							$cropWidth+=$cropCalendar[crop][$i];
							echo (($cropWidth*$cropCalendar[pxPerDate])-1)."px 0px";
							if($cropCalendar[crop][$i+1]!=""){
								echo ",";
							}else{
								echo ";";
							}
						} 
					?> 
				"
			>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td
						style="
							background-image: url('img/ground2.png');
							background-repeat: repeat-x;
							background-position: 0px 110px;
						"
					>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>
<div id="divDetail"
	style="
		background-color: #fff;
		position: absolute;
		display:none;
		padding: 5px;
	"
>
	<table class="noSpacing">
		<tr>
			<td>
				<div id="divTitle" style="float: left;padding-right: 10px;"></div>
				<img src="images/close.png" style="float: right;cursor: pointer;"
					onclick="$('#divDetail').fadeOut('fast')"
				>
			</td>
		</tr>
		<tr>
			<td id="divContent"></td>
		</tr>
		<tr>
			<td id="divFooter"></td>
		</tr>
	</table>
</div>
<script>
	$("#Disease1").toggle();	
	$("#Disease2").toggle();	
	$("#Disease3").toggle();	
	$("#Disease4").toggle();	
	$("#Disease5").toggle();	
	$("#Disease6").toggle();	
	$("#Pest1").toggle();	
	$("#Pest2").toggle();	
	$("#Pest3").toggle();	
	$("#Pest4").toggle();	
	$("#Pest5").toggle();	
	$("#Pest6").toggle();	
	$("#Animal1").toggle();	
	$("#Animal2").toggle();	
	$("#Animal3").toggle();	
	$("#Animal4").toggle();	
	$("#Animal5").toggle();	
	$("#Animal6").toggle();	
	$(document).ready(function(){
		 $("#btnDisease1").click(function(){
			$("#Disease1").toggle(300);
		 });
		 $("#btnDisease2").click(function(){
			$("#Disease2").toggle(300);
		 });
		 $("#btnDisease3").click(function(){
			$("#Disease3").toggle(300);
		 });
		 $("#btnDisease4").click(function(){
			$("#Disease4").toggle(300);
		 });
		 $("#btnDisease5").click(function(){
			$("#Disease5").toggle(300);
		 });
		 $("#btnDisease6").click(function(){
			$("#Disease6").toggle(300);
		 });
		 $("#btnPest1").click(function(){
			$("#Pest1").toggle(300);
		 });
		 $("#btnPest2").click(function(){
			$("#Pest2").toggle(300);
		 });
		 $("#btnPest3").click(function(){
			$("#Pest3").toggle(300);
		 });
		 $("#btnPest4").click(function(){
			$("#Pest4").toggle(300);
		 });
		 $("#btnPest5").click(function(){
			$("#Pest5").toggle(300);
		 });
		 $("#btnPest6").click(function(){
			$("#Pest6").toggle(300);
		 });
		 $("#btnAnimal1").click(function(){
			$("#Animal1").toggle(300);
		 });
		 $("#btnAnimal2").click(function(){
			$("#Animal2").toggle(300);
		 });
		 $("#btnAnimal3").click(function(){
			$("#Animal3").toggle(300);
		 });
		 $("#btnAnimal4").click(function(){
			$("#Animal4").toggle(300);
		 });
		 $("#btnAnimal5").click(function(){
			$("#Animal5").toggle(300);
		 });
		 $("#btnAnimal6").click(function(){
			$("#Animal6").toggle(300);
		 });

		//Show Pest Detail
		$('.pestTD').click(function(){
			var offsetLeft=$(this).offset().left;
			$('#divDetail').css('top',$(this).offset().top);
			$('#divDetail').css('left',$(this).offset().left+$(this).width());
			$('#divDetail').css('border',$(this).css('border'));
			var leftxx=$(this).offset().left;
			var widthxx=$(this).width();
			$('#divTitle').html('รายละเอียด');
			$.post('cropCalendar/loadPestDetail.php',{
					pest_id: $(this).attr('pest_id')
				},function(data){
					$('#divContent').html(data);
					$('#divDetail').fadeIn('fast');
					if($('#divContent').width()>680){
						$('.detailContent').css('max-width','680px');
						$('.detailContent').css('white-space','normal');
					}else{
						//alert("680");
						$('.detailContent').css('white-space','pre');
					}
					var xxx=leftxx+widthxx;
					var rightxx=($(window).width() - (leftxx + widthxx));
					if(xxx > 700){//$(window).width()){
						$('#divDetail').css('width',680);
						var temp=(offsetLeft -  $('#divDetail').width()-10);
						$('#divDetail').css('left',temp);
						
					}else{
						$('#divDetail').css('width','auto');
					}
				}
			);
		});

		$('.diseaseTD').click(function(){
			var offsetLeft=$(this).offset().left;
			$('#divDetail').css('top',$(this).offset().top);
			$('#divDetail').css('left',$(this).offset().left+$(this).width());
			$('#divDetail').css('border',$(this).css('border'));
			var leftxx=$(this).offset().left;
			var widthxx=$(this).width();
			$('#divTitle').html('รายละเอียด');
			$.post('cropCalendar/loadDiseaseDetail.php',{
					disease_id: $(this).attr('disease_id')
				},function(data){
					$('#divContent').html(data);
					$('#divDetail').fadeIn('fast');
					if($('#divContent').width()>680){
						$('.detailContent').css('max-width','680px');
						$('.detailContent').css('white-space','normal');
					}else{
						//alert("680");
						$('.detailContent').css('white-space','pre');
					}
					var xxx=leftxx+widthxx;
					var rightxx=($(window).width() - (leftxx + widthxx));
					if(xxx > 700){//$(window).width()){
						$('#divDetail').css('width',680);
						var temp=(offsetLeft -  $('#divDetail').width()-10);
						$('#divDetail').css('left',temp);
						
					}else{
						$('#divDetail').css('width','auto');
					}
				}
			);
		});

		$('.animalTD').click(function(){
			var offsetLeft=$(this).offset().left;
			$('#divDetail').css('top',$(this).offset().top);
			$('#divDetail').css('left',$(this).offset().left+$(this).width());
			$('#divDetail').css('border',$(this).css('border'));
			var leftxx=$(this).offset().left;
			var widthxx=$(this).width();
			$('#divTitle').html('รายละเอียด');
			$.post('cropCalendar/loadAnimalDetail.php',{
					animal_id: $(this).attr('animal_id')
				},function(data){
					$('#divContent').html(data);
					$('#divDetail').fadeIn('fast');
					if($('#divContent').width()>680){
						$('.detailContent').css('max-width','680px');
						$('.detailContent').css('white-space','normal');
					}else{
						//alert("680");
						$('.detailContent').css('white-space','pre');
					}
					var xxx=leftxx+widthxx;
					var rightxx=($(window).width() - (leftxx + widthxx));
					if(xxx > 700){//$(window).width()){
						$('#divDetail').css('width',680);
						var temp=(offsetLeft -  $('#divDetail').width()-10);
						$('#divDetail').css('left',temp);
						
					}else{
						$('#divDetail').css('width','auto');
					}
				}
			);
		});
		$('.methodTD').click(function(){
			var offsetLeft=$(this).offset().left;
			$('#divDetail').css('top',$(this).offset().top);
			$('#divDetail').css('left',$(this).offset().left+$(this).width());
			$('#divDetail').css('border',$(this).css('border'));
			var leftxx=$(this).offset().left;
			var widthxx=$(this).width();
			$('#divTitle').html('รายละเอียด');
			$.post('cropCalendar/loadMethodDetail.php',{
					periodgrownm: $(this).attr('periodgrownm'),
					rpsID: <?echo $rpsID?>,
					rpmID: <?echo $rpmID?>,
					rvID: <?echo $rvID?>
				},function(data){
					$('#divContent').html(data);
					$('#divDetail').fadeIn('fast');
					if($('#divContent').width()>680){
						$('.detailContent').css('max-width','680px');
						$('.detailContent').css('white-space','normal');
					}else{
						//alert("680");
						$('.detailContent').css('white-space','pre');
					}
					var xxx=leftxx+widthxx;
					var rightxx=($(window).width() - (leftxx + widthxx));
					if(xxx > 700){//$(window).width()){
						$('#divDetail').css('width',680);
						var temp=(offsetLeft -  $('#divDetail').width()-10);
						$('#divDetail').css('left',temp);
						
					}else{
						$('#divDetail').css('width','auto');
					}
				}
			);
		});
	});
</script>