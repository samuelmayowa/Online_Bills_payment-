<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://34.74.220.10/ringo/public/ringoPayments/public/api/products",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n    \"serviceCode\": \"ELECT\"\n}",
  CURLOPT_HTTPHEADER => array(
    "email: decmerchandise@gmail.com",
    "password: 12345678",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
foreach($response as $key ){
    echo "<form>
    <select name='products'>
    <option> $key = $value[$i] </option>
    </select>
   </form>";
}
curl_close($curl);
//echo $response;

?>