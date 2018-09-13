<?php	
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

	require_once("../includes/page_config.php");
	
	$path = "../";

	$title = "RIT Graduate Capstone Tracker: Create New Project";
	$menu = "no";
	$username = $roleCheck->getUser();
	$table = "no";
	$role = $_SESSION['role'];
	$project_uid = $_GET["project_id"];
	$project_uname = $_GET["project_user"];
	$uid = $_SESSION['uid'];


	//checks to see if the user is logged in, returns them to index.php if not 
	if(!$roleCheck->CheckForLogin()){
		header("Location:".$path."index.php");
	}
	
	// include header
	include($path.'includes/header.php');
?>


<!-- identifier -->
<div class='identifier'>
	<p>Logged in as: <b><?php echo $username; ?></b></p>
	<p style="color: #f26d23"><b><?php echo $role; ?></b></p>
</div>

<!-- cancel -->
<div class='cancel'>
	<a href="user_page.php">Cancel</a>
</div>

<div id="user_content">
<h1>New Capstone Project</h1>
<!-- new user register form -->
	<form id="reg_form" action="create_proj.php" method="post" onsubmit="return validate();">
		<div id="form_labels">

			<!-- project details labels -->
			Project Name:<br/>
			Start Term:<br/>
			Expected End Date:<br/>
			Project Type:<br/><br/>
			Project Description:<br/>
		</div>									
									

		<div id="form_inputs">	

			<!-- project details inputs -->
			<input type="text" name="pname" id="pname"><br/>
			<select name="term" style='margin-bottom: 7px;'>
			  <option value="2161">2161</option>
			  <option value="2165">2165</option>
			  <option value="2171">2171</option>
			  <option value="2175">2175</option>
			  <option value="2181">2181</option>
			  <option value="2185">2185</option>
			</select><br/>
			<input type="date" name="date" id="date"><br/>
				<input type="radio" name="ptype" value="Thesis" checked="true">Thesis<br/>
				<input type="radio" name="ptype" value="Project" checked="false">Project<br/>
			<textarea type="textarea" name="desc" id="desc"></textarea><br/>
		</div>


			<!-- submit button -->	
			<input id="reg_sub" type="submit" value="Delete and Replace Project?">
	</form>
</div>

<script>
	// make sure all fields are full before submitting
	function validate() {
		if( document.getElementById('pname').value == '' || document.getElementById('date').value == '' || document.getElementById('desc').value == '' ) {
			return false;
		}
		else {
			return true;
		}
	}
</script>


<!-- include footer -->
<?php
	include($path.'includes/footer.php');
?>