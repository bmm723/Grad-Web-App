<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

  //includes the page config
	require_once("../includes/page_config.php");
 
	$title = "RIT Graduate Capstone Tracker - New User Registered";
	$path = "../";
	$menu = "no";
	$table = "no";

	include($path.'includes/header.php');

?>

<div id="user_content">
<h1>Grad Student Registration Success</h1>
<h3>To login, <a href="../index.php">return home</a></h3>
<h3>
<?php 
  //if username, password, email, first or last name aren't entered, go back
  if($_POST['username'] =='' || $_POST['password'] =='' || $_POST['email'] == '' || $_POST['fname'] == '' || $_POST['lname'] == '' || $_POST['pname'] == '') {
    header("Location:".$path."pages/register.php");
  }
  else if($_POST['password'] != $_POST['validate_pw']) {
    header("Location:".$path."pages/register.php");
  }
  else {
    $getData->CreateStudent($_POST['username'],md5($_POST['password']),$_POST['email'],$_POST['fname'],$_POST['lname'],$_POST['pname'],$_POST['ptype'],$_POST['desc'],$_POST['term'], $_POST['date']); 
  }
?>
</h3>
</div>


<!-- include footer -->
<?php
	include($path.'includes/footer.php');
?>