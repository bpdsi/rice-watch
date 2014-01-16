<?


class MyGallery_source 
{


	var $tmpname; // -- uploaded file temporary name in /images directory, this is the orginal filename with appended unique id
	var $Prop; // ---- this array contains the uploaded image properties
	var $resize_error;
	var $th_max = 140;
	var $new_thumbnail;
	var $orig_max = 600;
	

	
	
	


			function _Dummy( $str )
			{
				 print "<pre style='font-size:12px;'>";
							 print_r( $str );
				 print "</pre>";
			}
			



			function _PrintHeader( $title, $body_bg, $style_src )
			{
				echo "<html>
					<head>
						<title>".$title."</title>
						<style>@import url(".$style_src.");</style>
					</head>
					<body marginwidth='0' marginheight='0' topmargin='0' leftmargin='0' bgcolor='".$body_bg."'><center>";
			}

			function _PrintFooter( $str, $footer_class, $f_width )
			{
				echo "<table width='".( ($f_width == "") ? "100%" : $f_width )."' cellpadding='0' cellspacing='0' border='0'>
					<tr>
						<td class='".$footer_class."'>".$str."</td>
					</tr>
				</table>
				</body>
				</html>";
			}



			

			
			function _CheckUser( $name, $passwd, $adm_user, $adm_passw )
			{
				if( ($name == $adm_user) && ($passwd == $adm_passw) )
				{
					return TRUE;
				}
				else 
				{ 
					return FALSE;				
				}
			}





			function _MoveFile( $Src, $Dest )
			{
			 	move_uploaded_file( $Src, $Dest );
			}





			function _Pager( $p, $maxnum, $link, $linkclass, $ent )
			{
				$n = ceil( $maxnum / $p );
				
					print "<a href='".$link."entry=0' class='".$linkclass."'>1</a> ";
					//print "<br>".$n;

				$k = 1;
				
				while( $k < $n )
				{
					$pg = $k * $p;

					print "<a href='".$link."entry=".$pg."' class='".$linkclass."'>".($k+1)."</a> ";

					

					$k++;
				}

			}



			function _CheckImgProp( $Img )
			{
				 if( $Img )
				 {
					 $Image = GetImageSize( $Img );
					 
					 if( $Image[2] == 1 ){ $Type = "gif"; }
					 else if( $Image[2] == 2 ){ $Type = "jpg"; }
					 else if( $Image[2] == 3 ){ $Type = "png"; }
					 else { $Type = NULL; }
					 
					if( !is_null($Type) )
					{
					 $this->Prop = array(
								 "width" => $Image[0],
								 "height" => $Image[1],
								 "type" => $Type,
								 "type_code" => $Image[2],
								 "img_tag" => $Image[3]
								);
					}
					else 
					{
						$this->Prop = false;
					}
				 }
				 else 
				 {
					$this->Prop = false;
				 }

				 return $this->Prop;
			}


			function _LoginForm()
			{
				echo "<br>
				<form action='".$PHP_SELF."?login=1&loginprocess=1' method='post'>
				<table cellpadding='4' cellspacing='0' border='0' width='250' style='border:solid 2px;border-color:#000000;background-color:#5F9EA0;'>
					<tr>
						<td style='width:100%;font-family:Verdana,Arial,sans-serif;color:#000000;font-weight:bold;font-size:11px;text-align:center;'>Login to Mygallery Administration</td>
					</tr>	

					<tr>
						<td style='width:100%;font-family:Verdana,Arial,sans-serif;color:#000000;font-weight:bold;font-size:11px;'>Username:<input type='text' name='MyGalleryUser' style='width:100%;background-color:#e3e3e3;color:#000000;font-family:verdana,arial,sans-serif;font-size:11px;border:solid 1px;border-color:#880000;'></td>
					</tr>
					
						<tr>
						<td style='width:100%;font-family:Verdana,Arial,sans-serif;color:#000000;font-weight:bold;font-size:11px;'>Password:<input type='password' name='MyGalleryPassw' style='width:100%;background-color:#e3e3e3;color:#000000;font-family:verdana,arial,sans-serif;font-size:11px;border:solid 1px;border-color:#880000;'></td>
					</tr>
					<tr>
						<td align='right' style='width:100%;font-family:Verdana,Arial,sans-serif;color:#000000;font-weight:bold;font-size:11px;'><input type='submit'  style='width:60px;background-color:coral;color:#000000;font-family:verdana,arial,sans-serif;font-size:11px;border:solid 1px;border-color:#000000;' value=' Login '></td>
					</tr>
				</table>
				</form>
				";
			}




