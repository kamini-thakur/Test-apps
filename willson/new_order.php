<?php
header('Content-Type:application/json');

$data =file_get_contents('php://input');
$array =json_decode($data);
$tempVar = var_export($array, true);

$fh =fopen('orderCreate.txt', 'w');
fwrite($fh, $data);

?>