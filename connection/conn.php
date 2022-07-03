<?php 

$conn=new mysqli('localhost','root','','myquiz');

if($conn){

}else{
    die(mysqli_error($conn));
}


?>