<?php

require "cryptolink.php";
require "functions.php";

$address = trim(filter_input(INPUT_POST, "address",   FILTER_SANITIZE_STRING)) ?? NULL;

$Crypto = new CryptoLink("DB NAME", "payments", "DB USER", "DB PASS");
echo $Crypto->addrequ(0.01, "Lotto Ticket:".$address);

?>