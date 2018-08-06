<?php
header('Content-Type:application/json');
$data =file_get_contents('php://input');
$array =json_decode($data);

$fh =fopen('retrieve_tax.txt', 'w');
fwrite($fh,$data);
?>