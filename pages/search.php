<?php
// Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017

	//includes the page config
	require_once("../includes/page_config.php");
	
	$path = "../";
	
	//checks to see if the user is logged in, returns them to index.php if not 
	if(!$roleCheck->CheckForLogin()){
		header("Location:".$path."index.php");
	}
	
	$role = $_SESSION['role'];
	$title = "RIT Graduate Capstone Tracker: Search Page" ;
	$menu = "no";
	$username = $roleCheck->getUser();
	$table = "yes";


	include($path.'includes/header.php');
	
	$add_name = "";
	$add_to_db = "";

	if ($_GET["add"] == "chair") {
		$add_name = "Chair";
		$add_to_db = "chair";
	}
	else if  ($_GET["add"] == "r1") {
		$add_name = "Reader 1";
		$add_to_db = "reader1";
	}
	else if  ($_GET["add"] == "r2") {
		$add_name = "Reader 2";
		$add_to_db = "reader2";
	}
?>

<!-- cancel -->
<div class='cancel'>
	<a href="user_page.php">Cancel</a>
</div>

<!-- identifier -->
<div class='identifier'>
	<p>Searching for:</b></p>
	<p style="color: #f26d23"><b><?php echo $add_name ?></b></p>
</div>


<!-- Student Content -->
<?php
if ($roleCheck->isGrad()) { ?>

<div id="user_content">

	<h1>Professor Search</h1>


</div>

<div id="table_holder">
	<table id="myTable" class="display" cellspacing="0" width="100%">
		<thead>
		  <tr>
		    <th >Last Name</th>
		    <th >First Name</th>
		    <th >Email</th>
		    <th >Phone</th>
		    <th >Office</th>
		    <th >Picture</th>
		    <th >Add to Project</th>
		  </tr>
		</thead>
		<tbody>
	<?php
		//gets all of the professors from the db
		$array = $getData->GetProfessorData();
		
		//loads the professor data into a table
	    foreach($array as $row) {
	        echo ("<tr><td>"
	        	.$row['lName']
	        	."</td><td>"
	        	.$row['fName']
	        	."</td><td>"
	        	.$row['email']
	        	."</td><td>"
	        	.$row['phone']
	        	."</td><td>"
	        	.$row['officelocation']
 	        	."</td>
 	        	<td><img class='prof_pic' src='../images/prof_pics/".$row['username'].".jpg' onError='showPic(this);'/></td>
 	        	<td class='add'><a id=".$row['uid']." href='javascript:void(0);' onClick='addName(this);'>ADD</a></td></tr>");
	    }

	?>

		</tbody>
	</table>
</div>

<?php } ?>



<!-- Proffesor Content -->
<?php
if ($roleCheck->isFaculty()) { ?>

<div id="user_content">

	<h1>Faculty Page</h1>

</div>

<?php } ?>

<!-- Staff Content -->
<?php
if ($roleCheck->isStaff()) { ?>

<div id="user_content">

	<h1>Staff Page</h1>

</div>

<?php } ?>

<script>

// use AJAX to send post data to user_page to update the database
function addName(obj) {
	
	var prof = obj.id;

	var type = "<?php echo $add_to_db ?>";

	$.ajax({
		type: "POST",
		url: "user_page.php",
		data: { prof_uid: prof, add_name: type },
		success:function() {
			location.href=("user_page.php");
		}
	});


}

// function to show default pic if no prof pic available
function showPic(obj) {
	obj.src='../images/prof_pics/default.jpg';
}

</script>

</body>
</html>



