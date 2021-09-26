<?php

include 'intent.php';
include 'database.php';
include 'dialogflow.php';

$phoneNumber = str_replace("+", "", $_POST['From']);

$data = new stdClass();

$sql = "SELECT * FROM sessions WHERE phone = '".$phoneNumber."';";

if ($result = $mysqli -> query($sql)) {
  if($result->num_rows){
      $row = $result -> fetch_assoc();
      $sessionid = $row['id'];
      $data = json_decode($row['data']);
      $result -> free_result();
  }else{
      $result -> free_result();
      $sql = "INSERT INTO sessions (phone) VALUES({$phoneNumber})";
      $result = $mysqli -> query($sql);
      $data->intent = [];
      $sql = "SELECT LAST_INSERT_ID()";
      $result = $mysqli -> query($sql);
      $row = $result -> fetch_assoc();
      $sessionid = $row['LAST_INSERT_ID()'];
  }
}

// var_dump($data);
// exit(0);

$sql = "SELECT * FROM resident WHERE phone = '{$phoneNumber}';";

if ($result = $mysqli -> query($sql)) {
  if($result->num_rows){
    // while ($row = $result -> fetch_row()) {
    //   printf ("%s (%s)\n", $row[0], $row[1]);
    // }
      $data->newUser = false;
  }else{
      $data->newUser = true;
  }
  $result -> free_result();
}

$resp = checkDialogFlow($_POST['Body'], $sessionid);

$intent = $resp->queryResult->intent->displayName;

array_push($data->intent, $intent);

switch ($intent) {
  case 'greeting':
      if(!$data->newUser){
        $str = $greetingReturn[array_rand($greetingReturn)];
      }else{
        $str = $greetingNew[array_rand($greetingNew)];
      }
    break;
  case 'person':

      $givenName = "given-name";
      $data->name = $resp->queryResult->parameters->$givenName;
      if(!$data->newUser){
        $str = $guestPhone[array_rand($guestPhone)];;
      }else{

        // var_dump($resp->queryResult->parameters->$givenName);
        $str = $newAccount[array_rand($newAccount)];
      }
    break;
  case 'awk_yes':
      if(!$data->newUser){
        $str = $awk_yes[array_rand($awk_yes)];

        $sql = "INSERT INTO guest (rid, phone, name) VALUES( {$data->rid},'{$data->phone}', '{$data->name}')";
        $result = $mysqli -> query($sql);

        $sql = "SELECT LAST_INSERT_ID()";
        $result = $mysqli -> query($sql);
        $row = $result -> fetch_assoc();
        $data->gid = $row['LAST_INSERT_ID()'];

        $code = strtoupper(bin2hex(openssl_random_pseudo_bytes(4)));

        $datetime = strtotime($data->datetime);

        $sql = "INSERT INTO qrcode (gid, data, appointment) VALUES( '{$data->gid}', '{$code}',FROM_UNIXTIME({$datetime}))";

        $result = $mysqli -> query($sql);

      }else{
        $str = $awk_yes_account[array_rand($awk_yes_account)];

        $data->newUser = false;

        $sql = "INSERT INTO resident (phone, name) VALUES( '{$phoneNumber}', '{$data->name}')";
        $result = $mysqli -> query($sql);
        $sql = "SELECT LAST_INSERT_ID()";
        $result = $mysqli -> query($sql);
        $row = $result -> fetch_assoc();
        $data->rid = $row['LAST_INSERT_ID()'];

      }
    break;
  case 'awk_no':
      $str = $awk_no[array_rand($awk_no)];
    break;
  case 'phone':
      $phoneNumber = "phone-number";
      $data->phone = $resp->queryResult->parameters->$phoneNumber;
      $str = $dateTime[array_rand($dateTime)];
    break;
  case 'datetime':
      // var_dump($resp);
      $data->datetime = $resp->queryResult->parameters->time;
      $str = $inviteConfirm[array_rand($inviteConfirm)];
    break;
  default:
      $str = "New number, who this?";
    break;
}

$json = json_encode($data);
$sql = "UPDATE sessions SET data = '{$json}' WHERE id = {$sessionid};";
$result = $mysqli -> query($sql);

$healthy = array("NAME", "TIMESTAMP");

if(property_exists($data, 'datetime')){
  $date = new DateTime($data->datetime);
  $datastring = $date->format('D M dS \a\t g:ia');
}else{
  $datastring = "";
}

if(property_exists($data, 'name')){
  $name = $data->name;
}else{
  $name = "";
}

$yummy = array($name, $datastring);

$str = str_replace($healthy, $yummy, $str);

?>

<Response>
    <Message><?php echo $str; ?></Message>
</Response>
