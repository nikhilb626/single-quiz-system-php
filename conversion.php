


<?php


require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$document=new Dompdf();


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





$sql="SELECT * FROM  usertable WHERE id=$user_id ";

$result=mysqli_query($conn,$sql);


$num=mysqli_num_rows($result);


 
if($num==1){


  $row=mysqli_fetch_assoc($result);
  $name=$row['name'];




  $html='
  
  <style>

  .certificate_page{
 
    background-size: contain;
    min-height:100vh;
    width:100vw;
  }


  .certificate_page img{
      height: 100%;
      width: 100%;
  }

  .winner_name{
    position:absolute;
    top:56%;
    left:50%;
    right: 50%;
    font-size: 2.6rem;
    font-weight: 500;
    width: fit-content;
    transform:translate(-50%,-50%);
    text-transform: capitalize;
  text-align:center; 
  letter-spacing: 2px; 
  color:rgb(27, 23, 37);
  font-family:cursive;
  }


  </style>

  <div class="certificate_page">
  <img src="assets/certificate.jpeg" alt="#">
  <div class="winner_name">
 '.$name.'
  </div>
  </div>
  ';


$document->loadHtml($html);
$document->setPaper('A4','landscape');
$document->render();
$document->stream();


}



?>

