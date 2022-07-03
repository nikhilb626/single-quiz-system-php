
<?php 

// session_start();

// if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
//   header("location:home.php");
//   exit;
// }



?>


<?php


$login=false;
$showError=false;


if($_SERVER["REQUEST_METHOD"]=="POST"){
    include 'connection/conn.php';


    $email=$_POST["email"];
    $password=$_POST["password"];




    $sql="SELECT * FROM usertable WHERE email='$email'";

    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);

    
    if($num==1){
        while($row=mysqli_fetch_assoc($result)){
            if(password_verify($password,$row['password'])){

                $login=true;
				$user_id=$row['id'];
				$user_status=$row['status'];
				$user_agree=$row['isagree'];
                session_start();
                $_SESSION['userloggedin']=true;
                // $_SESSION['useremail']=$email;
				$_SESSION['userid']=$user_id;

				// conditions......to redirect

				$sql="SELECT * FROM quiznumtable";

				$result=mysqli_query($conn,$sql);
				$num=mysqli_num_rows($result);
			


				
				if($num==1){

			$row=mysqli_fetch_assoc($result);

				$Q=$row['total'];
	



				if($user_status=='new' && $user_agree=='no' ){
					header("location:terms.php");


				}elseif($user_status=='incomplete' && $user_agree='yes' ){

					$sql="SELECT * FROM quizsubmittable WHERE userid=$user_id ";

					$result=mysqli_query($conn,$sql);
					$lastQuest=mysqli_num_rows($result);


				
	
	
					
					if($lastQuest<$Q){

						$lastQuest2=$lastQuest+1;

						header("location:quizpage.php?n=".$lastQuest2.'&Q='.$Q);

						


				} else{
					
					$lastQuest2=$lastQuest;

					header("location:quizpage.php?n=".$lastQuest2.'&Q='.$Q);

				}
				
				
				
			}elseif($user_status=='complete' && $user_agree=='yes' ){
					header("location:quiz_result.php");

				}


	

			
				
				
				}else{
					$showError="Quiz is not Started Yet !!";
				}


			
	




            }
			
			
        }
    }

	elseif($num==0){
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
    <title>Home</title>
    <?php  include 'partials/headlinks.php' ?>

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
			Quiz Login
		</div>

		<form method="POST">
			<div class="form_wrap">
				<div class="input_grp">
					
				</div>
				<div class="input_wrap">
					<label for="email">Email Address</label>
					<input name="email"  type="text" id="email" required>
				</div>
				
				
				<div class="input_wrap">
					<label for="password">Password</label>
					<input name="password" type="text" id="password" required>
				</div>
				
				<div class="input_wrap">
					<input type="submit" value="Login Now" class="submit_btn">
				</div>
                <div class="input_wrap">
                    <p>dont have Account ? <a href="register.php">register Now</a></p>
                </div>
			</div>
		</form>
	</div>
</div>


    


<?php  include 'partials/bottomlinks.php' ?>
</body>
</html>