<?php

$params = ["id" => 0, "first_name" => "A", "last_name" => "B"];

$defaults = array(
    CURLOPT_URL => "localhost:4000/src/authorize.php",
    //CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
);

$ch = curl_init();
curl_setopt_array($ch, $defaults);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
return $result;
?>
