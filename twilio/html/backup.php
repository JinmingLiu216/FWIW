<?php

$ch = curl_init();

$accessToken = trim(file_get_contents("/var/www/twilio/access-token"));

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "https://dialogflow.googleapis.com/v2/projects/shell-hack-2021/agent/sessions/987654321:detectIntent");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Authorization: Bearer '.$accessToken,
  'Content-Type: application/json; charset=utf-8'
]);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"query_input": {"text": {"text": "'.$_POST['Body'].'","language_code": "en-US"}}}');

// grab URL and pass it to the browser
$resp = json_decode(curl_exec($ch));

error_log(time()." ".\json_encode([
  'body'=> $_POST['Body'],
  'intent'=>$resp
  ]).PHP_EOL, 3, "/var/www/logs/debug.log");
// close cURL resource, and free up system resources
curl_close($ch);

switch ($resp->queryResult->intent->displayName) {
  case 'new_user':
      $str = " New user ...";
    break;
  case 'hello':
      $str = "Welcome";
    break;
  default:
      $str = "New number, who this?";
    break;
}

?>


<Response>
    <Message><?php echo $str; ?></Message>
</Response>
