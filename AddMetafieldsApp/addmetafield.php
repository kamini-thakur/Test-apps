
<?php
require 'shopify.php';
require 'keys.php';
session_start();
$sb = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], $api_key, $secret);

var_dump($_POST);

        
        	$value=$_POST['value'];
        	$btnid=$_POST['btnid'];

           // $meta1=array("namespace"=>"kamini","key"=>"vdo","name"=>"pooja");
            //print_r($meta1);
            $meta = array("metafield"=>array("namespace"=>"qwerty","key"=>"thakur","value"=>$value,"value_type"=>"string"));
            //echo "<pre>";
            //print_r($meta);
            //echo "</pre>";
            //$encode=json_encode($meta);
            //echo $encode;
            $metafield=$sb->call('POST','/admin/products/'.$btnid.'/metafields.json',$meta);
            echo "<pre>";
            var_dump($metafield);
            echo "</pre>";

        
           $productmeta=$sb->call('GET','/admin/products/'.$btnid.'/metafields.json');
           // echo "<pre>";
           //var_dump($productmeta);
            //echo "</pre>";
           foreach($productmeta as $v)
            {
                //echo $v["id"];
                if(($v['namespace']=="qwerty") && ($v['key']=="thakur"))
                {
                   echo $v["id"];
                    $_POST['value']=$v['value'];
                    echo $_POST['value']; 
                    $_SESSION['value']=$_POST['value'];
                    //echo $_SESSION['value'];
                }
            } 

?>

