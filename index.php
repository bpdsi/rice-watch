<?php
	session_start();
	global $table;
	$page=$_GET[page];
	include "function/functionPHP.php";
	
	
	/*if(!authenticated()){
		header("location:authen/index.php");
		exit();
	}*/
	if($page==""){
		$page="home.php";
	}
	include "header.php";
	//include "function/corelib.php";
	if(is_file($page)){
		include $page;
	}else{
		include "underConstruction.php";
	}

	include "footer.php";
?>