<?php 


include '../connection/conn.php';

if(isset($_GET['delete'])){

    $user_id=$_GET['delete'];



    $delete_questions=mysqli_query($conn,"DELETE FROM usertable WHERE id=$user_id ");
    $delete_submition=mysqli_query($conn,"DELETE FROM quizsubmittable WHERE userid=$user_id ");
    $delete_score=mysqli_query($conn,"DELETE FROM scoretable WHERE userid=$user_id ");

    
    if($delete_questions && $delete_submition && $delete_score ){


   header('location:user.php');


    }
    
  
  
  
  }



?>