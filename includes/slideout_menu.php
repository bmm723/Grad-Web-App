<!-- slide out menu -->
<!-- // Group 10: Graduate Capstone Project
// authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
// date: RIT Fall Semester 2017 -->
<nav>
    <div class="menu-btn">
        <a href="javascript:void(0);">+</a>
    </div>
    
<?php
if ($roleCheck->isGrad()) { 
	
	//Gets the professors working with the student on the project
	$prof_array = $getData->GetProjectProfessors($username);
	
	foreach($prof_array as $row) {
		$chair_n = $row['chair'];
		$reader1_n = $row['reader1'];
		$reader2_n = $row['reader2'];
	}
?>

    <ul>
        
        <li id="p_deets">Project Details</li>

        <li class="nav_h">Chair:</li>

        <?php if ($chair_n == "") { ?>
            <li><a href="../pages/search.php?add=chair">Search</a></li>
        <?php }
        else { ?>
            <li><a href="../pages/search.php?add=chair"><?php echo $chair_n ?></a></li>    
        <?php } ?>

        <hr/>

        <li class="nav_h">Reader 1:</li>

        <?php if ($reader1_n == "") { ?>
            <li><a href="../pages/search.php?add=r1">Search</a></li>
        <?php }
        else { ?>
            <li><a href="../pages/search.php?add=r1"><?php echo $reader1_n ?></a></li>    
        <?php } ?>

        <hr/>

        <li class="nav_h">Reader 2:</li>

        <?php if ($reader2_n == "") { ?>
            <li><a href="../pages/search.php?add=r2">Search</a></li>
        <?php }
        else { ?>
            <li><a href="../pages/search.php?add=r2"><?php echo $reader2_n ?></a></li>    
        <?php } ?> 

    </ul>

<?php } ?>

<?php
if ( $roleCheck->isFaculty() or $roleCheck->isStaff() ) { 

    //Gets the professors working with the student on the project - NEED TO PASS IN USER NAME of SELECTED PROJECT!!!!
    $prof_array = $getData->GetProjectProfessors($project_uname);
    
    foreach($prof_array as $row) {
        $chair_n = $row['chair'];
        $reader1_n = $row['reader1'];
        $reader2_n = $row['reader2'];
    }


?>

    <ul>
    	<li id="p_deets">Project Details</li>

        <li class="nav_h">Chair:</li>
        <?php if ($chair_n == "") { ?>
            <li><a href="javascript:void(0);">Not Set</a></li>
        <?php }
        else { ?>
            <li><a href="javascript:void(0);"><?php echo $chair_n ?></a></li>    
        <?php } ?>

        <hr/>

        <li class="nav_h">Reader 1:</li>
        <?php if ($reader1_n == "") { ?>
            <li><a href="javascript:void(0);">Not Set</a></li>
        <?php }
        else { ?>
            <li><a href="javascript:void(0);"><?php echo $reader1_n ?></a></li>    
        <?php } ?>

        <hr/>

        <li class="nav_h">Reader 2:</li>
        <?php if ($reader2_n == "") { ?>
            <li><a href="javascript:void(0);">Not Set</a></li>
        <?php }
        else { ?>
            <li><a href="javascript:void(0);"><?php echo $reader2_n ?></a></li>    
        <?php } ?>

    </ul>

<?php } ?>


</nav>