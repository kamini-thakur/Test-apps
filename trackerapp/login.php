<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
ob_start();
session_start();
require_once 'keys.php';

define('SHOPIFY_API_KEY', $api_key);
define('SHOPIFY_SECRET',  $secret);
define('SHOPIFY_SCOPE',  'read_products,write_products,read_themes,write_themes, read_fulfillments, write_fulfillments, read_shipping, write_shipping, write_orders, read_orders');

    require 'shopify.php';
    if (isset($_GET['code'])) { // if the code param has been sent to this page... we are in Step 2
        // Step 2: do a form POST to get the access token
        $shopifyClient = new ShopifyClient($_GET['shop'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
        session_unset();

        // Now, request the token and store it in your session.
        $_SESSION['token'] = $shopifyClient->getAccessToken($_GET['code']);
        $accessToken=$_SESSION['token'];
        $shopURL= $_GET['shop'];
        if ($_SESSION['token'] != '')
            $_SESSION['shop'] = $_GET['shop'];
        $shopURL='https://'.$_SESSION['shop']; ?>
         <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
  
        <script type="text/javascript">
    ShopifyApp.init({
      apiKey: '2aeffdf4b59758dfc081935e9cf7d7d2',
      shopOrigin:"<?php echo $shopURL; ?>",    
      debug: true
    });

    ShopifyApp.Modal.open({
  src: 'index.php',
  title: 'Single Page Order',
  width: 'large',
  height: 500,
  buttons: {
    
}
  });
  </script>
<?php        
header("Location:index.php");
        exit;       
    }
    // if they posted the form with the shop name
    else if (isset($_POST['shop']) || isset($_GET['shop'])) {

  
        // Step 1: get the shopname from the user and redirect the user to the
        // shopify authorization page where they can choose to authorize this app
        $shop = isset($_POST['shop']) ? $_POST['shop'] : $_GET['shop'];
        $shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);

        // get the URL to the current page
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        // redirect to authorize url
        header("Location: " . $shopifyClient->getAuthorizeUrl(SHOPIFY_SCOPE, $pageURL));
        exit;
    }

    // first time to the page, show the form below
?>
    <p>Install this app in a shop to get access to its private admin data.</p> 

    <p style="padding-bottom: 1em;">
        <span class="hint">Don&rsquo;t have a shop to install your app in handy? <a href="https://app.shopify.com/services/partners/api_clients/test_shops">Create a test shop.</a></span>
    </p> 

    <form action="" method="post">
      <label for='shop'><strong>The URL of the Shop</strong> 
        <span class="hint">(enter it exactly like this: myshop.myshopify.com)</span> 
      </label> 
      <p> 
        <input id="shop" name="shop" size="45" type="text" value="" /> 
        <input name="commit" type="submit" value="Install" /> 
      </p> 
    </form>
