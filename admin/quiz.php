<?php 

include '../connection/conn.php';



if(isset($_POST['submit_quiz'])){

    $n=$_GET['number'];


    $for_question="SELECT * FROM quiznumtable ";


    $result_quest=mysqli_query($conn,$for_question);
    $num_quest=mysqli_num_rows($result_quest);
    
    
    
    
    
    
    if($num_quest==0){
  


    $numbers  = mysqli_query($conn, "INSERT INTO `quiznumtable` (`total`) VALUES ('$n')") or die();

    for ($i = 1; $i <= $n; $i++) {
        $qid  = uniqid();

        $qns  =$_POST['qns' . $i];

        $q3   = mysqli_query($conn, "INSERT INTO `questiontable` (`qid`,`qns`,`i`) VALUES ('$qid','$qns','$i')") or die();

        $oaid = uniqid();
        $obid = uniqid();
        $ocid = uniqid();
        $odid = uniqid();
        $a    = $_POST[$i . '1'];
        $b    = $_POST[$i . '2'];
        $c    = $_POST[$i . '3'];
        $d    = $_POST[$i . '4'];


     


        $qa =mysqli_query($conn, "INSERT INTO `optiontable` (`qid`,`options`,`oid`) VALUES ('$qid','$a','$oaid')") or die('Error61');
        $qb =mysqli_query($conn, "INSERT INTO `optiontable` (`qid`,`options`,`oid`) VALUES ('$qid','$b','$obid')") or die('Error61');
        $qc =mysqli_query($conn, "INSERT INTO `optiontable` (`qid`,`options`,`oid`) VALUES ('$qid','$c','$ocid')") or die('Error61');
        $qd =mysqli_query($conn, "INSERT INTO `optiontable` (`qid`,`options`,`oid`) VALUES ('$qid','$d','$odid')") or die('Error61');
        



        
        $e = $_POST['ans' . $i];
        switch ($e) {
            case 'a':
                $ansid = $oaid;
                break;
            
            case 'b':
                $ansid = $obid;
                break;
            
            case 'c':
                $ansid = $ocid;
                break;
            
            case 'd':
                $ansid = $odid;
                break;
            
            default:
                $ansid = $oaid;
        }

      
        
        $qans =   mysqli_query($conn, "INSERT INTO `answertable` (`qid`,`ansid`) VALUES ('$qid','$ansid')") or die();
    }
    
    header("location:quiz.php");

  }




}
  



if(isset($_GET['delete'])){

  $delete_questions=mysqli_query($conn,'DELETE FROM questiontable');

  $delete_options=mysqli_query($conn,'DELETE FROM optiontable');
  $delete_answers=mysqli_query($conn,'DELETE FROM answertable');
  $delete_quiznum=mysqli_query($conn,'DELETE FROM quiznumtable');


  if($delete_questions && $delete_options && $delete_answers && $delete_quiznum ){
    header('location:quiz.php');
  }
  



}




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin-home</title>
    <?php include 'admin_partials/headlinks.php' ?>

</head>
<body>
<?php  include 'admin_partials/navbar.php' ?>

<div class="card m-5">
    <div class="card-body">
    <form class="row g-3">

    <?php 

$for_question="SELECT * FROM quiznumtable ";


$result_quest=mysqli_query($conn,$for_question);
$num_quest=mysqli_num_rows($result_quest);






if($num_quest==0){



?>



  
  <div class="col-auto">
    <label for="inputPassword2" class="visually-hidden">Number of Questions</label>
    <input type="number" name="number" class="form-control" id="inputPassword2" placeholder="set no. of question">
  </div>
  <div class="col-auto">
    <input type="submit" class="btn btn-primary mb-3" value="SET"></input>
  </div>
</form>
    </div>
</div>


<?php

if(isset($_GET['number'])){

    $n=$_GET['number'];

echo '<form  class="card m-5" method="POST" >';
    
    for ($i = 1; $i <= $n; $i++) {

        echo '
        <div class="input-group mt-5">
        <span class="input-group-text">Question ' . $i . '</span>
        <textarea name="qns' . $i . '" placeholder="Enter Question ' . $i . '" class="form-control" aria-label="With textarea"></textarea>
      </div>
      <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Option a</span>
      <input name="' . $i . '1" type="text" class="form-control" placeholder="Enter Option a" aria-label="Username" aria-describedby="basic-addon1">
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Option b</span>
      <input name="' . $i . '2" type="text" class="form-control" placeholder="Enter Option b" aria-label="Username" aria-describedby="basic-addon1">
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Option c</span>
      <input name="' . $i . '3" type="text" class="form-control" placeholder="Enter Option c" aria-label="Username" aria-describedby="basic-addon1">
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Option d</span>
      <input name="' . $i . '4" type="text" class="form-control" placeholder="Enter Option c" aria-label="Username" aria-describedby="basic-addon1">
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Answer</span>
      <select name="ans' . $i . '" id="inputState" class="form-select">
          <option selected>ans for question  ' . $i . '</option>
          <option value="a">a</option>
          <option value="b">b</option>
          <option value="c">c</option>
          <option value="d">d</option>
    </select>
    </div>
    
        ';
    


    }


    echo '
    <div class="col-auto">
    <button type="submit" name="submit_quiz" class="btn btn-primary">Submit Quiz</button>
  </div>
    </form>';

   

   



}
else{


    echo '<div class="card text-center m-5">
    <div class="card-header">
      NOTE
    </div>
    <div class="card-body ">
      <blockquote class="blockquote mb-0">
        <p>Please Provide the Number of Questions for quiz !!</p>
        <footer class="blockquote-footer">Click Set</footer>
      </blockquote>
    </div>
  </div>';



}




}
elseif($num_quest==1){

?>
<div class="card text-center m-5">
    <div class="card-header">
      NOTE
    </div>
    <div class="card-body ">
      <blockquote class="blockquote mb-0">
        <p>The QUiz has been Already Created   !!</p>
        <footer class="blockquote-footer">to Create new Quiz delete the Already Created One by Clicking Below</footer>

<a href="quiz.php?delete='yes'" class='btn btn-danger'>Delete Quiz</a>


      </blockquote>
    </div>
  </div>

  <?php 

}

?>















<?php  include 'admin_partials/bottomlinks.php' ?>
</body>
</html>