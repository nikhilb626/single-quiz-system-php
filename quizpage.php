<?php 

include "connection/conn.php";


session_start();

if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin']!=true){
  header("location:index.php");
  exit;
}


$user_id=$_SESSION['userid'];


?>



<?php



$isSubmitted=false;
$showError=false;

if($_SERVER["REQUEST_METHOD"]=="POST"){
include 'connection/conn.php';


if(isset($_POST['option'])){



$option_id=$_POST['option'];


$question_number=$_GET['n'];


$for_qid="SELECT * FROM questiontable Where i=$question_number ";


$result_qid=mysqli_query($conn,$for_qid);
$num_qid=mysqli_num_rows($result_qid);


if($num_qid==1){
    $row=mysqli_fetch_assoc($result_qid);

        $question_id=$row['qid'];


        




    
    $existSql="SELECT * FROM `quizsubmittable` WHERE userid=$user_id AND  qid='$question_id' ";

    $result=mysqli_query($conn,$existSql);
    $numExistRows=mysqli_num_rows($result);

    if($numExistRows>0){
      $showError="Answer Already Submitted";

    }
    else{
  
        $sql="INSERT INTO `quizsubmittable` (`userid`,`qid`,`subans`) VALUES ('$user_id','$question_id','$option_id')";
        $result=mysqli_query($conn,$sql);

        if($result){
            $isSubmitted=true;
        }



  }








}

}


}



