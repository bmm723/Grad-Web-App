<?php
  // Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

	$title = "RIT Graduate Capstone Tracker - New User Register";
	$path = "../";
	$menu = "no";
	$table = "no";

	include($path.'includes/header.php');

?>

<div id="user_content">
<h1>Grad Student Registration</h1>
<!-- new user register form -->
	<form id="reg_form" action="success.php" method="post" onsubmit="return validate();">
		<div id="form_labels">
			<!-- user details labels -->
			*RIT User Name:<br/>
			*Password:<br/>
			*Re-Enter Password:<br/>
			*Email:<br/>
			*First Name:<br/>
			*Last Name:<br/>
			<!-- project details labels -->
			*Project Name:<br/>
			Start Term:<br/>
			*Expected End Date:<br/>
			Project Type:<br/><br/>
			*Project Description:<br/>
		</div>									
									

		<div id="form_inputs">	
			<!-- user details inputs-->						
			<input type="text" name="username" id='uname'><br/>
			<input type="password" name="password" id='p1'><br/>
			<input type="password" name="validate_pw" id='p2'><br/>
			<input type="text" name="email" id='email'><br/>
			<input type="text" name="fname" id='fname'><br/>
			<input type="text" name="lname" id='lname'><br/>
			<!-- project details inputs -->
			<input type="text" name="pname"><br/>
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
			<input id="reg_sub" type="submit" value="Submit">
	</form>


</div>

<script>
	// make sure all fields are full before submitting
	function validate() {
		if( document.getElementById('p1').value !== document.getElementById('p2').value || document.getElementById('lname').value == '' || document.getElementById('fname').value == '' || document.getElementById('email').value == '' || document.getElementById('uname').value == '' || document.getElementById('p1').value == '' || document.getElementById('p2').value == '' || document.getElementById('pname').value == '' || document.getElementById('date').value == '' || document.getElementById('desc').value == '' ) {
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