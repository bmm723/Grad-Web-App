<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

//BUSINESS LAYER
//Class to check for role and login handling
class RoleCheck{
	var $dbh;
	
	//checks to see if user is logged in
	function CheckForLogin(){
		//checks for login var in session
		session_start();
		if($_SESSION['login']){
			return true;
		}
		else{
			return false;
		}
	}
	
	//checks if the user is a grad
	function isGrad(){
		session_start();
		if($_SESSION['role'] == "Grad"){
			return true;
		}
		return false;
	}
	
	//checks if the user is faculty
	function isFaculty(){
		session_start();
		if($_SESSION['role'] == "Faculty"){
			return true;
		}
		return false;
	}
	
	//checks staff type
	function isChair(){
		session_start();
		if($_SESSION['roleType'] == "Chair"){
			return true;
		}
		return false;
	}
	
	//checks if the user is staff
	function isStaff(){
		session_start();
		if($_SESSION['role'] == "Staff"){
			return true;
		}
		return false;
	}
	
	//returns username
	function getUser(){
		session_start();
		return $_SESSION['username'];
	}
	
}

?>