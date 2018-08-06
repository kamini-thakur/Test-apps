
<?php
header('p3p: CP="ALL DSP COR PSAa PSDa OUR NOR ONL UNI COM NAV"');
ob_start();
session_start();
set_time_limit(0);
ini_set("display_errors", 1);
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
error_reporting(E_ALL);
require_once("class.phpmailer.php");
include("class.smtp.php");
require 'keys.php';
require 'shopify.php';
include("config.php");

$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], $api_key, $secret);
$_Company_name    ='';
$_Order_threshold ='';
$_Rate_Abv_Ord   ='';
$_Rate_Blw_Ord    ='';
$shopURL='https://'.$_SESSION['shop'];
$domain=$_SESSION['shop'];
/*=============fetch database values=============*/
$sql2="SELECT * from inventory where shop_domain='$domain' ";
$qex=mysqli_query($con,$sql2);
$res=mysqli_fetch_array($qex);

/*=============create csv file=============*/

$filename='tmp/lowquantity'.date("F")."-".date("d").'.csv';
chmod($filename, 0777);  
$filename1 = fopen($filename, "w+") or die("Unable to open file!");
$header = array("Title","Quantity");
fwrite($filename1 , implode(",",$header)."\n");
$rows=array();
/*=============write data to csv if quantity is low==============*/
 
 function create_csv($rows,$filename1)
 {
    fwrite($filename1 , implode(",",$rows)."\n");
 } 

