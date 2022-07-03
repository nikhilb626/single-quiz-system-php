<?php
include 'connection/conn.php';



session_start();

if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin']!=true){
  header("location:index.php");
  exit;
}

$user_id=$_SESSION['userid'];

$sql="SELECT * FROM scoretable WHERE userid = $user_id ";


$result=mysqli_query($conn,$sql);


$num=mysqli_num_rows($result);

 
if($num==1){


  $row=mysqli_fetch_assoc($result);
  $score=$row['score'];
  $outof=$row['outof'];


   $percentage=($score/$outof)*100;


   if($percentage<75){
header('location:quizpage.php');

   }

}


require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$document=new Dompdf();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>certificate</title>
    <?php include 'partials/quiz_headlinks.php' ?>
    
</head>
<body>

        <?php 
$sql="SELECT * FROM  usertable WHERE id=$user_id ";

$result=mysqli_query($conn,$sql);


$num=mysqli_num_rows($result);

 
if($num==1){


  $row=mysqli_fetch_assoc($result);
  $name=$row['name'];

  $html='<div class="certificate_page">
  <div class="winner_name">
  this is the content
  </div>
  </div>
  ';


$document->loadHtml($html);
$document->setPaper('A4','landscape');
$document->render();
$document->stream();


}

?>
   

</body>

<?php include "partials/bottomlinks.php" ?>
</html>