if(isset($_POST['finished'])){
    $sql="SELECT * FROM usertable WHERE id=$user_id ";

    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);

    
    if($num==1){




            $sql="UPDATE  `usertable` SET `status`='complete'   WHERE id=$user_id ";

            $result2=mysqli_query($conn,$sql);


            if($result2){


              $sql="SELECT * FROM quizsubmittable WHERE userid=$user_id ";

              $result=mysqli_query($conn,$sql);
              $num=mysqli_num_rows($result);

              $score=0;
              

              
              if($num>0){

                $sql="SELECT * FROM answertable  ";

                $result2=mysqli_query($conn,$sql);
                $num2=mysqli_num_rows($result2);
                
                while($row=mysqli_fetch_assoc($result)){
                              $sub_quest_id=$row['qid'];
                              $sub_ans_id=$row['subans'];



                         
                   
                           
                           if($num2>0){
                           $row=mysqli_fetch_assoc($result2);
                            $actual_ans=$row['ansid'];

                            if($sub_ans_id==$actual_ans){
                              $score+=1;
                            }

                           

                           }




                }
              
              }


              if(isset($_GET['Q'])){

                $total=$_GET['Q'];


                $sql="INSERT INTO `scoretable` (`userid`,`score`,`outof`) VALUES ('$user_id',$score,$total)";
              $result=mysqli_query($conn,$sql);
      
              if($result){
                header("location:quiz_result.php");

              }

              }

              







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
    <title>Quiz page</title>
    <?php  include "partials/quiz_headlinks.php" ?>
   

</head>
<body>
<?php include "partials/navbar.php" ?>



<div class="quiz_questionare_cont">

<?php 

if(isset($_GET['n']) &&  isset($_GET['Q']) ){

    $question_number=$_GET['n'];
    $total=$_GET['Q'];
    


    $sql="SELECT * FROM questiontable Where i=$question_number ";

				$result=mysqli_query($conn,$sql);
				$num=mysqli_num_rows($result);
			
				
				if($num==1){
					while($row=mysqli_fetch_assoc($result)){
                        $question=$row['qns'];
                        $qid=$row['qid'];




?>
   <?php


if($showError){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Register Fail</strong>'.$showError.'
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}



?>
<div class="header_info">Question <?php echo $question_number; ?> Out of <?php echo $total; ?> </div>






<?php 

$question_number=$_GET['n'];


$for_qid="SELECT * FROM questiontable WHERE i=$question_number  ";


$result_qid=mysqli_query($conn,$for_qid);
$num_qid=mysqli_num_rows($result_qid);


if($num_qid==1){
    $row=mysqli_fetch_assoc($result_qid);

        $question_id=$row['qid'];

        $for_question="SELECT * FROM quizsubmittable WHERE qid='$question_id'  AND userid=$user_id ";


$result_quest=mysqli_query($conn,$for_question);
$num_quest=mysqli_num_rows($result_quest);






if($num_quest==1){



    $for_question="SELECT * FROM quizsubmittable WHERE  userid=$user_id ";


    $result_quest=mysqli_query($conn,$for_question);
    $number=mysqli_num_rows($result_quest);


    if($number==$total){
        echo '<div class="card text-center">
        <div class="card-body text-center">
          <blockquote class="blockquote mb-0">
            <p>You have Submitted All  Questions</p>
            <footer class="blockquote-footer text-primary">Click below button to Check the result</footer>
          </blockquote>
        </div>
      </div>';
    

    }
elseif($number<$total){



  echo '<div class="card text-center">
  <div class="card-body text-center">
    <blockquote class="blockquote mb-0">
      <p>You have Submitted Question '.$question_number.'</p>
      <footer class="blockquote-footer">Now Can proceed to next Question</footer>
    </blockquote>
  </div>
</div>';




}


}
elseif($num_quest==0){

?>

<div class="question_cont">Q<?php echo $question_number; ?>. <?php echo $question; ?> ?</div>


<?php 
    }}

?>


<form method='POST'>


<div class="quiz_options">
    <?php 
if($isSubmitted==false){



?>

<?php 

$sql3="SELECT * FROM questiontable Where i=$question_number ";

$result3=mysqli_query($conn,$sql3);
$num3=mysqli_num_rows($result3);


if($num3==1){
    while($row=mysqli_fetch_assoc($result3)){
        $question=$row['qns'];
        $question_id=$row['qid'];


        $sql2="SELECT * FROM optiontable WHERE qid='$question_id' ";

$result2=mysqli_query($conn,$sql2);
$num2=mysqli_num_rows($result2);


if($num2>0){
    while($row2=mysqli_fetch_assoc($result2)){
        $optionvalue=$row2['options'];
        $option_id=$row2['oid'];
?>

<?php 
$question_number=$_GET['n'];


$for_qid="SELECT * FROM questiontable WHERE i=$question_number  ";


$result_qid=mysqli_query($conn,$for_qid);
$num_qid=mysqli_num_rows($result_qid);


if($num_qid==1){
    $row=mysqli_fetch_assoc($result_qid);

        $question_id=$row['qid'];

        $for_question="SELECT * FROM quizsubmittable WHERE qid='$question_id'  AND userid=$user_id ";


$result_quest=mysqli_query($conn,$for_question);
$num_quest=mysqli_num_rows($result_quest);






if($num_quest==0){


?>



<div class="options_individual">
<label>
    <input type="radio" name="option" value="<?php echo $option_id; ?>" >
    <span class="value"><?php echo $optionvalue; ?></span>
  </label>
</div>


<?php 
}}

?>




<?php 

}

}
    }

    }}


    }}

?>







 

</div>


<?php 


$question_number=$_GET['n'];


$for_qid="SELECT * FROM questiontable Where i=$question_number   ";



$result_qid=mysqli_query($conn,$for_qid);
$num_qid=mysqli_num_rows($result_qid);


if($num_qid==1){


    $row=mysqli_fetch_assoc($result_qid);

        $question_id=$row['qid'];

        $for_question="SELECT * FROM quizsubmittable Where qid='$question_id' AND userid=$user_id ";


$result_quest=mysqli_query($conn,$for_question);
$num_quest=mysqli_num_rows($result_quest);



if($num_quest==1){




?>

<div class="buttons_container">



<?php 

$next_question=$question_number+1;



$sql2="SELECT * FROM quizsubmittable WHERE userid=$user_id ";

$result2=mysqli_query($conn,$sql2);
$num2=mysqli_num_rows($result2);


if($num2==$total){

?>





<form method="post">
    <input type="submit" class="btn btn-primary" name="finished"  value="Finish" ></input>
</form>


<?php 
}
elseif($num2<$total){




?>

<a class="btn btn-primary"  href="quizpage.php?n=<?php echo $next_question ?>&Q=<?php echo $total ?>"  >NEXT-></a>


<?php 

}

?>



</div>

<?php 

}


elseif($num_quest==0){


?>


<div class="buttons_container">


    <input class="btn btn-primary" type="submit" value="SUBMIT" >


</div>






<?php 

}

}

?>










</form>




<?php 
                

}
?>


</div>



<?php include 'partials/bottomlinks.php' ?>

</body>
</html>