<?php
header('p3p: CP="ALL DSP COR PSAa PSDa OUR NOR ONL UNI COM NAV"');
ob_start();
session_start();
set_time_limit(0);
ini_set("display_errors", 1);
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
error_reporting(E_ALL);
require 'config.php';
require 'shopify.php';
// require_once 'database_config.php';
$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], $api_key, $secret);
$_Company_name    ='';
$_Order_threshold ='';
$_Rate_Abv_Ord   ='';
$_Rate_Blw_Ord    ='';
$shopURL='https://'.$_SESSION['shop'];
$BaseUrl='http://esoftappslive.com/willson/';
try
{
    echo 'demo';

                        echo "<pre>";
                        print_r($sc) ;
                        echo "</pre>";

                         // create a new order webhook
              $Url='/admin/webhooks.json?address='.$BaseUrl.'new_order.php';
              $getWebhookOrder=$sc->call('GET',$Url);
              echo "<pre>";
              print_r($Url);
              print_r($getWebhookOrder);
              echo "</pre>";
              if(empty($getWebhookOrder))
              {
                   $Url=$BaseUrl."new_order.php";
                   $orderhook = array("webhook"=>array(
                                           "topic"=>"orders/create",
                                           "address"=>$Url,
                                           "format"=>"json"
                                          )
                                  );

                    // echo json_encode($orderhook);

                  $orderWeb = $sc->call('POST','/admin/webhooks.json',$orderhook);
              }
              else
              {
                echo 'order webhook';
              }

                $tax_service_request_url='/admin/tax_services.json';
                $request_array=$sc->call('GET',$tax_service_request_url);
                var_dump($request_array);

        
                        $data=array
                             (
                                  "tax_service"=>array
                                  (
                                    "name"=> "Willson Tax Service",
            						"url"=> "https://esoftappslive.com/andrew/retrieve_tax_service.php"
                                  )
                             ); 

                      

                if(empty($request_array)){
                    echo 'working';
                    $text_test = $sc->call('POST','/admin/tax_services.json',$data);
                }
                else
                {
                    echo 'not';
                }
                       

}
catch (ShopifyApiException $e)
{
    echo "exception<pre>";
    var_dump($e->getMethod());// -> http method (GET, POST, PUT, DELETE)
    var_dump($e->getPath());// -> path of failing request
    var_dump($e->getResponseHeaders());// -> actually response headers from failing request
    var_dump($e->getResponse());// -> curl response object
    var_dump($e->getParams());// -> optional data that may have been passed that caused the failure
}

?>

<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>




    <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
    <!-- <script src="https://cdn.shopify.com/s/assets/external/app.js"></script> -->
    
<script type="text/javascript">
    ShopifyApp.init({
        apiKey: '<?php echo SHOPIFY_API_KEY; ?>',
        shopOrigin:"<?php echo $shopURL; ?>",

        debug: true
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
