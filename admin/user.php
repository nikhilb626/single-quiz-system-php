<?php

include "../connection/conn.php";

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


<div class="card m-3">
  <div class="card-body">
  <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">NAME</th>
      <th scope="col">PHONE</th>
      <th scope="col">EMAIL</th>
      <th scope="col">GENDER</th>
      <th scope="col">ACTION</th>
    </tr>
  </thead>
  <tbody>

  <?php 
$sql="SELECT * FROM scoretable ORDER BY id DESC ";

$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);


if($num>0){

$sno=1;

  $sql="SELECT * FROM usertable ";

$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);


if($num==1){
  while($row=mysqli_fetch_assoc($result)){

  $name=$row['name'];
  $phone=$row['phone'];
  $gender=$row['gender'];
  $email=$row['email'];
  $user_id=$row['id'];


?>


    <tr>
      <th scope="row"><?php echo $sno; ?></th>
      <td><?php echo $name?></td>
      <td><?php echo $phone ?></td>
      <td><?php echo $email ?></td>
      <td><?php echo $gender ?></td>
      <td><a href="deleteusers.php?delete=<?php echo $user_id; ?>" class="btn btn-danger">Delete</a></td>
  
    </tr>

    <?php 

$sno+=1;


}}}else{


  ?>



  <tr>
  <td class="text-center" colspan="6">No User Added Yet !!</td>
 
  
</tr>


<?php

}

?>






  </tbody>
</table>
  </div>
</div>







<?php  include 'admin_partials/bottomlinks.php' ?>
</body>
</html>