<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

	//includes the page config
	require_once("../includes/page_config.php");
	//include DB connection
	require(__DIR__."/../../../330_conn.php");
	
	$path = "../";
	
	//checks to see if the user is logged in, returns them to index.php if not 
	if(!$roleCheck->CheckForLogin()){
		header("Location:".$path."index.php");
	}
	
	session_start();
	$role = $_SESSION['role'];
	$uid = $_SESSION['uid'];
	
	//if user is a student, get their project id
	if($roleCheck->isGrad()){
		$getData->getProject($uid);
		$pid = $_SESSION['pid'];
	}
	
	$title = "RIT Graduate Capstone Tracker: ".$role." Page" ;
	$menu = "yes";
	$username = $roleCheck->getUser();
	$project_name = "Project Name";
	$project_desc = "Project description";
	$project_type = "Thesis/Project";
	$table = "no";
	$term = "0000";
	$end_date = "00/00/0000";
	$plagiarism = "Plagarism score";
	$comment = "Status comment";
	$last_modified = "00/00/0000";
	$status = "Project status";
	$status_desc = "Status description";
	$uid = $_SESSION['uid'];

	// if the user selects a name from the professor list, update the database
	if ( isset($_POST['prof_uid']) ) {
		$name_type = $_POST['add_name'];
		$prof_uid = $_POST['prof_uid'];
		$getData->AddProfessor($name_type, $prof_uid, $uid);
	}

	// GetCurrentStatus -------------------------------------
	$the_status = $getData->GetCurrentStatus($uid);

	//load grade into variable
	while($row = $the_status->fetchObject()){
		$cur_stat = $row->name;
	}
?>





<!-- Student Content -->
<?php
if ($roleCheck->isGrad()) { 
	require($path.'../../330_conn.php');
	include($path.'includes/header.php');
	include($path.'includes/slideout_menu.php');
	?>
	<!-- identifier -->
	<div class='identifier'>
		<p>Logged in as: <b><?php echo $username; ?></b></p>
		<p style="color: #f26d23"><b><?php echo $role; ?></b></p>
	</div>


	<?php
	
	// if user submitted a changes
	if(isset($_POST['desc'])){
		$project_desc = $getData->UpdateProject($pid, $_POST['desc']);
	}
	
	//retrieves all project and status data
	$proj = $getData->GetProjectData($_SESSION['uid']);

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
		$status = $row->status_name;
		$status_desc = $row->status_desc;
	}

	// get project grade ------------------------------------
	$the_grade = $getData->GetGrade($uid);

	//load grade into variable
	while($row = $the_grade->fetchObject()){
		$grade = $row->grade;
		$turnItIn = $row->score;
	}

		
?>

<div id="user_content">

	<h1><?php echo $project_name; ?></h1>
	<p><b>Status: </b><?php echo $cur_stat; ?></p>
	<br/>
	<p><b>Description:</b></p>
	<form id="edit_desc" action="user_page.php" method="post">
		<textarea type="textarea" name="desc"><?php echo $project_desc; ?></textarea>
		<br/>
		<input type="submit" value="Submit Changes">
	</form>
	<br/>
	<span><b>Start Term: </b><?php echo $term; ?></span> 
	<span><b>End Date: </b><?php echo $end_date; ?></span>
	<br/>

	<?php
	if ( (string)$grade == "" ) { 
		echo("<p><b>Grade: </b>Not Set</p>");
	}
	else {
		echo("<p><b>Grade: </b>".$grade."%</p>");
	} 
	?>

	<br/>

	<!-- delete project option -->
	<a href='javascript:void(0)' onClick='deleteSelect();' class='del_no'>Delete Project</a> 
	<div id='delete_div' style='display: none'>
		<a href='javascript:void(0)' onClick='deleteProject(this);' id='del_yes' class='del_yes'>YES</a> 
		<a href='javascript:void(0)' onClick='deleteProject(this);' id='del_no' class='del_no'>NO</a> 
	</div>

</div>

<?php } ?>



