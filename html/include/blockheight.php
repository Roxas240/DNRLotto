<?php

require "cryptolink.php";
require "functions.php";

$Crypto = new CryptoLink("DATABASE", "payments", "DB USER", "DB PASS");
$dat = $Crypto->grabvar("height");

$arr = explode(":", $dat);
echo $arr[1];

?>