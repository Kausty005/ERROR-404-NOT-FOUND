<?php
$username="root";
$password="";
$server="localhost";
$db="User";

$con = mysqli_connect($server,$username,$password,$db);

if ($con){
    ?>




    <?php
    
}else{
    echo "no connection";
}


?>
