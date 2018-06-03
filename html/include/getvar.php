<?php

require "cryptolink.php";
require "functions.php";

$Crypto = new CryptoLink("DB NAME", "payments", "DB USER", "DB PASS");
$dat = $Crypto->grabvar($_POST['varname']);

$arr = explode(":", $dat);
echo $arr[1];

?>