<!-- Proffesor Content -->
<?php
if ($roleCheck->isFaculty()) {
	$table = "yes";
	include($path.'includes/header.php');
	?>
	<!-- identifier -->
	<div class='identifier'>
		<p>Logged in as: <b><?php echo $username; ?></b></p>
		<p style="color: #f26d23"><b><?php echo $role; ?></b></p>
	</div>

	<!-- css override for faculty/staff user_content -->
	<style>#user_content{margin-left: auto; margin-right: auto;}</style>

	<div id="user_content">

	<h1>Your Graduate Projects</h1>
	<br/>
	<div id="table_holder">
		<table id="myTable" class="display" cellspacing="0" width="100%">
			<thead>
			  <tr>
			  	<th>Select Project</th>
				<th>Last Name</th>
				<th>First Name</th>
				<th>Topic</th>
				<th>Your Role</th>
			  </tr>
			</thead>
			<tbody>
		<?php
			//gets all the projects the professor is added on
			$projectArray = $getData->GetProfessorProjects($uid);
			
			//loads the professor data into a table
			foreach($projectArray as $project) {
				if($project == "Reader 1" || $project == "Reader 2" || $project == "Chair"){
					echo($project."</td></tr>");
				}
				else{

					echo ("<tr><td class='add'><a id='".$project[0]['project_id']."' class='".$project[0]['student']."' href='javascript:void(0);' onClick='selectProject(this);'>SELECT</a></td><td>"
						.$project[0]['lName']
						."</td><td>"
						.$project[0]['fName']
						."</td><td>"
						.$project[0]['name']
						."</td><td>"
						);
				}
			}

		?>

			</tbody>
		</table>
	</div>
	
</div>


<?php } ?>



<!-- Staff Content -->
<?php
if ($roleCheck->isStaff()) { 
	$table = "yes";
	include($path.'includes/header.php'); 
	?>
	<!-- identifier -->
	<div class='identifier'>
		<p>Logged in as: <b><?php echo $username; ?></b></p>
		<p style="color: #f26d23"><b><?php echo $role; ?></b></p>
	</div>

	<!-- css override for faculty/staff user_content -->
	<style>#user_content{margin-left: auto; margin-right: auto; width: 85%}</style>

	<div id="user_content">

	<h1>All Graduate Projects</h1>
	<br/>
		<div id="table_holder">
			<table id="myTable" class="display" cellspacing="0" width="100%">
				<thead>
				  <tr>
				  	<th>Select Project</th>
					<th>Last Name</th>
					<th>First Name</th>
					<th>Topic</th>
					<th>Chair</th>
					<th>Current Status</th>
					<th>Status Date</th>
				  </tr>
				</thead>
				<tbody>

			<?php
				//gets all the projects in the database
				$allProjects = $getData->GetAllProjects();

				//loads the project data into a table
				foreach($allProjects as $row) {
						echo ("<tr><td class='add'><a id='".$row['project_id']."' class='".$row['student']."' href='javascript:void(0);' onClick='selectProject(this);'>SELECT</a></td><td>"
							.$row['lname']
							."</td><td>"
							.$row['fname']
							."</td><td>"
							.$row['topic']
							."</td><td>"
							.$row['chair']
							."</td><td>"
							.$row['status_name']
							."</td><td>"
							.$row['status_date']
							."</td></tr>"
							);
				}
			?>

				</tbody>
			</table>

		</div>
	</div>

<?php } ?>



<script>

	function selectProject(obj) {

		var pid = obj.id;
		var user = obj.className;

			location.href=('project_details.php?project_id='+pid+'&project_user='+user);
		
	}

	// functions to delete a student project-----
	// this shows 
	function deleteSelect() {

		$('#delete_div').css('display','block');
	}

	// if user selects YES, the project will be delete and they will be taken a page to create a new project
	function deleteProject(obj) {

		if (obj.id == "del_yes") {

			location.href=('new_project.php');	
		}
		else {
			$('#delete_div').css('display','none');
		}

	}

</script>


<!-- include footer -->
<?php
	include($path.'includes/footer.php');
?>

