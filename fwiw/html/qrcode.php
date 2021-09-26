<?php
require_once "/var/www/library/phpqrcode/qrlib.php";
ob_start();
QRCode::png('https://fwiw.tech/pass/'.$_GET['code'], null, 1, 6, 0);
$imageString = 'data:image/png;base64,'.base64_encode(ob_get_contents());
ob_end_clean();

include '/var/www/twilio/html/database.php';

$sql = "SELECT qrcode.data as data, qrcode.appointment as appointment, guest.phone as guestphone, guest.name as guestname,  resident.name as residentname FROM qrcode INNER JOIN guest ON qrcode.gid = guest.id JOIN resident ON guest.rid = resident.id WHERE qrcode.data = '{$_GET['code']}';";
if ($result = $mysqli -> query($sql)) {
  if($result->num_rows){
    $row = $result -> fetch_assoc();
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="Description" content="Forgot where I was invitation service">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/scanned.css">
  </head>
  <body>
    <section>
      <img src="<?php echo $imageString ?>" alt="qr_code">
      <span><?php echo $row['guestname'] ?></span>
      <span><?php echo $row['appointment'] ?></span>
    </section>
  </body>
</html>
