<?php 

include 'connection/conn.php';

session_start();

if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin']!=true){
  header("location:index.php");
  exit;
}


$user_id=$_SESSION['userid'];




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>result page</title>
    <?php include 'partials/quiz_headlinks.php' ?>
</head>
<body>
    <?php include 'partials/navbar.php' ?>

<?php 
 $sql="SELECT * FROM scoretable WHERE userid=$user_id ";

 $result=mysqli_query($conn,$sql);
 $num=mysqli_num_rows($result);

 
 if($num==1){


   $row=mysqli_fetch_assoc($result);
   $score=$row['score'];
   $outof=$row['outof'];


    $percentage=($score/$outof)*100;


    if($percentage>=75){


?>



    
    <div class="card text-center mt-5">
  <div class="card-header">
    QUIZ RESULT    
  </div>
  <div class="card-body">
    <h5 class="card-title">Congratulation Your Win !!</h5>
    <p class="card-text">Your Score is <span class="text-success"><?php echo $percentage ?></span> % , You  are eligible to get certificate  by clicking the button below . </p>
    <a href="conversion.php" class="btn btn-primary">Download Certificate</a>
  </div>
  <div class="card-footer text-muted">
    Thank you For participating in our Quiz
  </div>
</div>
   


<?php 
    }

elseif($percentage<75){

?>




<div class="card text-center mt-5">
  <div class="card-header">
    QUIZ RESULT    
  </div>
  <div class="card-body">
    <h5 class="card-title">Sorry You Loose this quiz </h5>
    <p class="card-text"> Your Score is <span class="text-danger"><?php echo $percentage ?></span>%  Which is below the eligible criteria for certification </p>
    <a href="logout.php" class="btn btn-primary">Log out</a>
  </div>
  <div class="card-footer text-muted">
  Thank you For participating in our Quiz

  </div>
</div>
   



<?php 
}


?>











<?php 

 }

?>



    <?php include 'partials/bottomlinks.php' ?>
</body>
</html>