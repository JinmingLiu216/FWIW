<?php

include 'database.php';
require '/var/www/library/twilio/vendor/autoload.php';

use Twilio\Rest\Client;

$sid = 'AC0bdabe4b06f79a0eaca3a4b0333179d6';
$token = '';
$client = new Client($sid, $token);

$sql = "SELECT qrcode.data as data, qrcode.appointment as appointment, guest.phone as guestphone, guest.name as guestname,  resident.name as residentname FROM qrcode INNER JOIN guest ON qrcode.gid = guest.id JOIN resident ON guest.rid = resident.id WHERE (NOW() - INTERVAL 5 MINUTE) < qrcode.create_date;";

if ($result = $mysqli -> query($sql)) {
  if($result->num_rows){
    $row = $result -> fetch_assoc();
    $text = "Hello {$row['guestname']}, I am Rocket! Your friend {$row['residentname']} sent you an invite for {$row['appointment']}. Visit https://fwiw.tech/qrcode/{$row['data']}";
    echo $text;

    // $client->messages->create(
    //     '+1'.$row['guestphone'],
    //     [
    //         'from' => '+13059306983',
    //         'body' => $text
    //     ]
    // );

  }
}
