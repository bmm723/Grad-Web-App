<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

	session_start();
	session_name('Capstone Tracker');
	session_destroy();
	header('Location: ./../index.php');
?>