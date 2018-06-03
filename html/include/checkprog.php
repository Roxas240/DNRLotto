<?php

require "cryptolink.php";
require "functions.php";

$Crypto = new CryptoLink("DB NAME", "payments", "DB USER", "DB PASS");
$id = (int)trim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT)) ?? 0;

echo $Crypto->chkpay($id);

?>