try
    {

            echo "<pre>";
            var_dump($sc);
            echo "</pre>";  

          /*=============Get all shop products details==============*/
          $getproduct= $sc->call('GET','/admin/products.json');
           //$getproduct= $sc->call('GET','/admin/products.json?limit=20&page=2');
          //echo "<pre>";
          //print_r($getproduct);
          //echo "</pre>";
          echo "<script>document.writeln(day+'-'+hour+'-'+min+'-'+sec);</script>";
          $day="<script>document.writeln(day);</script>";
          $hour="<script>document.writeln(hour);</script>";
          $min="<script>document.writeln(min);</script>";
          $sec="<script>document.writeln(sec);</script>";
          

              //$cur_page=$_GET['page'];
           $count = $sc->call('GET', '/admin/products/count.json');
          
            $page_size = 20;

          $pages = ceil($count / $page_size); 
          $cur_page=1;
           
          if(isset($_GET['page']))
          {
            $cur_page = $_GET['page'];
            //echo "php".$cur_page;
            $getproduct = $sc->call('GET', '/admin/products.json?limit=20&page='.$cur_page);
          }
          else
          {
              $getproduct = $sc->call('GET', '/admin/products.json?limit=20&page='.$cur_page);
          }
         

?>

<h4>Your timing starts now:</h4>
<h2 id="timer">00:00:00</h2>

<ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="index.php">Dashboard</a></li>
  <li role="presentation"><a href="checkinventory.php">Settings</a></li>
</ul>
<?php /*===========Dumping all products data into table=========*/ ?>
<?php $flag=0; ?>
<table border="1" class="table table-striped">
    <tr><td>Title</td><td>Variant title</td><td>Quantity</td><td>Status</td></tr>       
    <?php
    foreach($getproduct as $v)
    {        
      ?>
       <tr><td><?php echo $v["title"] ?></td>
        <?php
        if(count($v['variants'])>1)
        { ?>
            
            <?php $count=0;
            foreach($v["variants"] as $v1)
            { 
              if($count!=0)
              {  ?>
                 <td></td>
             <?php
              }
              ?>
                
               <td><?php echo $v1["title"] ?></td>
                <td><?php echo $v1["inventory_quantity"] ?></td>
                <td><?php
                    if(($v1['inventory_quantity']) <= ($res['quantity']))
                    {
                        echo "low" ;
                        $rows[]=$v['title']."/".$v1["title"];
                        $rows[]=$v1["inventory_quantity"]; 
                        create_csv($rows,$filename1);
                        $rows=array();  
                        $flag=1;
                    }

                    ?>
                </td></tr>
           <?php
             $count++;
            }
        }
        else
        {  ?>
          <td></td>
          <td><?php echo $v["variants"][0]["inventory_quantity"] ?></td>
          <td><?php
                  if(($v["variants"][0]["inventory_quantity"]) <= ($res['quantity']))
                  {
                      echo "low" ;
                      $rows[]=$v['title'];
                      $rows[]=$v["variants"][0]['inventory_quantity']; 
                      create_csv($rows,$filename1);
                      $rows=array();  
                      $flag=1;
                  }
                  ?>
          </td></tr>
          <?php
        }
        
    }
    ?>
</table>

        <?php

        if($cur_page>1)
        {
        ?>

        <button class="next"  value-id="<?php echo $cur_page-1 ?>" > Prev </button>

        <?php
        }
        if($cur_page < $pages)
        {  ?>

        <button class="next" value-id="<?php echo $cur_page+1 ?>" > Next </button> 

    <?php  }  ?>

 <?php



      
fclose($filename1); 
/*===============writing data to csv finished here==============*/
 
/*================Get shop owners detail=================*/
$getshop=$sc->call('GET','/admin/shop.json');
// echo "<pre>";
// print_r($getshop);
// echo "</pre>";
$name=$getshop['name'];
$email=$getshop['email'];

/*================sending email when stock finish=================*/

if($flag==1)
{
    $mail = new PHPMailer();
    $body             = "Hello $name,  Your stock finished";

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host       = "smtp.gmail.com"; // SMTP server
    $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                               // 1 = errors and messages
                                               // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Host       = "smtp.gmail.com"; // sets the SMTP server
    $mail->Port       = 587;                    // set the SMTP port for the GMAIL server
    $mail->Username   = "testmail.esfera@gmail.com"; // SMTP account username
    $mail->Password   = "esfera123";        // SMTP account password

    $mail->Subject    = "Less Inventory";
    $mail->MsgHTML($body);

    $address = $email;;
    $mail->AddAddress($address);
    //$mail->AddAddress("amardeep_singh@esferasoft.com");
    $mail->AddAttachment($filename);
    
    if(!$mail->Send()) {
     echo "Mailer Error: " . $mail->ErrorInfo;
    } else 
    {
      echo "Message sent!";
    } 
}

/*================sending email process finished here=================*/
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


 




<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
    <head>


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




    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    
      
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<style type="text/css">

.red{
  color:red;
  font-size:25px;
}
.day{
  color:black;
  font-size:25px;
}
.hour{
  color:brown;
  font-size:25px;
}
.min{
  color:blue;
  font-size:25px;
}
.sec{
  color:green;
  font-size:25px;
}
</style>

</head>

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
  <script type="text/javascript">
        $(document).ready(function(){
          $('.next').on('click',function(event){
            
            event.preventDefault();
              $cur_page=$(this).attr('value-id');
              //alert($cur_page);
              $.ajax({
                  url:"index.php?limit=20",
                  type:"GET",
                  data:"page="+$cur_page,
                  
                  success: function(response){
                        $("body").html(response); 
                  }

              });
          });
        });
</script>
<script>
   // window.onload = function(){

   //   var min = 90;
   //   var sec = 00;
   //   t=setInterval(function(){

   //     document.getElementById("timer").innerHTML = min +" : " + sec ;
       
   //     if(sec == 00)
   //     {
   //        if (min == 0)
   //       {
   //            //alert(t);
   //            clearInterval(t);
   //            alert("Your time finish now");
   //       }
   //       else
   //       {
   //         min--;
   //         sec = 60;
   //       }
         
   //     }

   //     sec--;
   //    },1000);
   //  }



/*
   window.onload = function(){
     var day = 0; 
     var hour = 1; 
     var min = 1;
     var sec = 0;
     t=setInterval(function(){

      if(hour==0 && day == 0)
      {
          document.getElementById("timer").innerHTML = 
       '<span class="red">'+day+'</span>:<span class="red">'+hour+'</span>:<span class="red">'+min+'</span>:<span class="red">'+sec+'</span>';
      }
      else
      {
       document.getElementById("timer").innerHTML = 
       '<span class="day">'+day+'</span>:<span class="hour">'+hour+'</span>:<span class="min">'+min+'</span>:<span class="sec">'+sec+'</span>';
      }

       if(day == 0 && hour == 0 && min==0 && sec == 0)
       {
            clearInterval(t);
            alert("Your time finish now");
       }
       if(sec==0)
       {
         if(day!=0 && hour==0 && min==0)
         {
            day--;
            hour=24;
         }
         if(hour!=0 && min==0)
         {
            hour--;
            min=60;
         }
         if(min!=0 && sec==0)
         {
            min--;
            sec=60;
         }
       }
       sec--;
      },400);
    }
*/
</script> 

  
</body>
 
</html>