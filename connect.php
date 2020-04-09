<?php 
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="seminarcalendar";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if(!$conn){
        die("mysqli_connect failure: ".mysqli_connect_error());
    }

    echo "success";
?>