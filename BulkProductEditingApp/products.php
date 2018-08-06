<?php
include('includes/header.php');
include('myshopify.php');
require 'config.php';

echo '<h3>Set conditions to find products for editing</h3>';

$request_type = 'GET';
$resource_type ='/admin/custom_collections.json';
//$resource_type='/admin/products.json?collection_id=333052678.json';
$data_string ="";

$collections =  initiate_request($url,$request_type,$resource_type,$data_string);
echo "<pre>";
print_r($collections);
echo "</pre>";

echo "<h5>Collection is:</h5><select id='myselect'>";
foreach($collections['custom_collections'] as $key=>$v)
{
		echo "<option value=".$v['id'].">".$v['title']."</option>";	
}
echo "</select>";

?>
<button id="ClickProduct" class="btn btn-info">Preview matched products</button>
<hr>

<div id="prod">

<?php
if(isset($_GET['collectionsId']))
{
	echo '<h3>Preview products matching your conditions:</h3>';
	$collectionId = $_GET['collectionsId'];
	//echo 'HELLO'.$collectionId;
	$request_type = 'GET';
	$resource_type='/admin/products.json?collection_id='.$collectionId.'.json';
	$data_string ="";

	$collectionProd =  initiate_request($url,$request_type,$resource_type,$data_string);
	// echo "<pre>";
	// print_r($collectionProd);
	// echo "</pre>";
	echo '<table class="table table-striped"><tr><th></th><th>Title</th><th>Price</th><th>Inventory Quantity</th></tr>';
	$product = array();
	foreach($collectionProd['products'] as $key=>$val)
	{
		echo '<tr><td><img src="'.$val['images'][0]['src'].'" height="50px" width="50px"></td>';
		$product[]=$val['variants'][0]['id'];
		echo '<td>'.$val['title'].'</td>';
		echo '<td>'.$val['variants'][0]['price'].'</td>';
		echo '<td>'.$val['variants'][0]['inventory_quantity'].'</td></tr>';
	}
	echo '</table>';
}

?>
</div>
<hr>
<div class="productEdit" style="display: none;">
	<h3>Edit matching products:</h3>
	
	<p>Change price to <input type="text" name="ChangePrice" id="ChangePrice"> % of the current price</p>  <button type="submit" class="update" name='update'>Update</button>
	
</div>
<?php
	
if(isset($_GET['updateQuantity']))
{
	$newPrice = $_GET['updateQuantity'];
	echo 'new price'.$newPrice;
	foreach($product as $varId)
	{
		//echo $value.'<br>';
		$variantData = array("variant"=>array("id"=>$varId,"inventory_quantity_adjustment"=> -$newPrice));

		  $request_type = 'PUT';
		  $resource_type = '/admin/variants/'.$varId.'.json';

		  $data_string = json_encode($variantData);
		  $updateQuantity =  initiate_request($url,$request_type,$resource_type,$data_string);
	} 
	echo '<pre>';
	print_r($collectionProd);
	echo '</pre>';
}	
  


	?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body>

<script type="text/javascript">
$(document).ready(function(){
 $('#ClickProduct').on('click',function(e){
   e.preventDefault();
   //var action=$( "#myselect option:selected" ).text();
   var actionId=$( "#myselect option:selected" ).val();
  // alert(actionId);
  
   $.ajax({
              url:"products.php",
              type:"GET",
              data: { collectionsId : actionId  },
                  
              success: function(response){
              		
                    $("body").html(response); 
                     $('.productEdit').css('display','block');
              }
    });
   });
   $('.update').on('click',function(e){
   		 var newPrice=$( "#ChangePrice" ).val();
   		 alert(newPrice);
   		  $.ajax({
              url:"products.php",
              type:"GET",
              data: { updateQuantity : newPrice  },
                  
              success: function(response){
              		
                   // $("body").html(response); 
                   
              }
    });
   });
});
</script>
</body>
</html>