<?php include ( "../form/connect.inc.php" ); ?>
<?php 

ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	$user = "";
	header("location: login.php?ono=".$epid."");
}
else {
	if (isset($_REQUEST['epid'])) {
	
		$epid = mysqli_real_escape_string($conn, $_REQUEST['epid']);
	}else {
		header('location: index.php');
	}
	$user = $_SESSION['admin_login'];
	$result = mysqli_query($conn, "SELECT * FROM admin WHERE id='$user'");
	$get_user_email = mysqli_fetch_assoc($result);
		$uname_db = $get_user_email['firstName'];

}
$getposts = mysqli_query($conn, "SELECT * FROM posts WHERE id ='$epid'") or die(mysql_error());
	if (mysqli_num_rows($getposts)) {
		$row = mysqli_fetch_assoc($getposts);
		$id = $row['id'];
		$title = $row['title'];
		$body = $row['body'];
		$picture = $row['picture'];
		$type = $row['type'];
		$typeu = ucwords($row['type']);
		$category = $row['category'];
		$categoryu = ucwords($row['category']);
	}	

//update product
if (isset($_POST['updatepro'])) {
	$title = $_POST['title'];
	$body = $_POST['body'];
	$category = $_POST['category'];
	$type = $_POST['type'];
	//triming name
	$_POST['title'] = trim($_POST['title']);

	if($result = mysqli_query($conn, "UPDATE posts SET title='$_POST[title]',price='$_POST[body]',category='$_POST[category]',type='$_POST[type]' WHERE id='$epid'")){
		header("Location: editpost.php?epid=".$epid."");

	}else {
		echo "no changed";
	}
}
if (isset($_POST['updatepic'])) {

if($_FILES['profilepic'] == ""){
	
		echo "not changed";
}else {
	//finding file extention
$profile_pic_name = @$_FILES['profilepic']['name'];
$file_basename = substr($profile_pic_name, 0, strripos($profile_pic_name, '.'));
$file_ext = substr($profile_pic_name, strripos($profile_pic_name, '.'));

if (((@$_FILES['profilepic']['type']=='image/jpeg') || (@$_FILES['profilepic']['type']=='image/png') || (@$_FILES['profilepic']['type']=='image/jpg') || (@$_FILES['profilepic']['type']=='image/gif')) && (@$_FILES['profilepic']['size'] < 1000000)) {

	$item = $item;
	if (file_exists("../img/posts/$item")) {
		//nothing
	}else {
		mkdir("../img/posts/$item");
	}
	
	
	$filename = strtotime(date('Y-m-d H:i:s')).$file_ext;

	if (file_exists("../img/posts/".$filename)) {
		echo @$_FILES["profilepic"]["name"]."Already exists";
	}else {
		if(move_uploaded_file(@$_FILES["profilepic"]["tmp_name"], "../img/posts/".$filename)){
			$photos = $filename;
			if($result = mysqli_query($conn, "UPDATE posts SET picture='$photos' WHERE id='$epid'")){

				$delete_file = unlink("../img/posts/".$picture);
				header("Location: editproduct.php?epid=".$epid."");
			}else {
				echo "Wrong!";
			}
		}else {
			echo "Something Worng on upload!!!";
		}
		//echo "Uploaded and stored in: userdata/profile_pics/$item/".@$_FILES["profilepic"]["name"];
		
		
	}
	}
	else {
		$error_message = "Choose a picture!";
	}

}
}



if (isset($_POST['delprod'])) {
//triming name
	$getposts1 = mysqli_query($conn, "SELECT pid FROM posts WHERE pid='$epid'") or die(mysql_error());
					if ($ttl = mysqli_num_rows($getposts1)) {
						$error_message = "You can not delete this product.<br>Someone ordered this.";
					}
					else {
						if(mysqli_query($conn, "DELETE FROM posts WHERE id='$epid'")){
						header('location: orders.php');
						}
					}
	}

