<?php	
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

	require_once("../includes/page_config.php");
	
	$path = "../";

	$title = "RIT Graduate Capstone Tracker: Project Details";
	$menu = "yes";
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
	
	//if the grade was set to be updated, update the grade in the DB
	if(isset($_POST['grade'])){
		$getData->UpdateGrade($_POST['grade'], $project_uid);
	}
	
	//if the score was set to be updated, update the score in the DB
	if(isset($_POST['score'])){
		$getData->UpdateScore($_POST['score'], $project_uid);
	}
	
	//if the status was set to be updated, update the status in the DB
	if(isset($_POST['status'])){
		$getData->UpdateStatus($_POST['status'], $project_uid, $_POST['statusComment']);
	}

	// include header
	include($path.'includes/header.php');


	//retrieves all project and status data -----------------
	$proj = $getData->GetProjectData($project_uid);

	//loads project and status data into variables
	while($row = $proj->fetchObject()){
		$project_name = $row->project_name;
		$project_desc = $row->project_desc;
		$project_type = $row->type;
		$term = $row->start_term;
		$end_date = $row->expected_end_date;
		$plagiarism = $row->plagiarism_score;
		$comment = $row->status_comment;
		$last_modified = $row->last_modified;
		$status_desc = $row->status_desc;
	}

	// get student name, email ------------------------------
	$stud = $getData->GetStudentData($project_uid);
	
	//load student name, email into variables
	while($row = $stud->fetchObject()){
		$stu_fname = $row->fName;
		$stu_lname = $row->lName;
		$stu_email = $row->email;
	}


	// get project grade ------------------------------------
	$the_grade = $getData->GetGrade($project_uid);

	//load grade into variable
	while($row = $the_grade->fetchObject()){
		$grade = $row->grade;
		$turnItIn = $row->score;
	}


	// GetCurrentStatus -------------------------------------
	$the_status = $getData->GetCurrentStatus($project_uid);

	//load grade into variable
	while($row = $the_status->fetchObject()){
		$cur_stat = $row->name;
	}
	
	// GetStatusHistory -------------------------------------
		$the_history = $getData->GetStatusHistory($project_uid);	
		foreach($the_history as $row) {
			$statusComment = $row['comment'];
		}


?>


<!-- identifier -->
<div class='identifier'>
	<p>Logged in as: <b><?php echo $username; ?></b></p>
	<p style="color: #f26d23"><b><?php echo $role; ?></b></p>
</div>



<!-- include slideout_menu -->
<?php
	include($path.'includes/slideout_menu.php');
?>

<!-- cancel -->
<style>.cancel{left:auto;right:200px;top:70px;}</style>
<div class='cancel'>
	<a href="user_page.php">Back</a>
</div>


<div id="user_content">


	<h1><?php echo $project_name; ?></h1>

	<br/>

	<!-- student info -->
	<p><b>Student Name: </b><?php echo $stu_fname." ".$stu_lname; ?></p>
	<p><b>Student Email: </b><?php echo $stu_email; ?></p>

	<br/>

	<!-- project info -->
	<p><b>Description:</b></p>
	<p><?php echo $project_desc; ?></p>

	<br/>
	<span><b>Start Term: </b><?php echo $term; ?></span> 
	<span><b>End Date: </b><?php echo $end_date; ?></span>
	<br/><br/>
	<?php
	//if the user is a staff member allow them to change statuses
	if($roleCheck->isStaff()){
		echo("<form action='' method='post'>");
		echo("<p><b>Current Status: </b><select name='status' onchange='clearComment()'>");
		
		$statuses = $getData->getStatuses($project_uid);
		foreach($statuses as $status){
			if($status['name'] == $cur_stat){
				echo("<option value='".$status['sid']."' selected='selected'>".$status['name']."</option>");
			}else{
				echo("<option value='".$status['sid']."'>".$status['name']."</option>");
			}
		}
		echo("</select></p>");
		echo("<p><b>Status Comment: </b></p><p><textarea id='statusComment' type='textarea' name='statusComment'>".$statusComment."</textarea>");
		echo("<br/><input id='updateStatus' type='submit' value='Update Status'></form></p><br/>");
	}
	else{
		echo("<p><b>Current Status: </b>".$cur_stat."</p><br/>");
	}
	?>

	<!-- grade check -->
	<?php
		//gets the faculty's role on the project
		$profRole = $getData->GetProfessorRole($project_uid, $uid);
		
		//if the faculty member is a chair on the project, allow grade changing
		if($profRole == "Chair" ){
			echo("<form action='' method='post'>");
			if ( (string)$grade == "" ) { 
				echo("<p><b>Grade: </b><input id='gradeInputNoValue' type='text' name='grade' value='Not Set'></input>");
			}
			else {
				echo("<p><b>Grade: </b><input id='gradeInput' type='text' name='grade' value=".$grade.">%</input>");
			} 
			echo("<input id='gradeSubmit' type='submit' value='Update Grade'></form></p>");
		} else {
			//if not chair, just display the grade
			if ( (string)$grade == "" ) { 
				echo("<p><b>Grade: </b>Not Set</p>");
			}
			else {
				echo("<p><b>Grade: </b>".$grade."%</p>");
			} 
		}
		
		//turnItIn.com score
		if($roleCheck->isStaff()){
			echo("<form action='' method='post'>");
			if ( (string)$turnItIn == "" ) { 
				echo("<p><b>TurnItIn.com Score: </b><input id='gradeInputNoValue' type='text' name='score' value='Not Set'></input>");
			}
			else {
				echo("<p><b>TurnItIn.com Score: </b><input id='gradeInput' type='text' name='score' value=".$turnItIn.">%</input>");
			} 
			echo("<input id='gradeSubmit' type='submit' value='Update Score'></form></p>");
		}
		else{
			echo("<p><b>TurnItIn.com Score: </b>".$turnItIn."%</p>");
		}
	?>
	<br/>
	<hr/>
	<br/>
	<!-- status history -->
	<p><b>Status History:</b></p>

	<table id='hist_table'>
		<tr>
			<th>Status</th>
			<th>Date</th>
			<th>Comment</th>
		</tr>
	<?php 
		// GetStatusHistory -------------------------------------
		$the_history = $getData->GetStatusHistory($project_uid);	
		foreach($the_history as $row) {
			echo("<tr><td>".$row['status_name'].
				 "</td><td>".$row['status_date'].
				 "</td><td>".$row['comment'].
				 "</td></tr>");
		}
	?>
	</table>
</div>
<script>
	function clearComment(){
		$('#statusComment').val("");
	}
</script>


<!-- include footer -->
<?php
	include($path.'includes/footer.php');
?>