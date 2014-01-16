<script type="text/javascript">
<!--
	$('document').ready(function(){
		//$('.animate').css('height','25px');
		$('.animate').mouseover(function(){
			$(this).stop();
			$(this).animate({height: 200,bottom: 0,margin: 0},'fast');
		}).mouseout(function(){
			$(this).stop();
			$(this).animate({height: 100,bottom: 0,margin: 0},'fast');
		});
	});
//-->
</script>
<style>
<!--
	.animate{
		cursor: pointer;
		padding: 20px;
		z-index: 1000;
	}
-->
</style>
<table style="width:100%;height:100%" id="menuTable">
	<tr>
		<td align="center" style="height: 100%;vertical-align: middle">
			<table style="width: 100%;">
				<tr>
					<td style="height: 250px;" valign="middle">
						<table style="margin-left: auto;margin-right: auto;">
							<tr>
							<?
								$sqlCoop="select * from coop_type order by coopID";
								$rCoop=mysql_query($sqlCoop);
								while($rowCoop=mysql_fetch_array($rCoop)):
							?>
								<td id="td_tree" style="height: 240px;">
									<img class="animate" src="<?echo $rowCoop["imagePath"]?>" height="140"
										onmouseover="$('#menuTitle').html('<?echo $rowCoop["coopName"]."<br>".$rowCoop["address"];?>')"
										onmouseout="$('#menuTitle').html('')"
										onclick="
											var height=$('#td_tree').height();
											var width=$('#td_tree').width();

											$('#td_tree').css('height',height);
											$('#td_tree').css('width',width);
											
											var left=$(this).position().left;
											var top=$(this).position().top;

											$(this).css('position','fixed').css('top',top).css('left',left).animate({
													opacity: 0,
													width: 1000,
													height: 1000,
													top: -200,
													left: $('#menuTable').position().left
												},'fast',function(){
													$('#menuTable').fadeOut(function(){
														window.open('?page=cropCalendar/calendar.php&coopID=<?=$rowCoop["coopID"]?>','_self');
													})
												}
											)
										"
									>
								</td>
								<?endwhile;?>
								<td id="td_selfAssessor" style="height: 240px;">
									<img class="animate" src="images/selfAssessor.png" height="100"
										onmouseover="$('#menuTitle').html('บุคคลทั่วไป')"
										onmouseout="$('#menuTitle').html('')"
										onclick="
											var height=$('#td_selfAssessor').height();
											var width=$('#td_selfAssessor').width();
	
											$('#td_selfAssessor').css('height',height);
											$('#td_selfAssessor').css('width',width);
											
											var left=$(this).position().left;
											var top=$(this).position().top;
											
											$(this).css('position','fixed').css('top',top).css('left',left).animate({
													opacity: 0,
													width: 1000,
													height: 1000,
													top: -200,
													left: $('#menuTable').position().left
												},'fast',function(){
													$('#menuTable').fadeOut(function(){
														window.open('?page=cropCalendar/calendar.php','_self')
													})
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
					<td align="center" style="height: 70px;"><h1 id="menuTitle"></h1></td>
				</tr>
			</table>
		</td>
	</tr>
</table>