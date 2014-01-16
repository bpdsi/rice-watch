<? 
ob_start();

session_start();


if( !isset($_SESSION['mygallery']) )
	{ $_SESSION['mygallery'] = array(); }



	include("includes/config.include.php");


	//global $thumbnail_maxwidth, $image_maxwidth;
	

	include_once("includes/gallery.class.php");


	 
	$Gallery = new MyGallery();


	if( !isset($_SESSION['mygallery']['imglist']) || !$_SESSION['mygallery']['imglist'] )
	{
		$Gallery->GetImgList( $img_fullpath );
		$_SESSION['mygallery']['imglist'] = array_reverse($_SESSION['mygallery']['imglist']);
	}
	

	/*
		The Dummy method is only print any sample data [string, array, etc.]
	*/

	//$Gallery->Dummy( $_SESSION['mygallery'] );
	

	

	if( $_GET['logout'] == 1 )
	{
		$Gallery->Logout( $site_path );
	}




	$Gallery->MyHeader( "MyGallery v1.0", "#F5F5DC", "mygallery.css" );



	if( $_GET['login'] == 1 || $_SESSION['mygallery']['logged_in'] == 1 || $_SESSION['mygallery']['login_error'] == 1 )
	{
		$Gallery->Login( $_POST['MyGalleryUser'], $_POST['MyGalleryPassw'], $my_user, $my_passw, $site_path );

		$Gallery->UploadForm( $img_fullpath, $site_path, $_GET['upload'], $all_types );

		if( $_GET['delimg'] )
		{
			$Gallery->DeleteImg( $img_fullpath, $site_path );
		}
	}


	if( !isset($_GET['view']) )
	{
		$Gallery->ShowGallery( $_SESSION['mygallery']['imglist'], $img_num_in_line, $img_num_on_page, $cellprop, $link, $site_imgpath );
	}

	else 
	{
		$Gallery->Bigpic( $img_fullpath, $site_imgpath, $cellprop );
	}

	$Gallery->MyFooter( "MyGallery v1.0 footer text", "footer", $footer_width );



ob_end_flush();
?>