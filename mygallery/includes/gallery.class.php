<? 

include_once("gallery.source.class.php");

class MyGallery extends MyGallery_source 
{
 		
		var $file_type;
		var $uncompress;
		var $upload_error;
		


			function Dummy( $str )
			{
				$this->_Dummy( $str );
			}


			
			function GetImgList( $folder )
			{
				$Dir = dir( $folder );
				
				$_SESSION['mygallery']['imglist'] = array();

				while( $dlist = $Dir->read() )
				{
					if( $dlist != "." && $dlist != ".." && preg_match("/th_/",$dlist) )
					{
						array_push( $_SESSION['mygallery']['imglist'], $dlist );
					}
				}

				


				$Dir->close();
			}


			/*
				$cellprop = array(
					"bgcolor" => hex,
					"border" => pixels, 
					"bordercolor" => hex, 
					"padding" => pixels, 
					"spacing" => pixels
				);
			*/

			function ShowGallery( $data, $image_in_line, $pager, $cellprop, $http_path, $http_imgpath )
			{
				global $linkclass;
			
				

				$MaxItems = count($data);

				echo "<p>Number of images in gallery: ".$MaxItems."</p>";

				if( $MaxItems > 0 )
				{

					echo "<table cellpadding='".$cellprop['padding']."' cellspacing='".$cellprop['spacing']."'><tr>";
				
					$i = 1;
					for( $m=((isset($_GET['entry'])) ? $_GET['entry'] : 0); $m < (($pager != 0) ? (( ($pager+$_GET['entry']) < $MaxItems) ? ($pager+$_GET['entry']) : $MaxItems ) : $MaxItems); $m++ )
					{

						
						
						$im = explode("th_", $data[$m]);
						$im = explode(".", $im[1]);

						$http_link = $http_path."view=".$im[0];

						echo "<td align='center' style='border: solid ".$cellprop['border']."px;border-color:".$cellprop['bordercolor'].";background-color:".$cellprop['bgcolor'].";'><a href='".$http_link."'><img src='".$http_imgpath.$data[$m]."' border='0'></a>";

						if( $_SESSION['mygallery']['logged_in'] == 1 )
						{
							echo "<br><a href='".$http_path."delimg=".$im[0]."' class='link' onClick='return confirm(\"Image is premanently deleted!\\nAre you sure?\");'>Delete</a>";
						}

						echo "</td>";

						if ( ($i % $image_in_line) == 0 ) 
						{
							echo "</tr><tr>\n";
						}

						$i++;


					}

					echo "</tr></table>";
					
					if( $pager != 0 && $MaxItems > $pager)
					{
						$this->_Pager( $pager, $MaxItems, $http_path, $linkclass, $_GET['entry'] );
					}



				}
				else 
				{
					print "WARNING! Input data is not array type or zero length!";
				}

			}
			



			function Login( $name, $passw, $adm_user, $adm_passw, $site_path )
			{

				if( $_GET['loginprocess'] == 1 )
				{
					if( $this->_CheckUser( $name, $passw, $adm_user, $adm_passw ) === TRUE )
					{
						if( isset($_SESSION['mygallery']['login_error']) )
							{ unset($_SESSION['mygallery']['login_error']); }

						$_SESSION['mygallery']['logged_in'] = 1;
						header("Location: ".$site_path);
					}
					else 
					{
						$_SESSION['mygallery']['login_error'] = 1;
						header("Location: ".$site_path);
					}
				}


				if( $_SESSION['mygallery']['logged_in'] != 1 )
				{
					$this->_LoginForm();
				}

				if( $_SESSION['mygallery']['logged_in'] == 1 )
				{
					$this->_adminMenu( $site_path );
				}

				
			}


			function Logout( $site_path )
			{
				unset($_SESSION['mygallery']['logged_in']);
				header("Location: ".$site_path);
			}



			function MyHeader( $title, $body_bg, $style_src )
			{
				$this->_PrintHeader( $title, $body_bg, $style_src );
			}

