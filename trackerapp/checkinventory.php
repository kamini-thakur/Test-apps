<?php
session_start();
require "keys.php";
require 'shopify.php';

?>

<?php
include("config.php");
$domain=$_SESSION['shop'];
if(isset($_POST['check']))
{
	$quantity=$_POST['quantity'];
	
	$sql="SELECT * from inventory where shop_domain='$domain' ";
	$qex=mysqli_query($con,$sql);
	$num_rows=mysqli_num_rows($qex);
	
	if($num_rows==0)
	{
		$sql1="INSERT INTO inventory(shop_domain,quantity)VALUES('".$domain."','".$quantity."')";
		$qex=mysqli_query($con,$sql1);
		
	}
	else
	{
		$sql1="UPDATE inventory SET quantity=$quantity WHERE shop_domain='$domain'";
		$qex1=mysqli_query($con,$sql1);
	}
	
}

 $sql2="SELECT * from inventory where shop_domain='$domain' ";
	$qex=mysqli_query($con,$sql2);
	$res=mysqli_fetch_array($qex);


?>

<?php 
session_start();
//$sb = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], $api_key, $secret);
//$getproduct1= $sb->call('GET','/admin/products.json');
//$getshop=$sb->call('GET','/admin/shop.json');
echo "<pre>";
//print_r($getshop);
//print_r($getproduct1);
echo "</pre>";
//$domain=$getshop['domain'];
?>


<html>
<head>
	


</head>
<body>
<h2>Enter a value</h2>
<form method="post" action="#">
	<input type="number" min="0" id="quantity" name="quantity" value="<?php echo $res['quantity'] ?>">
	<input type="submit" value="check" name="check"><br><br>
</form>
<a href="index.php">Back to dashboard</a>
</body>
</html>