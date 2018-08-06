<?php
session_start();
require "keys.php";
require 'shopify.php';
include("database_config.php");


$tagname=$_POST['tagname'];
$datetime=$_POST['datetime'];
$action=$_POST['action'];
$sql="INSERT INTO FilterProducts(tag_name,date_time,action)VALUES('".$tagname."','".$datetime."','".$action."')";
$qex=mysqli_query($con,$sql);
	


?>


