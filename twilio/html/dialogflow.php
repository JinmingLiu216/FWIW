<?php


function checkDialogFlow($text, $id){
  $ch = curl_init();

  $accessToken = trim(file_get_contents("/var/www/twilio/access-token"));


  $sessionid = 9876543221 + $id;
  // set URL and other appropriate options
  curl_setopt($ch, CURLOPT_URL, "https://dialogflow.googleapis.com/v2/projects/shell-hack-2021/agent/sessions/{$sessionid}:detectIntent");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer '.$accessToken,
    'Content-Type: application/json; charset=utf-8'
  ]);

  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, '{"query_input": {"text": {"text": "'.$text.'","language_code": "en-US"}}}');

  // grab URL and pass it to the browser
  return json_decode(curl_exec($ch));
}
