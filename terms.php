<?php 

include 'connection/conn.php';

session_start();

if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin']!=true){
  header("location:index.php");
  exit;
}


$user_id=$_SESSION['userid'];

?>

<?php


if(isset($_POST['submit'])){

    if(isset($_POST['agree'])){
        $agree=$_POST['agree'];
        $sql="SELECT * FROM usertable WHERE id=$user_id ";

        $result=mysqli_query($conn,$sql);
        $num=mysqli_num_rows($result);
    
        
        if($num==1){


            $sql="UPDATE  `usertable` SET `isagree`='$agree'   WHERE id=$user_id ";

            $result=mysqli_query($conn,$sql);

            if($result){
                $sql="UPDATE  `usertable` SET `status`='incomplete'   WHERE id=$user_id ";

                $result2=mysqli_query($conn,$sql);
                $n=1;


                if($result2){
                    $sql="SELECT * FROM quiznumtable";

                    $result=mysqli_query($conn,$sql);
                    $num=mysqli_num_rows($result);
                
    
    
                    
                    if($num==1){
                $row=mysqli_fetch_assoc($result);
    
                    $Q=$row['total'];
                    header("location:quizpage.php?n=".$n.'&Q='.$Q);

                    }
                }

            }

            else{

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
    <title>Document</title>

    <?php include 'partials/quiz_headlinks.php' ?>
</head>
<body>
<?php include 'partials/navbar.php' ?>


<h1 class="term_main">Terms & Conditions</h1>



<h2 class="term_head">TERM 1</h2>
<p class="term_para">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Error suscipit minus libero alias unde eligendi, veritatis distinctio voluptas provident. Quis, cupiditate quas. Magnam, magni praesentium, ipsam animi qui modi cupiditate dignissimos impedit voluptate provident ut alias eum, nemo accusamus in temporibus laudantium aut nihil. Praesentium assumenda quas iure odit eum incidunt eveniet nisi, nulla suscipit placeat, dignissimos earum ratione quis? Odit commodi placeat expedita magnam maxime quidem dolorum deleniti! Sed similique exercitationem veritatis accusantium voluptates alias, non nemo expedita incidunt. Laboriosam magni repellendus dicta at, ipsum excepturi perspiciatis quisquam vel nisi, ex quaerat iusto illum libero atque laudantium velit eligendi.</p>
    



<h2 class="term_head">TERM 2</h2>
<p class="term_para">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita velit aperiam nam quisquam alias numquam consequatur illo neque dolor dolorum esse iure labore error unde, quae nulla sed perferendis, non, consequuntur voluptas? Modi cum odio sapiente expedita nisi accusantium culpa tempore necessitatibus praesentium sed sit quo id voluptatum facilis perferendis, incidunt magni! Odit eveniet asperiores repellendus provident praesentium perspiciatis. Vitae eius eum voluptate odio ad suscipit enim vel magnam sunt molestias ut sint sed praesentium adipisci sequi rerum voluptatibus debitis quod ex, iure, modi tenetur. Neque sint odit ut debitis libero exercitationem asperiores repellendus at, voluptatum quasi? Unde quis incidunt, fuga sequi a nihil optio porro eveniet perspiciatis adipisci pariatur? Praesentium necessitatibus eligendi ipsum dolor esse at impedit veniam voluptate quos ipsam corrupti sapiente magni animi, mollitia reiciendis, eaque ratione quo quas distinctio. Minima omnis id voluptates dicta ipsam praesentium ducimus, inventore beatae quis minus blanditiis at distinctio quaerat facilis.
</p>



<h2 class="term_head">TERM 3</h2>
<p class="term_para">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio voluptate facere modi distinctio minima porro vel sed ut officiis reprehenderit sapiente, aliquid assumenda alias magni rem velit fugiat. Et quae natus ipsum odio accusantium, itaque officia, maiores velit omnis quis nulla consectetur repudiandae eligendi officiis fugiat laborum amet dolorem laudantium in sed nesciunt ab commodi reiciendis asperiores. Quae molestias, asperiores aliquam veritatis nostrum, laboriosam expedita ullam, quos cumque recusandae velit.
</p>



<form method="POST" class="agree_form">
    <input type="radio" name='agree' value='yes' ><input type="submit" class="btn btn-primary" name="submit" value="I Agree">
</form>



<?php include 'partials/bottomlinks.php' ?>

</body>
</html>