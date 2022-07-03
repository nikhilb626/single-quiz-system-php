
<?php

$showAlert=false;
$showError=false;

if($_SERVER["REQUEST_METHOD"]=="POST"){
        include 'connection/conn.php';

    $name=$_POST["name"];
    $email=$_POST["email"];
    $gender=$_POST["gender"];
    $phone=$_POST["phone"];
    $password=$_POST["password"];
    $confirmpassword=$_POST["cpassword"];


    $existSql="SELECT * FROM `usertable` WHERE email='$email' OR phone='$phone' ";
    $result=mysqli_query($conn,$existSql);
    $numExistRows=mysqli_num_rows($result);

    if($numExistRows>0){
      $showError="email OR phone no. already exists";

    }
    else{
    if($password===$confirmpassword){

      $hash=password_hash($password,PASSWORD_DEFAULT);
        $sql="INSERT INTO `usertable` (`name`,`email`,`gender`,`phone`,`password`) VALUES ('$name','$email','$gender','$phone','$hash')";
        $result=mysqli_query($conn,$sql);

        if($result){
            $showAlert=true;
        }

    }else{
        $showError="password does not match";
    }

  }

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php  include 'partials/headlinks.php' ?>

</head>
<body>


<div id="register_container" class="wrapper">
	<div class="registration_form">
		<div class="title">
	    Quiz Registration 
		</div>

		<?php

if($showAlert){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success</strong> Your account is created, now you can log in
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
if($showError){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Register Fail</strong>'.$showError.'
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}



?>

		<form  method="POST" >
			<div class="form_wrap">
					<div class="input_wrap">
						<label for="name">Full Name</label>
						<input name="name" type="text" id="name" required>
					
				</div>
				<div class="input_wrap">
					<label for="email">Email Address</label>
					<input name="email" type="text" id="email" required>
				</div>
				<div class="input_wrap">
					<label>Gender</label>
					<ul>
						<li>
							<label class="radio_wrap">
								<input type="radio" name="gender" value="male" class="input_radio" >
								<span>Male</span>
							</label>
						</li>
						<li>
							<label class="radio_wrap">
								<input type="radio" name="gender" value="female" class="input_radio">
								<span>Female</span>
							</label>
						</li>
					</ul>
				</div>
				<div class="input_wrap">
					<label for="mobile">Mobile</label>
					<input name="phone" type="text" id="mobile" required>
				</div>
				<div class="input_wrap">
					<label for="password">Password</label>
					<input name='password' type="text" id="password" required>
				</div>
				<div class="input_wrap">
					<label for="cpassword">Confirm Password</label>
					<input name='cpassword' type="text" id="cpassword" required>
				</div>
				<div class="input_wrap">
					<input type="submit" value="Register Now" class="submit_btn">
				</div>
                <div class="input_wrap">
                    <p>Already an Account ? <a href="index.php">Login Now</a></p>
                </div>
			</div>
		</form>
	</div>
</div>


    


<?php  include 'partials/bottomlinks.php' ?>
</body>
</html>