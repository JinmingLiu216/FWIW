<?php

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
    <!-- <link rel="stylesheet" href="/css/scanned.css  "> -->
    <link rel="stylesheet" href="/css/style.css">
  </head>
  <body>
    <section class="pass">
      <div class="row">
        <div class="cardWrap">
          <div class="card cardLeft">
            <h1>Guest Pass</h1>
            <div class="content">
              <div class="label">
                <p><?php echo $row['appointment'];?></p>
                <span>Date</span>
              </div>
              <div class="label">
                <p><?php echo $row['guestname'];?></p>
                <span>Guest</span>
              </div>
              <div class="label">
                <p><?php echo $row['guestphone'];?></p>
                <span>Phone</span>
              </div>
            </div>

          </div>
          <div class="card cardRight">
            <h1>Resident</h1>
            <div class="content">
              <div class="label">
                <p><?php echo $row['residentname'];?></p>
                <span>Resident</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
