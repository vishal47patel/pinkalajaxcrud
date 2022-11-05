<?php
$server="localhost";
$username ="root";
$password ="123456";
$dbname="database";

$con = mysqli_connect($server,$username,$password,$dbname);
if(!$con){
    die ("Connection failed: " .mysqli_connect_error());

}
?>