<?php
//ini_set('display_errors', 1);
//ini_set('error_reporting', 'E_ALL');

ini_set("max_execution_time", "60");

	//header('HTTP/1.0 200 OK');


if (!function_exists('http_response_code'))
{
    function http_response_code($newcode = NULL)
    {
        static $code = 200;
        if($newcode !== NULL)
        {
            header('X-PHP-Response-Code: '.$newcode, true, $newcode);
            if(!headers_sent())
                $code = $newcode;
        }       
        return $code;
    }
}

http_response_code(200);

	include('myshopify.php');
  include('includes/header.php');
  // include('includes/footer.php');
	require 'config.php';
	
  
echo '<a href="products.php"><button type="button" class="choose btn btn-primary" value="Inventory & shipping">Inventory & shipping</button></a>
<a href="products.php"><button type="button" class="choose btn btn-success" value="Price">Price</button></a>
<a href="products.php"><button type="button" class="choose btn btn-info" value="Product Type">Product Type</button></a>
<a href="products.php"><button type="button" class="choose btn btn-warning" value="Tag">Tag</button></a>
<a href="products.php"><button type="button" class="choose btn btn-danger" value="Title">Title</button></a>';
  /* Code to get all product data goes here*/

  $request_type = 'GET';
 	$resource_type ='/admin/products.json';
 	$data_string ="";


	$products_list =  initiate_request($url,$request_type,$resource_type,$data_string);
	// echo "<pre>";
	// print_r($products_list);
	// echo "</pre>";

  /*
	foreach ($products_list as $value) {

    foreach ($value as $key1=> $val) {
	      $prod_title = $val['title'];
        echo $prod_title;
        if($prod_title == 'Caseback')
        {   
            echo $prod_title;
            foreach($val['variants'] as $v1)
            {
               echo $variant_id=$v1['id'];
              $quantity=$v1["inventory_quantity"];
            }

        } 		    
    }
 } */
/*--------ends here---------*/

/* Code to update product variant quantity goes here ===40mm */
/*
if($count40mm)
{
  $variantData = array("variant"=>array("id"=>$varId40mm,"inventory_quantity_adjustment"=> -$count40mm));

  $request_type = 'PUT';
  $resource_type = '/admin/variants/'.$varId40mm.'.json';

  $data_string = json_encode($variantData);
  $updateQuantity =  initiate_request($url,$request_type,$resource_type,$data_string);
  fwrite($fh, json_encode($updateQuantity));
} */
/*--------ends here---------*/


/* Code to update product variant quantity goes here ===34mm */
/*
if($count34mm)
{
  $variantData = array("variant"=>array("id"=>$varId34mm,"inventory_quantity_adjustment"=> -$count34mm));

  $request_type = 'PUT';
  $resource_type = '/admin/variants/'.$varId34mm.'.json';

  $data_string = json_encode($variantData);
  $updateQuantity =  initiate_request($url,$request_type,$resource_type,$data_string);
  fwrite($fh, json_encode($updateQuantity));
}   */
/*--------ends here---------*/

  ?>

 