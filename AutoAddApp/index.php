<?php
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
         
         /* Create a text file */ 
         $filename='tmp/my_file'.date("F")."-".date("d").'.txt';
         chmod($filename, 0777);
         $filename1 = fopen($filename, "w+") or die("Unable to open file!");
         $row= "<script>
              function myfunction()
              { 
                alert('hello'); 
              }
              myfunction();
              </script>";

        
        fwrite($filename1,$row);
        $data=file_get_contents($filename);
        
        $encoded_file = base64_encode($data);
        //echo $encoded_file;
        $snippet = array("asset"=>array("key"=>"snippets/mysnippet.liquid","attachment"=>$encoded_file));
        $gettheme=$sc->call('GET','/admin/themes.json');
        // echo "<pre>";
        // print_r($gettheme);
        // echo "</pre>";

        foreach($gettheme as $value)
        {
          if($value['role'] == 'main')
          {
            $themeid=$value['id'];
          }
        }

        $create_snippet = $sc->call('PUT','/admin/themes/'.$themeid.'/assets.json',$snippet);
        

        /* Backup of theme.liquid */
        $backup=array('asset'=>array('key'=>'layout/theme_back.liquid','source_key'=>'layout/theme.liquid'));
        $theme_backup = $sc->call('PUT','/admin/themes/'.$themeid.'/assets.json',$backup);

        /* Get contents of theme.liquid */
        $getcontents= $sc->call('GET','/admin/themes/'.$themeid.'/assets.json?asset[key]=layout/theme.liquid&theme_id=143117318');

        // echo "<pre>";
        // print_r($getcontents);
        // echo "</pre>";

        //file_put_contents($filename,$getcontents['value']);

        $updated=str_replace("</body>","{% include 'mysnippet' %}</body>",$getcontents['value']);
        file_put_contents($filename,$updated);
        
        $newdata=base64_encode($updated);
        $embed=array('asset'=>array('key'=>'layout/theme.liquid','attachment'=>$newdata));
        $update= $sc->call('PUT','/admin/themes/'.$themeid.'/assets.json',$embed);
      
        echo "<pre>";
        var_dump($update);
        echo "</pre>";
                    
    }
            catch (ShopifyApiException $e)
    {
    
         // var_dump($e->getMethod());// -> http method (GET, POST, PUT, DELETE)
         // var_dump($e->getPath());// -> path of failing request
        // var_dump($e->getResponseHeaders());// -> actually response headers from failing request
         var_dump($e->getResponse());// -> curl response object
        // var_dump($e->getParams());// -> optional data that may have been passed that caused the failure
    
    }

?>



<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
    <head>
     
     
<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


    </head>
    <body>
    <script>
      
    </script>
        
        <script>
            $(function () {
                // Init page helpers (Slick Slider plugin)
                App.initHelpers('slick');
            });
        </script>
         <script type="text/javascript">
    ShopifyApp.init({
      apiKey: '<?php echo $api_key; ?>',
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