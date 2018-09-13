<!-- footer -->
<div id="footer">
	<span>&copy; 2017 - Kevin Reynolds, Daniel Eden, Brie McIntosh, Roy Tran | <a href='<?php echo $path; ?>pages/user_docs.php'>Documentation</a></span>
</div>


<?php 
if ($menu == "yes") { ?>
	<!-- slide out function -->
	<script>
		$(document).ready(function(){
		  $(".menu-btn").click(function(event){
		    event.preventDefault();
		    $("nav").toggleClass("menushow");
		    
		    
		  });
		});
	</script>
<?php } ?>

</body>
</html>