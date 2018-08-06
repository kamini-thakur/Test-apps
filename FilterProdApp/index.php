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
include("database_config.php");
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
            $getproduct= $sc->call('GET','/admin/products.json');
            // echo "<pre>";
            // print_r($getproduct);
            // echo "</pre>"; 
            // foreach($getproduct as $v)
            // {

            //     if($v['tags']== 's' )
            //     {
            //         print_r($v['title'].'<br>');
            //     }
            // }   

              
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



<table class="table table-striped" border="1">
    <tr><th>Tag name</th><th>Select date and time</th><th>Action</th></tr>
    <tr><td>
    <select id="selecttag">
        <option value="s">s</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
    </select> 
    </td>
    <td>
        <div id="datetimepicker" class="input-append date">
          <input type="text" id="datetime"></input>
          <span class="add-on">
            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
          </span>
        </div>
    </td>
    <td>
        <button class="btn btn-primary" id="publish" type="submit" value="publish">Publish</button>
        <button class="btn btn-primary" id="unpublish" type="submit" value="unpublish">Unpublish</button>  
    </td></tr>
    </table>


<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
    <head>
     <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>

     <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>

   <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
  
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    </head>
    <body>

        <script type="text/javascript">
         $(document).ready(function(){
              $('#datetimepicker').datetimepicker({
               format: 'MM/dd/yyyy hh:mm:ss',
                language: 'en',
              });
             $('#publish').click(function(){
                  var tagselected = $("#selecttag :selected").text();
                  //alert(tagselected);
                  var datetimevalue = $('#datetime').val();
                  var action = $('#publish').val();
                  $.ajax({
                    url:"insertdata.php",
                    type:"POST",
                    data:{'tagname': tagselected, 'datetime': datetimevalue, 'action' : action},
                  
                    success: function(response){
                         //alert(response);
                    }
                  });
              });
          });
        </script>

        <script>
            // $(function () {
            //     // Init page helpers (Slick Slider plugin)
            //     App.initHelpers('slick');
            // });
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