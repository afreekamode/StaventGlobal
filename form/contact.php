<?php include ( "connect.inc.php" ); ?>

<?php

	if(isset($_POST["page"]) && !empty($_POST["page"]))
{
	//Sign-up Page Starts here
	if($_POST["page"] == "contact")
	{
		$name= trim($_POST['name']);
		$u_email = $_POST['email'];
		$subject = trim($_POST['subject']);
		$comment = trim($_POST['comment']);
		
		if($name == "" || $u_email == "")
		{
			echo '<br><div class="info">Sorry, all fields are required to create a new account. Thank you.</div><br>';
		}
		elseif(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $u_email))
		{
			echo '<br><div class="info">Sorry, Your email address is invalid, please enter a valid email address. Thank you.</div><br>';
		}
		else
		{
		$sql = "INSERT INTO contact (name, email, suject, comment) VALUES('$name' , '$u_email', '$subject', '$comment')";
			
		if (mysqli_query($conn, $sql)) {
			echo 'index.html#contact';
			echo 'sent_successful=yes';
			}
			else
			{
				echo '<br><div class="info">Sorry, your account could not be created at the moment. Please try again or contact the site admin to report this error if the problem persist. Thanks.</div><br>';
			}
		}
	}
}
?>
