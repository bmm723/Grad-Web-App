<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

	$title = "RIT Graduate Capstone Tracker";
	$path = "./";
	$menu = "no";
	$table = "no";

	include($path.'includes/header.php');

?>


<!-- intro /////////////////////////////////////////////////// -->
<div id='intro'>
	<h1>Graduate Capstone Tracker</h1>

	<p id='who'><span>&bull;&nbsp;</span>Students&nbsp;&nbsp;&nbsp;<span>&bull;&nbsp;</span>Professors&nbsp;&nbsp;&nbsp;<span>&bull;&nbsp;</span>Staff</p>

<?php
	include($path.'includes/login_button.php');
?>


	<!-- icons /////////////////////////////////////////////////// -->
	<div class='icons'>
		<div>
			<p>Projects</p>
			<img src="images/book.png" alt="Projects">
		</div> 
		<div>
			<p>Milestones</p>
			<img src="images/calendar.png" alt="Milestones"></div> 
		<div>
			<p>Approvals</p>
			<img src="images/approve.png" alt="Approvals"></div> 
	</div>

</div><!-- intro end -->


<!-- text / footer /////////////////////////////////////////////////// -->
<div id='intro_text'>
	<p>
		This website is dedicated for students working on their Capstone project. This will allow users to store all information about their capstones online. This allows not only themselves to view
		their project, but also allow professors and faculty to view progress on the Capstones. This conveniently provides students and staff to effectively communicate details about the capstone without wasting time
		setting up meetings between students and staff.
	</p>

	<div class='icons' style="margin-bottom: 5%">
		<div>
			<img src="images/mysql.png" height="50px" width="50px" alt="MySQL">
		</div> 
		<div>
			<img src="images/php.png" height="50px" width="50px" alt="PHP"></div> 
		<div>
			<img src="images/css.png" height="50px" width="50px" alt="CSS">
		</div> 
	</div>

	<br/>

	<span>&copy; 2017 - Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran | <a href='<?php echo $path; ?>pages/user_docs.php'>Documentation</a></span>
	
</div>


<!-- script for modal login button -->
<script type="text/javascript" src="assets/login.js"></script>

</body>
</html>
