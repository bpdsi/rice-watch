		0x01. WARNING! The gallery use only own risk!
		This is the 1.0Alpha version, maybe not right working!



	I. Install

Copy the all dirs and files into your Gallery directory, there will you use it.
mkdir images/ directory
Add write permission for your webserver to images/ directory. (or simple add write perm. for others)

	II. Config

Set your website paths. 
Gallery cells properties can you set in the $cellprop array.
Username and password of administrator can you set in "$my_user" and "$my_passw" variables.

Number of images on page "$img_num_on_page" variable
Number of images in line "$img_num_in_line" variable

Footer width in "$footer_width" variable
Link style in "$linkclass" variable

Maximum width of thumbnail images in gallery.source.class.php -> $th_max variable in pixels
Maximum width of big picture in gallery.source.class.php -> $orig_max variable in pixels



	III. Public Methods



$Gallery = new MyGallery();

	$Gallery->Dummy( $Data );
	The Dummy() method only print any data (string, array, etc.)

	$Gallery->GetImgList( $img_path );
	The GetImgList method scan the images folder and put name of thumbnail images in $_SESSION array.
	And during the browsing process the class use this array for display gallery.


	$Gallery->MyHeader( "Website <title> tag contents", "body background", "mygallery.css" );
	No comment!

	$Gallery->Login( $_POST['MyGalleryUser'], $_POST['MyGalleryPassw'], $my_user, $my_passw, $site_path );
	No Comment!


	$Gallery->UploadForm( $img_fullpath, $site_path, $_GET['upload'], $all_types );
	This method display the upload form and make, copy the images.
	For images making use gd2! When you not use gd2, than must be change imagecreatetruecolor() function 
	in the gallery.source.class.php, _make_thumbnail() method for imagecreate().


	$Gallery->DeleteImg( $img_fullpath, $site_path );
	No Comment!


	$Gallery->ShowGallery( $_SESSION['mygallery']['imglist'], $img_num_in_line, $img_num_on_page, $cellprop, $link, $site_imgpath );
	Display the gallery.


	$Gallery->Bigpic( $img_fullpath, $site_imgpath, $cellprop );
	Show big picture.


	$Gallery->MyFooter( "MyGallery v1.0 footer text", "footer", $footer_width );
	Display the footer text. (not required)


	IV. Know bugs.

	No bugs! I think.... :) 