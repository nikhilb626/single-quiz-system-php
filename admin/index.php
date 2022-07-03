<?php 

session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  header("location:home.php");
  exit;
}



?>


<?php


$login=false;
$showError=false;


if($_SERVER["REQUEST_METHOD"]=="POST"){
    include '../connection/conn.php';


    $email=$_POST["email"];
    $password=$_POST["password"];


    $sql="SELECT * FROM admintable WHERE email='$email'";

    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);

    
    if($num==1){
        while($row=mysqli_fetch_assoc($result)){
            if(password_verify($password,$row['password'])){
                $login=true;
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['email']=$email;
                header("location:home.php");
            }else{
                $showError="Invalid Credentials";
            }
        }
    }elseif($num==0){
        $showError="invalid Credentials";
    }


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN-LOGIN</title>
    <?php  include 'admin_partials/headlinks.php' ?>

</head>
<body>


<div class="wrapper">
	<div class="registration_form">
    <?php

if($showError){
 echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
 <strong>Register Fail</strong>'.$showError.'
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
    
?>
		<div class="title">
			Admin Login
		</div>

		<form method="post">
			<div class="form_wrap">
				<div class="input_grp">
					
				</div>
				<div class="input_wrap">
					<label for="email">Email Address</label>
					<input name="email" type="text" id="email">
				</div>
				
				
				<div class="input_wrap">
					<label for="password">Password</label>
					<input name="password" type="password" id="password">
				</div>
				
				<div class="input_wrap">
					<input type="submit" value="Login Now" class="submit_btn">
				</div>
              
			</div>
		</form>
	</div>
</div>


    


<?php  include 'admin_partials/bottomlinks.php' ?>
</body>
</html>