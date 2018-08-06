<?php
header('p3p: CP="ALL DSP COR PSAa PSDa OUR NOR ONL UNI COM NAV"');
ob_start();
session_start();
set_time_limit(0);
ini_set("display_errors", 1);
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
error_reporting(E_ALL);
require 'key.php';
require 'shopify.php';
require_once 'database_config.php';
$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], $api_key, $secret);
$_Company_name    ='';
$_Order_threshold ='';
$_Rate_Abv_Ord   ='';
$_Rate_Blw_Ord    ='';
$shopURL='https://'.$_SESSION['shop'];
try
    {

                if(isset($_GET['id']))
                     	 {
                     	 	if(is_int((int)$_GET['id']))
                     	 	{
                     	 		$query="Select * from `Shipping Look Up` where `id`='".(int)$_GET['id']."'";
                     	 			$arr              =mysqli_query($con,$query);
		                            $res              =mysqli_fetch_assoc($arr);
		                            $_Company_name    =$res['CompanyName'];
		                            $_Order_threshold =$res['Order_Threshold'];
		                            $_Rate_Blw_Ord    =$res['rate_blw_thresh'];
		                            $_Rate_Abv_Ord    =$res['rate_abv_thresh'];
                     	 	}
                     	 }
            /* GET /admin/carrier_services/#{id}.json */
                  $shipping_service_request_url='/admin/carrier_services.json';
                  $request_array=$sc->call('GET',$shipping_service_request_url);
                  //var_dump($request_array);
                  $url='/admin/carrier_services.json';
                  $meta=array
                       (
                            "carrier_service"=>array
                            (
                              "name"=> "Shipping Service",
                              "callback_url"=> "http://esoftappslive.com/shopify/shippo/retrieve_shipping_rate_calc_new.php",
                              "format"=> "json",
                              "service_discovery"=> true
                             
                            )
                       );                              
           
                   
                    if(empty($request_array))
                       {
                      var_dump($sc->call('POST', $url,$meta));
                        }


               /* call to database to edit values */

                     

               /*                                 */
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
        <meta charset="utf-8">

        <title>Shippo : The ultimate Shipping APP</title>

        <meta name="description" content="OneUI - Admin Dashboard Template & UI Framework created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="assets/img/favicons/favicon.png">

        <link rel="icon" type="image/png" href="assets/img/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="assets/img/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="assets/img/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="assets/img/favicons/favicon-160x160.png" sizes="160x160">
        <link rel="icon" type="image/png" href="assets/img/favicons/favicon-192x192.png" sizes="192x192">

        <link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon-180x180.png">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Web fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">

        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="assets/js/plugins/slick/slick.min.css">
        <link rel="stylesheet" href="assets/js/plugins/slick/slick-theme.min.css">

        <!-- OneUI CSS framework -->
        <link rel="stylesheet" id="css-main" href="assets/css/oneui.css">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
        <!-- END Stylesheets -->
    </head>
    <body>
        <!-- Page Container -->
        <!--
            Available Classes:

            'sidebar-l'                  Left Sidebar and right Side Overlay
            'sidebar-r'                  Right Sidebar and left Side Overlay
            'sidebar-mini'               Mini hoverable Sidebar (> 991px)
            'sidebar-o'                  Visible Sidebar by default (> 991px)
            'sidebar-o-xs'               Visible Sidebar by default (< 992px)

            'side-overlay-hover'         Hoverable Side Overlay (> 991px)
            'side-overlay-o'             Visible Side Overlay by default (> 991px)

            'side-scroll'                Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (> 991px)

            'header-navbar-fixed'        Enables fixed header
        -->
        <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
            <!-- Side Overlay-->
            <aside id="side-overlay">
                <!-- Side Overlay Scroll Container -->
                <div id="side-overlay-scroll">
                    <!-- Side Header -->
                    <div class="side-header side-content">
                        <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                        <button class="btn btn-default pull-right" type="button" data-toggle="layout" data-action="side_overlay_close">
                            <i class="fa fa-times"></i>
                        </button>
                        <span>
                            <img class="img-avatar img-avatar32" src="assets/img/avatars/avatar10.jpg" alt="">
                            <span class="font-w600 push-10-l">Roger Hart</span>
                        </span>
                    </div>
                    <!-- END Side Header -->

                    <!-- Side Content -->
                    <div class="side-content remove-padding-t">
                        <!-- Notifications -->
                        <div class="block pull-r-l">
                            <div class="block-header bg-gray-lighter">
                                <ul class="block-options">
                                    <li>
                                        <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                    </li>
                                    <li>
                                        <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                                    </li>
                                </ul>
                                <h3 class="block-title">Recent Activity</h3>
                            </div>
                            <div class="block-content">
                                <!-- Activity List -->
                                <ul class="list list-activity">
                                    <li>
                                        <i class="si si-wallet text-success"></i>
                                        <div class="font-w600">New sale ($15)</div>
                                        <div><a href="javascript:void(0)">Admin Template</a></div>
                                        <div><small class="text-muted">3 min ago</small></div>
                                    </li>
                                    <li>
                                        <i class="si si-pencil text-info"></i>
                                        <div class="font-w600">You edited the file</div>
                                        <div><a href="javascript:void(0)"><i class="fa fa-file-text-o"></i> Documentation.doc</a></div>
                                        <div><small class="text-muted">15 min ago</small></div>
                                    </li>
                                    <li>
                                        <i class="si si-close text-danger"></i>
                                        <div class="font-w600">Project deleted</div>
                                        <div><a href="javascript:void(0)">Line Icon Set</a></div>
                                        <div><small class="text-muted">4 hours ago</small></div>
                                    </li>
                                    <li>
                                        <i class="si si-wrench text-warning"></i>
                                        <div class="font-w600">Core v2.5 is available</div>
                                        <div><a href="javascript:void(0)">Update now</a></div>
                                        <div><small class="text-muted">6 hours ago</small></div>
                                    </li>
                                </ul>
                                <div class="text-center">
                                    <small><a href="javascript:void(0)">Load More..</a></small>
                                </div>
                                <!-- END Activity List -->
                            </div>
                        </div>
                        <!-- END Notifications -->

                        <!-- Online Friends -->
                        <div class="block pull-r-l">
                            <div class="block-header bg-gray-lighter">
                                <ul class="block-options">
                                    <li>
                                        <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                    </li>
                                    <li>
                                        <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                                    </li>
                                </ul>
                                <h3 class="block-title">Online Friends</h3>
                            </div>
                            <div class="block-content block-content-full">
                                <!-- Users Navigation -->
                                <ul class="nav-users">
                                    <li>
                                        <a href="base_pages_profile.html">
                                            <img class="img-avatar" src="assets/img/avatars/avatar4.jpg" alt="">
                                            <i class="fa fa-circle text-success"></i> Rebecca Gray
                                            <div class="font-w400 text-muted"><small>Copywriter</small></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="base_pages_profile.html">
                                            <img class="img-avatar" src="assets/img/avatars/avatar10.jpg" alt="">
                                            <i class="fa fa-circle text-success"></i> Dennis Ross
                                            <div class="font-w400 text-muted"><small>Web Developer</small></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="base_pages_profile.html">
                                            <img class="img-avatar" src="assets/img/avatars/avatar6.jpg" alt="">
                                            <i class="fa fa-circle text-success"></i> Denise Watson
                                            <div class="font-w400 text-muted"><small>Web Designer</small></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="base_pages_profile.html">
                                            <img class="img-avatar" src="assets/img/avatars/avatar1.jpg" alt="">
                                            <i class="fa fa-circle text-warning"></i> Denise Watson
                                            <div class="font-w400 text-muted"><small>Photographer</small></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="base_pages_profile.html">
                                            <img class="img-avatar" src="assets/img/avatars/avatar10.jpg" alt="">
                                            <i class="fa fa-circle text-warning"></i> John Parker
                                            <div class="font-w400 text-muted"><small>Graphic Designer</small></div>
                                        </a>
                                    </li>
                                </ul>
                                <!-- END Users Navigation -->
                            </div>
                        </div>
                        <!-- END Online Friends -->

                       

                            </div>
                        </div>
                        <!-- END Quick Settings -->
                  
                    <!-- END Side Content -->
              
                <!-- END Side Overlay Scroll Container -->
            </aside>
            <!-- END Side Overlay -->

            <!-- Sidebar -->
            <nav id="sidebar">
                <!-- Sidebar Scroll Container -->
                <div id="sidebar-scroll">
                    <!-- Sidebar Content -->
                    <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
                    <div class="sidebar-content">
                        <!-- Side Header -->
                        <div class="side-header side-content bg-white-op">
                            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                            <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times"></i>
                            </button>
                            <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                            
                            <a class="h5 text-white" href="index.html">
                               <span class="h4 font-w600 sidebar-mini-hide">Shipp</span> <i class="fa fa-circle-o-notch text-primary"></i> 
                            </a>
                        </div>
                        <!-- END Side Header -->

                        <!-- Side Content -->
                        <div class="side-content">
                            <ul class="nav-main">
                                <li>
                                    <a class="active" href="index.php"><i class="si si-speedometer"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                                </li>
                                <li class="nav-main-heading"><span class="sidebar-mini-hide">User Interface</span></li>
                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="rate_look_up.php"><i class="si si-badge"></i><span class="sidebar-mini-hide">Shipping Rate Look Up</span></a>
                                    
                                </li>
                                
                                
                               
                                    </ul>
                                </li>
                                
                                        </li>
                                    </ul>
                                </li>
                                
                            </ul>
                        </div>
                        <!-- END Side Content -->
                    </div>
                    <!-- Sidebar Content -->
                </div>
                <!-- END Sidebar Scroll Container -->
            </nav>
            <!-- END Sidebar -->
 

          

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Header -->
                 <div class="row">
                        <div class="col-lg-8">
                <div class="content bg-image overflow-hidden" >
                 <h1> Add Shipping Rates </h1>
                    <form method="POST" action="updateDatabase.php">
                     <fieldset class="form-group">
                        <label for="exampleInputEmail1">Enter Company Name :</label>
                        <input required="true" type="text" class="form-control" name="Shippo_Company_Name" value="<?php echo $_Company_name ?>" placeholder="Shippo_Company_Name">                
                     </fieldset>

                      <fieldset class="form-group">
                        <label for="exampleInputEmail1">Enter Order Value to Match :</label>
                        <input required="true" type="text" class="form-control" type="text" name="Shippo_Order_Val" value="<?php echo $_Order_threshold; ?>" placeholder="Shippo_Order_Val">                
                      </fieldset>

                      <fieldset class="form-group">
                        <label for="exampleInputEmail1">Enter Shipping rate above Order Value :</label>
                        <input required="true" type="text" class="form-control" name="Shippo_Rate_Above_Order" value="<?php echo $_Rate_Abv_Ord; ?>" placeholder="Shippo_Rate_Above_Order">                
                      </fieldset>

                      <fieldset class="form-group">
                        <label for="exampleInputEmail1">Enter Shipping rate below or Equal to Order Value :</label>
                        <input required="true" type="text" class="form-control" name="Shippo_Rate_below_Order" value="<?php echo $_Rate_Blw_Ord; ?>" placeholder="Shippo_Rate_below_Order">                        
                      </fieldset>
                      <fieldset class="form-group">
                      <?php if(isset($_GET['id']))
                            {
                            	if (!empty($_GET['id'])) {
                            		 if(is_int((int)$_GET['id']))
                            		 {
                            		 	?>
                            		 <input type="hidden" name="company_id" value="<?php echo $_GET['id']; ?>" />
                                     <input type="submit" name="update_shipping_rate" value="Update" class="btn btn-primary">
                            		 	<?php
                            		 }

                            		# code...
                            	}
                            }
                            else
                            		 {
                            		 	?>
                            		 	  <button type="submit" class="btn btn-primary">Submit</button>
                            		 	<?php
                            		 }
                            ?>
                   
                      </fieldset>
                 </form>
                </div>
                </div>
                </div>
                <!-- END Page Header -->

               
                

            </main>
            <!-- END Main Container -->
            </div>

            <!-- Footer -->
            <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
                <div class="pull-right">
                    Crafted with <i class="fa fa-heart text-city"></i> by <a class="font-w600" href="http://goo.gl/QjnNmj" target="_blank">Esferasoft</a>
                </div>
                <div class="pull-left">
                    <a class="font-w600" href="javascript:void(0)" target="_blank">OneUI 1.0</a> &copy; <span class="js-year-copy"></span>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->


        

        <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
        <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
        <script src="assets/js/core/jquery.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>
        <script src="assets/js/core/jquery.slimscroll.min.js"></script>
        <script src="assets/js/core/jquery.scrollLock.min.js"></script>
        <script src="assets/js/core/jquery.appear.min.js"></script>
        <script src="assets/js/core/jquery.countTo.min.js"></script>
        <script src="assets/js/core/jquery.placeholder.min.js"></script>
        <script src="assets/js/core/js.cookie.min.js"></script>
        <script src="assets/js/app.js"></script>

        <!-- Page Plugins -->
        <script src="assets/js/plugins/slick/slick.min.js"></script>
        <script src="assets/js/plugins/chartjs/Chart.min.js"></script>

        <!-- Page JS Code -->
        <script src="assets/js/pages/base_pages_dashboard.js"></script>
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