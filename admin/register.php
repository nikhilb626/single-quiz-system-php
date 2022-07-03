
<?php

$showAlert=false;
$showError=false;

if($_SERVER["REQUEST_METHOD"]=="POST"){
        include '../connection/conn.php';

    $email=$_POST["email"];
    $phone=$_POST["mobile"];
    $password=$_POST["password"];
    $confirmpassword=$_POST["cpassword"];


    $existSql="SELECT * FROM `admintable` WHERE email='$email'";
    $result=mysqli_query($conn,$existSql);
    $numExistRows=mysqli_num_rows($result);

    if($numExistRows>0){
      $showError="email already exists";

    }
    else{
    if($password===$confirmpassword){

      $hash=password_hash($password,PASSWORD_DEFAULT);
        $sql="INSERT INTO `admintable` (`email`,`mobile`,`password`) VALUES ('$email','$phone','$hash')";
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
    <?php  include 'admin_partials/headlinks.php' ?>

</head>
<body>
    <div id="register_container" class="wrapper">
 
	<div class="registration_form">
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
		<div class="title">
	    Admin Registration
		</div>

		<form method="post" >
			<div class="form_wrap">
				
				<div class="input_wrap">
					<label for="email">Email Address</label>
					<input name="email" type="text" id="email">
				</div>
				
				<div class="input_wrap">
					<label for="mobile">Mobile</label>
					<input name="mobile" type="text" id="mobile">
				</div>
				<div class="input_wrap">
					<label for="password">Password</label>
					<input name="password" type="text" id="password">
				</div>
				<div class="input_wrap">
					<label for="cpassword">Confirm Password</label>
					<input name="cpassword" type="text" id="cpassword">
				</div>
				<div class="input_wrap">
					<input type="submit" value="Register Admin" class="submit_btn">
				</div>
               
			</div>
		</form>
	</div>
</div>


    


<?php  include 'admin_partials/bottomlinks.php' ?>
</body>
</html>