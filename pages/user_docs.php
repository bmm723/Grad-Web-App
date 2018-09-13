<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017
	
	$path = "../";
	$title = "RIT Graduate Capstone Tracker: User Documentation" ;
	$menu = "no";
	$table = "no";

	include($path."includes/header.php")

?>
<!-- jQuery Tabs Custom Theme Plugin -->
<link rel="stylesheet" href="../assets/jquery-ui-tabs/jquery-ui.css">
<script src="../assets/jquery-ui-tabs/jquery-ui.js"></script>
<script>
$( function() {
$( "#tabs" ).tabs();
} );
</script>

<!-- banner style override -->
<style>#banner {margin-bottom: 60px;}</style>

<!-- page heading -->
<h1 id="user_doc_h1">User Documentation</h1>

<!-- back button -->
<style>.cancel {top: 81px; right: 5px; left: auto;}</style>
<div class='cancel'>
	<a href="user_page.php">Back</a>
</div>

<!-- tabs -->
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Students</a></li>
    <li><a href="#tabs-2">Faculty</a></li>
    <li><a href="#tabs-3">Staff</a></li>
  </ul>
  <!-- student tab -->
  <div id="tabs-1">
    <h2>Introduction</h2>
    <p>RIT Graduate Capstone Tracker is an online tool for students, faculty, and staff to use in order to centralize communication on graduate capstone projects. If you have an RIT user account and do not have access to this site and believe you should, contact your Systems Administrator.</p>
    <h2>Instructions</h2>
    <h3>Available Pages and Functions</h3>
    <img src="../images/student_tree.png" alt="tree">
	<p>Begin by logging into your account from the home screen.</p>
	<p>Once logged in, you will be directed to your Capstone Project. If your account isn't linked to a project, you will be directed to a page to create one.</p>
	<p>In the center of the screen you will see your capstone project title, status, starting term, and ending date. You can also edit the description of your project here.
  </p>
	<p>On the left of the window is a slide out menu where you can see information about the professors overseeing your capstone. By clicking on the name under a position title, you can select a professor for that position from a list of all professors.</p>
	<p>Any changes can be made using the Submit button the main project screen.</p>
  </div>
  <!-- faculty tab -->
  <div id="tabs-2">
  <h2>Introduction</h2>
    <p>RIT Graduate Capstone Tracker is an online tool for students, faculty, and staff to use in order to centralize communication on graduate capstone projects.</p> 
    <p>Faculty members associated with a project will be designated as either the project "Chair" or a "Reader". A capstone project will have only one Chair member as well as up to two Readers. 
		Both the Readers and the Chair have the ability to view information including; the project's topic, role on the project, and grades associated with a project. 
		If a faculty member is selected as the Chair for a project, they exclusively have the ability to edit the grades on the project.</p>
    <h2>Instructions</h2>
	<h3>Available Pages and Functions</h3>
	<img src="../images/faculty_tree.png" alt="tree">
    <p>To log in as a Faculty member, use your RIT username and password. Once successfully signed in, you will be directed to a list of the projects you have been added to.</p>
    <p>On the landing page, you can see a quick view of the projects you have been added to.
		The quick view list includes the graduate student's first and last name, the project topic,
		and your role in the project. There is a "Search" feature on this page that
		you can use to find a certain project; searches can be completed by using project information
		including, but not limited to, the student's name, the project title, 
		or your position on the project.
		</p>
		<p>There is also a "Select" option by each project in the list. This will
		take you to the main project page with all the information on a project, including; the start term,
		the planned end date, the project approval status, and the project grades.
		You cannot edit information on this page unless you are the Chair, in which
		case you will be able to edit project grades.</p>
  </div>
  <!-- staff tab -->
  <div id="tabs-3">
    <h2>Introduction</h2>
    <p>RIT Graduate Capstone Tracker is an online tool for students, faculty, and staff to use in order to centralize communication on graduate capstone projects. Staff
    members on a project have the ability to view all projects as well as edit a project's milestone status.</p> 
    <h2>Instructions</h2>
	<h3>Available Pages and Functions</h3>
	<img src="../images/staff_tree.png" alt="tree">
    <p>To log in as a Staff member, use your RIT username and password. Once successfully signed in, you will be directed to a full list of projects for the department. The list is a quick view, with only some of the project information listed.</p>
    <p> The quick view list includes the graduate student's first and last name, the project topic, and the Faculty assigned to the project. There is a "Search" feature on this page that can be used to find a certain project; searches can be completed by using project information including, but not limited to, the student's name, the project title, or Faculty associated with the project.
		</p>
		<p>There is also a "Select" option by each project in the list. This will
		take you to the main project page with all the information on a project, including; the start term, the planned end date, the project approval status, and the project grades. Staff members are allowed to change a project's milestone status.</p>
  </div>
</div>



<!-- footer style override -->
<style>#footer {position: relative;}</style>
<?php

	include($path."includes/footer.php")

?>
