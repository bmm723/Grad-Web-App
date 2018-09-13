<!doctype html>

<!--
Group 10: Graduate Capstone Project
authors: Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran
date: RIT Fall Semester 2017
page: <?php echo $title; ?>
-->

<html lang="en">
<head>
  <meta charset="utf-8">

  <title><?php echo $title; ?></title>
  <meta name="Capstone Tracker Project" content="RIT Graduate Capstone Tracker">
  <meta name="Group - 10" content="DB-330">

  <!-- main css styles -->
  <link rel="stylesheet" href="<?php echo $path; ?>assets/style.css">

  <!-- favicon -->
  <link rel='shortcut icon' type='image/x-icon' href='<?php echo $path; ?>images/favicon.ico' />

  <!-- jquery link -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/jquery-3.2.1.js"></script>

  <!-- if the page uses the slide out menu -->
  <?php 
    if ($menu == "yes") {
      echo "<!-- slide out css link -->";
      echo '<link rel="stylesheet" href="'.$path.'assets/slide.css">';
    }
  ?>

  <!-- if the page uses data tables -->
  <?php 
    if ($table == "yes") {
      echo '<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"/>';
      echo '<script type="text/javascript" src="'.$path.'assets/dataTables.min.js"></script>';
  ?>
      <script>
        $(document).ready(function(){
            $('#myTable').DataTable( {
              "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
          } );
      } );
      </script>
  <?php     
    }
  ?>


  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->

  

</head>

<body>
<!-- banner /////////////////////////////////////////////////// -->
<div id='banner'>
	<img id="logo" src="<?php echo $path; ?>images/rit_logo_white.png" alt="RIT Logo">
	<img src="<?php echo $path; ?>images/rochester_it.png" alt="Rochester Institute of Technology"> 

	<?php
		//if a user is logged in, display logout button
		session_start();
		if(($_SESSION['login'])){
			echo '<a id="logout" href="'.$path.'pages/logout.php">Logout</a>';
		}
	?>
</div>