			function MyFooter( $str, $footer_class, $f_width )
			{
				$this->_PrintFooter( $str, $footer_class, $f_width );
			}




			function UploadForm( $full_path, $http_path, $upload, $all_types )
			{
				if( $_FILES['MyUploadFile']['name'] )
				{
					if( is_uploaded_file($_FILES['MyUploadFile']['tmp_name']) && in_array($_FILES['MyUploadFile']['type'], $all_types) )
					{
						$this->file_type = $_POST['FileType'];
						$this->_make_tmpname( $_FILES['MyUploadFile']['tmp_name'], $full_path );
						
						$tmp_image = $full_path.$this->tmpname;

						//print $this->tmpname;

						$this->_make_thumbnail( $tmp_image, $full_path );

						unlink($tmp_image);

						unset($_SESSION['mygallery']['imglist']);

						if( $this->resize_error )
						{
							print "..itt megáll!";
						}
						else 
						{
							
							header("Location: ".$http_path);
						}

					}
					else 
					{
						$this->upload_error = true;
					}
				}




				if( $this->upload_error )
				{
					print "<br><span class='alert'>Error during upload process!<br>Supported image types: [jpeg, gif, png].</span><br>";
				}




				$this->_uploadForm( $http_path, $upload );
			}





			function DeleteImg( $full_path, $http_path )
			{
				if( isset($_GET['delimg']) )
				{
					$jpeg_img = "th_".$_GET['delimg'].".jpg";
					$png_img = "th_".$_GET['delimg'].".png";
					$gif_img = "th_".$_GET['delimg'].".gif";

					if( in_array($jpeg_img, $_SESSION['mygallery']['imglist']) )
					{
						$suff = ".jpg";
					}
					else if( in_array($png_img, $_SESSION['mygallery']['imglist']) )
					{
						$suff = ".png";
					}
					else if( in_array($gif_img, $_SESSION['mygallery']['imglist']) )
					{
						$suff = ".gif";
					}
					else 
					{
						$no_delete = true;
					}

					if( !isset($no_delete) )
					{
						$imgname = "th_".$_GET['delimg'].$suff;
						$key = array_search($imgname, $_SESSION['mygallery']['imglist']);
						unset($_SESSION['mygallery']['imglist'][$key]);

						$del_A = $full_path."th_".$_GET['delimg'].$suff;
						$del_B = $full_path."O_".$_GET['delimg'].$suff;
						unlink( $del_A );
						unlink( $del_B );
						
						header("Location: ?");

						//print $key;

					}

					else 
					{
						print "<br><span class='alert'>ERROR DURING IMAGE DELETING!</span><br>";
					}


				}
			}
			



			function Bigpic( $full_path, $http_path, $cellprop )
			{
				if( isset($_GET['view']) )
				{
					if( in_array("th_".$_GET['view'].".jpg", $_SESSION['mygallery']['imglist']) )
					{
						$suff = ".jpg";
					}
					else if( in_array("th_".$_GET['view'].".png", $_SESSION['mygallery']['imglist']) )
					{
						$suff = ".png";
					}
					else if( in_array("th_".$_GET['view'].".gif", $_SESSION['mygallery']['imglist']) )
					{
						$suff = ".gif";
					}
					else 
					{
						$no_view = true;
					}


					if( !isset($no_view) )
					{

						$imgname = "O_".$_GET['view'].$suff;

						$this->_CheckImgProp($full_path.$imgname);

						if( $this->Prop['width'] > $this->orig_max )
						{
							$imgwidth = $this->orig_max;
						}


						echo "<table cellpadding='".$cellprop['padding']."' cellspacing='".$cellprop['spacing']."'><tr>";

						echo "<td style='border: solid ".$cellprop['border']."px;border-color:".$cellprop['bordercolor'].";background-color:".$cellprop['bgcolor'].";'><a href='javascript:history.back();' title=' Back '><img src='".$http_path.$imgname."'".( ($imgwidth) ? " width='".$this->orig_max."'" : "" )." border='0'></a>";
						
						echo "</tr></table>";
					}

				}
			}
			
}

?> 