$search_value = "";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Stavent Global</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-image: url(../img/Others/homebackgrndimg2.png);">
	<div class="homepageheader">
			<div class="signinButton loginButton">
				<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
					<?php 
						if ($user!="") {
							echo '<a style="text-decoration: none;color: #fff;" href="logout.php">LOG OUT</a>';
						}
					 ?>
					
				</div>
				<div class="uiloginbutton signinButton loginButton">
					<?php 
						if ($user!="") {
							echo '<a style="text-decoration: none;color: #fff;" href="login.php">Hi '.$uname_db.'</a>';
						}
						else {
							echo '<a style="text-decoration: none;color: #fff;" href="login.php">LOG IN</a>';
						}
					 ?>
				</div>
			</div>
			<div style="float: left; margin: 5px 0px 0px 23px;">
				<a href="index.php">
					<img style=" height: 75px; width: 130px;" src="../image/ebuybdlogo.png">
				</a>
			</div>
			<div id="srcheader">
				<form id="newsearch" method="get" action="search.php">
				        <?php 
				        	echo '<input type="text" class="srctextinput" name="keywords" size="21" maxlength="120"  placeholder="Search Here..." value="'.$search_value.'"><input type="submit" value="search" class="srcbutton" >';
				         ?>
				</form>
			<div class="srcclear"></div>
			</div>
		</div>
		<div class="categolis">
			<table>
				<tr>
					<th>
						<a href="index.php" style="text-decoration: none;color: #fff;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">Home</a>
					</th>
					<th><a href="addproduct.php" style="text-decoration: none;color: #ddd;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">Add Product</a></th>
					<th><a href="newadmin.php" style="text-decoration: none;color: #ddd;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">New Admin</a></th>
					<th><a href="allproducts.php" style="text-decoration: none;color: #ddd;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">All Products</a></th>
					<th><a href="orders.php" style="text-decoration: none;color: #ddd;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">Orders</a></th>
				</tr>
			</table>
		</div>
	<div class="holecontainer" style=" padding-top: 20px; padding: 0 20%">
		<div class="container signupform_content ">
			<div>

				<h2 style="padding-bottom: 20px;">Edit Post Info</h2>
				<div style="float: right;">
				<?php 
					echo '
						<div class="">
						<div class="signupform_text"></div>
						<div>
							<form action="" method="POST" class="registration">
								<div class="signup_form">
									<div>
										<td >
											<input name="title" id="first_name" placeholder="Post tilte" required="required" class="first_name signupbox" type="text" size="30" value="'.$title.'" >
										</td>
									</div>
									<div>
										<td >
											<input name="body" id="first_name" placeholder="Description" required="required" class="first_name signupbox" type="text" size="30" value="'.$body.'" >
										</td>
									</div>
									<div>
										<td>
											<select name="category" required="required" style=" font-size: 20px;
										font-style: italic;margin-bottom: 3px;margin-top: 0px;padding: 14px;line-height: 25px;border-radius: 4px;border: 1px solid #169E8F;color: #169E8F;margin-left: 0;width: 300px;background-color: transparent;" class="">
												<option selected value="'.$category.'">'.$categoryu.'</option>
												<option selected value="idea">Idea</option>
												<option selected value="inovation">Innovation</option>
												<option selected value="general">General</option>
															
											</select>
										</td>
									</div>
									<div>
										<select name="type" required="required" style=" font-size: 20px;
										font-style: italic;margin-bottom: 3px;margin-top: 0px;padding: 14px;line-height: 25px;border-radius: 4px;border: 1px solid #169E8F;color: #169E8F;margin-left: 0;width: 300px;background-color: transparent;" class="">
											<option selected value="'.$type.'">'.$typeu.'</option>
											<option selected value="clothing">post</option>
											<option value="other">Other</option>
											<option value="ad">Offer</option>
											</select>
									</div>
									<div>
										<input name="updatepro" class="uisignupbutton signupbutton" type="submit" value="Update Product">
									</div>
									<div>
										<input name="delprod" class="uisignupbutton signupbutton" type="submit" value="Delete This Product">
									</div>
									<div class="signup_error_msg">
										<?php 
											if (isset($error_message)) {echo $error_message;}
											
										?>
									</div>
								</div>
							</form>
						</div>
					</div>

					';
					if(isset($success_message)) {echo $success_message;}

				 ?>
					
				</div>
			</div>
		</div>
		<div style="float: left;">
			<div>
				<?php
					echo '
						<ul style="float: left;">
							<li style="float: left; padding: 0px 25px 25px 25px;">
								<div class="home-prodlist-img prodlist-img">';
								if (file_exists('../img/posts/'.$picture.'')){
									echo '<img src="../img/posts/'.$picture.'" class="home-prodlist-imgi">';
								}else {
									echo '
									<div class="home-prodlist-imgi" style="text-align: center; padding: 0 0 6px 0;">No Image Found!</div>';
								} echo '
									
								</div>
							</li>
							<li>
								<form action="" method="POST" class="registration" enctype="multipart/form-data">
										<div class="signup_form">
											<div>
												<td>
													<input name="profilepic" style="width: 115px;" class="password signupbox" type="file" value="Add Picture">
												</td>
											</div>
											<div>
												<input name="updatepic" style="width: 144px;" class="uisignupbutton signupbutton" type="submit" value="Change Picture">
											</div>
											<div class="signup_error_msg">';
											if(isset($error_message)) {echo $error_message;}
											' </div>
										</div>
									</form>
							</li>
						</ul>
					';
				?>
			</div>

		</div>
	</div>
</body>
</html>