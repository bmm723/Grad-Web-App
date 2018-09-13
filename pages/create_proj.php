<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

	require_once("../includes/page_config.php");

	$username = $roleCheck->getUser();

	$uid = $_SESSION['uid'];

	// pass info into function
	$getData->DeleteAndAddProject($uid, $_POST['pname'], $_POST['term'], $_POST['date'], $_POST['ptype'], $_POST['desc']);

	header("Location: user_page.php");

?>