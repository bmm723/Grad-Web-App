<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017
//DATA LAYER
class GetData{
	var $dbh;
	
	//logs the user in
	function Login($user, $pw){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		//prepares the login statment
		$login=$dbh->prepare('
							select username, type, uid 
							as uid from people 
							where username=:user and password=:pw;
							');
		$login->bindParam(':user', $user);
		$login->bindParam(':pw', $pw);
		$login->execute();
		
		//is there at least one row found
		$rowCt = $login->rowCount();
		if($rowCt > 0){
			
			while($row = $login->fetchObject()){
				//sets role and pid from results
				$role = $row->type;
				$uid = $row->uid;
				
				//sets session vars
				session_start();
				session_name('Capstone Tracker');
				$_SESSION['login'] = true;
				$_SESSION['username'] = $user;
				$_SESSION['role'] = $role;
				$_SESSION['uid'] = $uid;
				
				return true;
			}
		}
		else{
			return false;
		}
		//closes login statement
		$login->close();
	}
	
	//allows grads to update their project data
	function UpdateProject($pid, $desc){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		//prepares the update statment
		$updateDesc=$dbh->prepare('update project set description = :desc where pid = :pid');
		$updateDesc->bindParam(':desc', $desc);
		$updateDesc->bindParam(':pid', $pid);
		$updateDesc->execute();
		
		//returns new project description
		return $_POST['desc'];
	}
	
	//gets PId from uid
	function getProject($uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		//query to retrieve all project and status data
		$query = "
					select pid
					from people_project
					where uid = ".$uid."
					;";
		$projId = $dbh->query($query);
		
		while($row = $projId->fetchObject()){
			$pid = $row->pid;
			//sets pid in session
			session_start();
			$_SESSION['pid'] = $pid;
		}
	}
	
	//retrieves project and status info for the uid
	function GetProjectData($uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		//query to retrieve all project and status data
		$queryProject = "
					select project.name as project_name, type, project.description as project_desc,
						start_term, expected_end_date, plagiarism_score, max(project_status.last_modified) as last_modified,  
						project_status.comment as status_comment, status.name as status_name, status.description as status_desc
					from people_project
					join project on project.pid = people_project.pid
					join project_status on project_status.pid = project.pid
					join status on status.sid = project_status.sid
					where uid = ".$uid."
					group by project_status.pid; 
					";

		$proj = $dbh->query($queryProject);
		//returns the project data
		return $proj;
	}

	//gets student info from the people database
	function GetStudentData($uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");

		$queryStudent = ("
						select fName, lName, email 
						from people
						where uid = ".$uid.";
						");

        $studentInfo = $dbh->query($queryStudent);
			
		return $studentInfo;

	}

	// get grade
	function GetGrade($uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		$queryGrade = ("
						select p.grade as 'grade', p.turnItIn as 'score' 
						from project p
						join people_project pp 
						on p.pid = pp.pid
						where pp.uid = ".$uid.";
					   ");

        $projectGrade = $dbh->query($queryGrade);
			
		return $projectGrade;
	}
	
	// update grade
	function UpdateGrade($grade, $uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		$updateGrade = $dbh->prepare("
						update project
						set grade = :grade
						where pid = (
							select pid
							from people_project
							where uid = ".$uid.");
					   ");
		$updateGrade->bindParam(':grade', $grade);

        $updateGrade->execute();
	}
	
	// update score
	function UpdateScore($score, $uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		$updateScore = $dbh->prepare("
						update project
						set turnItIn = :score
						where pid = (
							select pid
							from people_project
							where uid = ".$uid.");
					   ");
		$updateScore->bindParam(':score', $score);

        $updateScore->execute();
	}
	
	// update status
	function UpdateStatus($sid, $uid, $comment){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		//check if the status already exists before inserting
		$checkStatus = $dbh->prepare("
						select * 
						from project_status
						where sid = :sid
						and pid = (
							select pid
							from people_project
							where uid = ".$uid.");
					   ");
		$checkStatus->bindParam(':sid', $sid);
		$checkStatus->execute();
		
		$rowCt = $checkStatus->rowCount();
		
		if($rowCt == 0){
			//insert status if it doesnt exist already
			$updateStatus = $dbh->prepare("
							insert into project_status(sid, pid, last_modified, comment)
							values(:sid, (
								select pid
								from people_project
								where uid = ".$uid.")
								, CURDATE(), :comment);
						   ");
			$updateStatus->bindParam(':sid', $sid);
			$updateStatus->bindParam(':comment', $comment);

			$updateStatus->execute();
		}
	}
	
	//Get current status
	function GetCurrentStatus($uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		$queryMaxStatus = ("
							SELECT DISTINCT name  
							FROM status
							WHERE sid = ( 
							    SELECT MAX(s.sid) 
							    FROM status s
								JOIN project_status ps ON s.sid = ps.sid
								JOIN people_project pp ON ps.pid = pp.pid
								WHERE pp.uid = ".$uid.");
						  ");

        $currentStatus = $dbh->query($queryMaxStatus);
			
		return $currentStatus;

	}

	//Get status history
	function GetStatusHistory($uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		$queryHistory = ("
						SELECT s.name as 'status_name', ps.last_modified as 'status_date', ps.comment as 'comment'
						FROM status s
						JOIN project_status ps ON s.sid = ps.sid
						JOIN people_project pp ON ps.pid = pp.pid
						WHERE pp.uid = ".$uid."
						");
        $statusHistory = $dbh->query($queryHistory);
        $history_data = $statusHistory->fetchAll(PDO::FETCH_ASSOC);
			
		return $history_data;

	}
	
	//Adds professors to the project in the specified role
	function AddProfessor($name_type, $prof_uid, $uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		//starts transaction
		$dbh->beginTransaction();
		
		$addProfs = $dbh->prepare(" 	
						UPDATE project p
						SET ".$name_type." = (
						SELECT CONCAT(fname,' ',lname) AS prof_name
						FROM people 
						WHERE people.uid = '".$prof_uid."') 
						WHERE p.pid = (
						SELECT pp.pid
						FROM people_project pp
						WHERE pp.uid = '".$uid."');
					 ");

		$addProfs->execute();
		
		//statement to update people_project table with new professors
		$newRole = "";
		
		//makes sure the role is properly set
		if($name_type == "reader1" || $name_type == "reader2" || $name_type == "chair"){
			//sets role according to name_type
			if($name_type == "reader1"){
				$newRole = "Reader 1";
			}
			if($name_type == "reader2"){
				$newRole = "Reader 2";
			}
			if($name_type == "chair"){
				$newRole = "Chair";
			}
			
			//gets the pid for the student
			$queryPid = " 	
					SELECT pp.pid
					FROM people_project pp
					WHERE pp.uid = ".$uid.";
				 ";

			$projs = $dbh->query($queryPid);
			$projPid = $projs->fetchAll(PDO::FETCH_ASSOC);	
			
			//set the newly assigned professor in their new role
			foreach($projPid as $row) {
				$pid = $row['pid'];
				
				$removeOldProf = $dbh->prepare("
								delete from people_project
								where pid = ".$pid."
								and role = '".$newRole."';
							");
				$removeOldProf->execute();
				
				$addProfsPP = $dbh->prepare("
								Insert into people_project (uid, pid, role) 
								values (".$prof_uid.", ".$pid.", '".$newRole."');
							");
							
				$addProfsPP->execute();
			}
			
		}
		//commit to db
		$dbh->commit();
	}
	
	//Retrieves professors working on the specified project
	function GetProjectProfessors($username){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");

        $queryName = "     
                        SELECT chair, reader1, reader2 
						FROM project 
						WHERE pid = (
						SELECT pp.pid 
						FROM people_project pp 
						JOIN people p on pp.uid = p.uid 
						WHERE p.username = '".$username."');
                     ";

        $profname = $dbh->query($queryName);
	
        $prof_array = $profname->fetchAll(PDO::FETCH_ASSOC);
		
		return $prof_array;
	}
	
	//retrieves all projects the professor is added on
	function GetProfessorProjects($uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		$projectArray = array("");
		
		//query to retrieve pid for professor
		$queryProjs = " 	
						SELECT pid, role
						from people_project
						WHERE uid = ".$uid.";
					 ";

		$projs = $dbh->query($queryProjs);
		$projPid = $projs->fetchAll(PDO::FETCH_ASSOC);	
		
		//Array index
		$i = 0;
		
		foreach($projPid as $row) {
			$pid = $row['pid'];
			$role = $row['role'];
			
			//query to retrieve project data
			$queryProfProjs = " 	
							SELECT  fName, lName, name, pp.uid as 'project_id', p.username as 'student'
							from people_project pp
							join people p on pp.uid = p.uid
							join project pr on pp.pid = pr.pid
							WHERE pp.pid = ".$pid."
							and role = 'Grad';
						 ";

			$profProjs = $dbh->query($queryProfProjs);
			$project = $profProjs->fetchAll(PDO::FETCH_ASSOC);	
			$projectArray[$i] = $project;
			$i++;
			$projectArray[$i] = $role;
			$i++;
		}
		
					
		//returns all rows from professor data
		return $projectArray;
	}

	//Get ALL projects - for a staff member
	function GetAllProjects(){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		$queryAllProjects = ("
								SELECT pe.lname AS 'lname', pe.fname AS 'fname', 
								       pr.name AS 'topic', pr.chair AS 'chair',
									   pe.uid AS 'project_id', pe.username as 'student',
									   ps.last_modified AS 'status_date',
								       s.name AS 'status_name'
								FROM people pe
								JOIN people_project pp ON pe.uid = pp.uid
								JOIN project pr ON pp.pid = pr.pid
								JOIN project_status ps ON ps.pid = pr.pid
								INNER JOIN status s ON ps.sid = s.sid
								WHERE pe.type = 'Grad' 
								AND (ps.pid, ps.sid) IN (
									SELECT ps.pid, MAX(ps.sid)
									FROM project_status ps
									GROUP BY ps.pid)
								AND s.sid IN (
									SELECT MAX(ps.sid)
									FROM project_status ps
									GROUP BY ps.pid
									ORDER BY ps.pid)
								ORDER BY 'project_id'
						   ");
		
        $allProjects = $dbh->query($queryAllProjects);
        $project_data = $allProjects->fetchAll(PDO::FETCH_ASSOC);
			
		return $project_data;
	
	}

	
	//retrieves all professor data
	function GetProfessorData(){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		//query to retrieve professor data
		$queryProfs = " 	
						SELECT lName, fName, email, phone, officelocation, uid, username
						FROM people 
						WHERE type = 'Faculty'; 
					 ";

		$profs = $dbh->query($queryProfs);
		$array = $profs->fetchAll(PDO::FETCH_ASSOC);	
		//returns all rows from professor data
		return $array;
	}
	
	//checks the professors role on the specified user's project
	function GetProfessorRole($student_uid, $prof_uid){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		$role = '';
		
		//query to retrieve pid for professor
		$queryProjs = " 	
						SELECT pid
						from people_project
						WHERE uid = ".$student_uid.";
					 ";

		$projPid = $dbh->query($queryProjs);
		
		while($row = $projPid->fetchObject() ) {
			$pid = $row->pid;
			
			//query to retrieve project data
			$queryProfRole = " 	
							SELECT role
							from people_project pp
							WHERE pid = ".$pid."
							and uid = ".$prof_uid.";
						 ";

			$profRole = $dbh->query($queryProfRole);
			
			while($roleRow = $profRole->fetchObject() ) {
				$role = $roleRow->role;
			}
		}
		return $role;
	}
	
	//gets all statuses for staff to change on proj details page
	function getStatuses(){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
		
		$statusQuery = "select name, sid
						from status;";
		
		$status = $dbh->query($statusQuery);
		$statuses = $status->fetchAll(PDO::FETCH_ASSOC);	
		
		return $statuses;
	}
 
 	//allows grads to update their project data
	function CreateStudent($username, $student_pass, $student_email, $student_fname, $student_lname, $pname, $ptype, $desc, $term, $end_date){
		//include DB connection
		require(__DIR__."/../../../330_conn.php");
    //generate project ID
    $id = rand();
    
    //starts transaction
    $dbh->beginTransaction();
      
		//prepares the Person insert statment
			$addPerson=$dbh->prepare("
				  INSERT INTO people(uid, type, username, password, email, fname, lname) 
				  VALUES('".$id."','Grad',:username, :student_pass, :student_email, :student_fname, :student_lname);");
      $addPerson->bindParam(':username', $username);
      $addPerson->bindParam(':student_pass', $student_pass);
      $addPerson->bindParam(':student_email', $student_email);
      $addPerson->bindParam(':student_fname', $student_fname);
      $addPerson->bindParam(':student_lname', $student_lname);
			$addPerson->execute();
      
      //prepares the Project insert statment
			$addProject=$dbh->prepare("
				  INSERT INTO project(pid, name, description, type, start_term, expected_end_date)
				  VALUES('".$id."', :pname, :desc, :ptype, :term, :date);");
      $addProject->bindParam(':pname', $pname);
      $addProject->bindParam(':desc', $desc);
      $addProject->bindParam(':ptype', $ptype);
      $addProject->bindParam(':term', $term);
      $addProject->bindParam(':date', $end_date);
			$addProject->execute();
   
      //new people_project
      $addPeopleProject=$dbh->prepare("
          INSERT INTO people_project(uid, pid, role)
          VALUES(".$id.",".$id.",'Grad');");
      $addPeopleProject->execute();
      
      // insert project data into project_status
			$addProject_status=$dbh->prepare("
										INSERT INTO project_status (sid, pid, last_modified, comment) 
										VALUES ('100', '".$id."', CURDATE(), NULL);
									 ");
			$addProject_status->execute();
      
      //end transaction
      $dbh->commit();
	}

	// allows grad students to delete current project and create a new one
	function DeleteAndAddProject($uid, $proj_name, $term, $end_date, $proj_type, $proj_dec) {
		//include DB connection
		require(__DIR__."/../../../330_conn.php");

		//starts transaction
		$dbh->beginTransaction();

			// delete project info from project
			$delProject=$dbh->prepare("
										DELETE FROM project
										WHERE pid = ".$uid.";
									 ");
			$delProject->execute();

			// delete project info from people_project
			$delPeople_project=$dbh->prepare("
										DELETE FROM people_project
										WHERE uid = ".$uid.";
									 ");
			$delPeople_project->execute();

			// delete project info from project_status
			$delProject_status=$dbh->prepare("
										DELETE FROM project_status
										WHERE pid = ".$uid.";
									 ");
			$delProject_status->execute();

			// insert new project data into project
			$insertNewProject=$dbh->prepare("
										INSERT INTO project (pid, type, name, description, start_term, expected_end_date, plagiarism_score, chair, reader1, reader2, grade, turnItIn) 
										VALUES ('".$uid."', '".$proj_type."', :pName, :PDesc, '".$term."', '".$end_date."', '-1', NULL, NULL, NULL, NULL, NULL);
									 ");

				$insertNewProject->bindParam(':pName', $proj_name);
				$insertNewProject->bindParam(':PDesc', $proj_dec);
			$insertNewProject->execute();

			// insert new project data into people_project
			$insertNewPeople_project=$dbh->prepare("
										INSERT INTO people_project (uid, pid, role) 
										VALUES ('".$uid."', '".$uid."', 'Grad');
									 ");
			$insertNewPeople_project->execute();

			// insert new project data into project_status
			$insertNewProject_status=$dbh->prepare("
										INSERT INTO project_status (sid, pid, last_modified, comment) 
										VALUES ('100', '".$uid."', CURDATE(), NULL);
									 ");
			$insertNewProject_status->execute();

		$dbh->commit();

	}

}


?>