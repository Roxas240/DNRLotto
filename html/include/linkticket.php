<?php
//Config for CryptoPayAPI
$port = 3306;
$table = "payments";
$var_table = "count_vars";
$hostname = "HOSTNAME";
$database = "DB NAME";
$enc_key  = "ENCRYPT KEY";
//End Config

$enc_user = $_POST['user'];
$enc_pass = $_POST['pass'];

//get parameter from INPUT
$user    =      trim(filter_var(xmp_decrypt($enc_user, $enc_key), FILTER_SANITIZE_STRING)) ?? NULL;
$pass    =      trim(filter_var(xmp_decrypt($enc_pass, $enc_key), FILTER_SANITIZE_STRING)) ?? NULL;

$payID   = (int)trim(filter_input(INPUT_POST, "payID",   FILTER_SANITIZE_NUMBER_INT)) ?? 0;
$address =      trim(filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING)) ?? NULL;
$txid    =      trim(filter_input(INPUT_POST, "txid",    FILTER_SANITIZE_STRING)) ?? NULL;

$conn    = mysqli_connect($hostname, $user, $pass, $database, $port);
$query   = "INSERT INTO `lotto_tickets` (payment_id, address, txid) VALUES ('$payID', '$address', '$txid')";
$result  = mysqli_query($conn, $query) or die(mysqli_error($conn));

function xmp_decrypt($sStr, $sKey) {
   $decrypted= mcrypt_decrypt(
      MCRYPT_RIJNDAEL_128,
      $sKey,
      base64_decode($sStr),
      MCRYPT_MODE_ECB
   );
   $dec_s = strlen($decrypted);
   $padding = ord($decrypted[$dec_s-1]);
   $decrypted = substr($decrypted, 0, -$padding);
   return $decrypted;
}

?>