			function _adminMenu( $http_path )
			{
				echo "<br>
				<table cellpadding='2' cellspacing='0' border='0' style='border: solid 2px;border-color:maroon;'>
					<tr>
						<td style='background-color:#e3e3e3;'><a href='".$http_path."?upload=1' class='link'>Upload Images</a> <a href='".$http_path."?logout=1' class='link'>Logout</a></td>
					</tr>
				</table>";
			}



			function _uploadForm( $http_path, $upload )
			{
				if( $_SESSION['mygallery']['logged_in'] == 1 && $upload == 1 )
				{
					echo "<br><form action='".$http_path."?upload=1' enctype='multipart/form-data' method='post'>
					<table width='300' cellpadding='2' cellspacing='0' border='0' style='border: solid 2px;border-color:maroon;'>
						<tr>
							<td style='background-color:#e3e3e3;'>
							<input type='file' name='MyUploadFile' style='background-color:#e3e3e3;color:#000000;font-family:verdana,arial,sans-serif;font-size:11px;border:solid 1px;border-color:#880000;'>
							<!--select name='FileType' style='width:100%;background-color:#e3e3e3;color:#000000;font-family:verdana,arial,sans-serif;font-size:11px;border:solid 1px;border-color:#880000;'>
								<option value=1> Single imagefile
								<option value=2> Compressed archive
							</select-->
							</td>
						</tr>
						<!--tr>
							<td valign='middle' style='width:100%;font-family:Verdana,Arial,sans-serif;color:#000000;font-size:11px;background-color:#e3e3e3;'><input onClick='window.alert(\"Warning!\\nThe uncompressing process required few minutes when the compressed file is not too little... :)\");' type='checkbox' name='MyUncompress'>Uncompress <input type='checkbox' name='MyThumb'>Make thumbnail</td>
						</tr-->
						<tr>
							<td align='right' style='width:100%;font-family:Verdana,Arial,sans-serif;color:#000000;font-weight:bold;font-size:11px;background-color:#e3e3e3;'><input type='submit'  style='width:60px;background-color:coral;color:#000000;font-family:verdana,arial,sans-serif;font-size:11px;border:solid 1px;border-color:#000000;' value=' Upload '></td>
						</tr>
					</table></form>";
				}
			}



			function _make_tmpname( $Src, $Dest )
			{
				$this->tmpname = time()."_".$_FILES['MyUploadFile']['name'];
				$this->_MoveFile( $Src, $Dest.$this->tmpname);
				
				return $this->tmpname;
			}


			


			function _make_thumbnail( $src, $path )
			{

				$this->_CheckImgProp( $src );

				if( is_array($this->Prop) )
				{
					$name = md5(time());
					$th = "th_".$name.".".$this->Prop['type'];
					$big = "O_".$name.".".$this->Prop['type'];

					$ImgWidth = $this->th_max;
					$ImgH = round( $this->Prop['width'] / $this->th_max );
					$ImgHeight = round( $this->Prop['height'] / $ImgH );
					$Imgheight = ($ImgHeight -1);
					$ImgWidth = ($ImgWidth -1);

					$ThSrc = ImageCreatetruecolor( $ImgWidth, $ImgHeight );
					
					if( $this->Prop['type_code'] == 1 )
					{
						$Image = ImageCreateFromGIF( $src );
					}

					if( $this->Prop['type_code'] == 2 )
					{
						$Image = ImageCreateFromJPEG( $src );
					}

					if( $this->Prop['type_code'] == 3 )
					{
						$Image = ImageCreateFromPNG( $src );
					}

					
					
					$Thmb = ImageCopyResized( $ThSrc, $Image, 0, 0, 0, 0, $ImgWidth, $ImgHeight, $this->Prop['width'], $this->Prop['height'] );


					if( $this->Prop['type_code'] == 1 )
					{
						ImageGIF( $ThSrc, $path.$th );
						copy( $src, $path.$big );
					}

					if( $this->Prop['type_code'] == 2 )
					{
						ImageJPEG( $ThSrc, $path.$th );
						copy( $src, $path.$big );
					}

					if( $this->Prop['type_code'] == 3 )
					{
						ImagePNG( $ThSrc, $path.$th );
						copy( $src, $path.$big );
					}

					return $this->new_thumbnail = true;

					//var_dump( $Thmb );



				}
				else 
				{
					return $this->resize_error = true;
				}
			}






}

?>