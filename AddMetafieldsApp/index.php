<?php
//include("addmetafield.php");

header('p3p: CP="ALL DSP COR PSAa PSDa OUR NOR ONL UNI COM NAV"');
ob_start();
session_start();
set_time_limit(0);
ini_set("display_errors", 1);
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
error_reporting(E_ALL);
require 'keys.php';
require 'shopify.php';
//require_once 'database_config.php';
$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], $api_key, $secret);
//echo $sc -> $_SESSION['shop'];
//echo $sc -> $_SESSION['token'];

$_Company_name    ='';
$_Order_threshold ='';
$_Rate_Abv_Ord   ='';
$_Rate_Blw_Ord    ='';
$shopURL='https://'.$_SESSION['shop'];
try
    {
           

echo "<pre>";
var_dump($sc);
echo "</pre>";
//$products = $sc->call('GET','/admin/products.json');
//echo "<pre>";
//var_dump($products);
//echo "</pre>";
$attr = $sc->call('GET','/admin/products.json');
echo "<pre>";
//print_r($attr);
echo "</pre>";
?>
<?php
//$meta = array("metafield"=>array("namespace"=>"inventory","key"=>"warehouse","value"=>"25","value_type"=>"string"));
//$meta = array("metafield"=>array("id"=>"25765333766","value"=>"putdata","value_type"=>"string"));
//echo "<pre>";
//print_r($meta);
//echo "</pre>";
//$encode=json_encode($meta);
//echo $encode;
/*$metafield=$sc->call('POST','/admin/products/7972105030/metafields.json',$meta);
echo "<pre>";
var_dump($metafield);
echo "</pre>";*/

/*$putmeta=$sc->call('PUT','/admin/products/7972105030/metafields/25765333766.json',$meta);
echo "<pre>";
var_dump($putmeta);
echo "</pre>";
*/

?>


<?php

// $metadata=$sc->call('GET','/admin/products/7972105030/metafields.json');
//           // echo "<pre>";
//           // var_dump($metadata);
//           //  echo "</pre>";
//            foreach($metadata as $v)
//             {
//                 //echo $v["id"];
//                 if(($v['namespace']=="qwerty") && ($v['key']=="thakur"))
//                 {
//                    echo $v["id"];echo $v["value"];   
//                 }
//             } 

?>
<script>
/*
function meta($v['id'])
{
  
        $metadata=$sc->call('GET','/admin/products/'.$v['id'].'/metafields.json');
        foreach($metadata as $val)
            {
                
                if(($val['namespace']=="qwerty") && ($val['key']=="thakur"))
                {
                   return echo $val["id"]; echo $val["value"];
                }
            }
}*/
</script>


<table border="1" class="table table-striped">
    <tr><td>Title</td><td>Price</td><td>Add metafield</td></tr>       
    <?php
    foreach($attr as $v)
    {  
      
      ?>
       <tr><td><?php echo $v["title"] ?><?php echo $v["id"] ?></td>
        <?php
        foreach($v["variants"] as $v1)
        { 
          /*
           $metadata=$sc->call('GET','/admin/products/'.$v['id'].'/metafields.json');
        foreach($metadata as $val)
            {
                if(($val['namespace']=="qwerty") && ($val['key']=="thakur"))
                { 
                */
                   //echo $val["id"]; echo $val["value"];

          ?>
        
            <td> <?php echo $v1["price"] ?> </td>
            <td><input type="text" id="<?php echo "val".$v["id"] ?>" value="<?php  ?>"  >
            <input type="submit" value="Add metafeild" class="add" btnid="<?php echo $v["id"] ?>" ></td></tr>
       <?php
         }

    /*  } 
            } */
            
    }  
    ?>
</table>
<?php
//echo $_SESSION['value'];
//onclick="return echo meta($v['id'])"
?>


<?php
    }
    catch (ShopifyApiException $e)
    {
    
         var_dump($e->getMethod());// -> http method (GET, POST, PUT, DELETE)
         var_dump($e->getPath());// -> path of failing request
         var_dump($e->getResponseHeaders());// -> actually response headers from failing request
         var_dump($e->getResponse());// -> curl response object
         var_dump($e->getParams());// -> optional data that may have been passed that caused the failure
    
    }
?>
<?php
/*
include("config.php");
$sql="INSERT INTO shoplogin(shop,token)VALUES('".$_SESSION['shop']."','".$_SESSION['token']."')";
$qex=mysqli_query($con,$sql);
if($qex)
{
    echo "values submitted";
}
else
{
    echo "already exist";
}
*/

?>

<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
    <head>
    
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- Latest compiled and minified CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

      
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

      <!-- Latest compiled and minified JavaScript -->
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

      <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script>
      $(document).ready(function(){
        $(document).on('click', '.add', function(event){
            event.preventDefault();
             var btnid =$(this).attr('btnid');
             var value_id="#val"+btnid;
             var value=$(value_id).val();
             
             if(value)
             {
               alert("Added Successfully");
             }
             else
             {
               alert("Something wrong");
             }
             //alert(value+btnid);

               $.ajax({
                type:"POST",
                
                url:"addmetafield.php",
                data: {'value': value, 'btnid': btnid}, 
               success: function (data) {
                  
                 alert(data);
                 //$('#id').html('data');
                } 

              });
        });
      });
      </script>
      
           
   <script type="text/javascript">
  ShopifyApp.ready(function(){
    ShopifyApp.Bar.initialize({
      
      title: 'ADMIN',
      
          
          callback: function(){ 
            ShopifyApp.Bar.loadingOff();
            
          }
       
      
    });
  });
  </script>
    </body>
</html>