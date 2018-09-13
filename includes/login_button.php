
	<!-- login button  /////////////////////////////////////////// -->
	<div id='login'>Login</div>

	<!-- The Modal -->
	<div id="myModal" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
	    <div class="modal-header">
	      <span class="close">&times;</span>
	      <h2>Please enter Username and Password</h2>
	    </div>
	    <div class="modal-body">
			<form method="post" action="pages/login.php">
			  <!-- Username:<br> -->
			  <input class="text_field" type="text" name="username" placeholder="username">
			  <br>
			  <!-- Password:<br> -->
			  <input class="text_field" type="password" name="password" placeholder="password">
			  <br><br>
			  <input id="submit_login" type="submit" value="Login">
			</form> 
	    </div>
	    <div class="modal-footer">
	      <h3>New User? <a href="pages/register.php">Register Here</a></h3>
	    </div>
	  </div>

	</div>