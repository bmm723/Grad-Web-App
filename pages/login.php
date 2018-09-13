<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

	$path = "./../";
	
	//includes the page config
	require_once("../includes/page_config.php");
	
	//check if there were POSTs sent
	if($_POST['username']!='' && $_POST['password']!='')
	{	
		$user = $_POST['username'];
		$pw = md5($_POST['password']);
		//checks if user and password are correct
		if($getData->Login($user, $pw)){
			header("Location: ".$path."pages/user_page.php");
		}
		else{
			header("Location: ".$path."index.php");
		}
	}
	else{
		//if nothing sent go back to index
		header("Location: ".$path."index.php");
	}
?>