<?php

  $qr_code = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAK4AAACuAQMAAACVwqStAAAABlBMVEUAAAD///+l2Z/dAAAACXBIWXMAAA7EAAAOxAGVKw4bAAABQklEQVRIicWX0Q3DMAhEkTxARvLqHikDWKLcnZO2C3BRlLov/UDAHTQC19zXiivHHXV/r148MvOedcgC1xr3LODBCKoCzB1T54rXiteO2AzQi0euSthGwnyYRSsQyFb817IVq5ER47l/+7sVpy7EiCTp23ZgxcU31T74rAJa8GZaEBpxhJ4WjCQhPdR3qQp+48BJPUlVlHj9pJ4GPE65Vh3oMTiHA5fxq2jPRJoqnQGzQElZDxkMAzRgJklNpLoFB0I/fr2/ApTZsGgGzMZZdN+jcjqfAdPe8BLi5kTKXBaMcLSz4P1EAS9abzseZz6jidTC44yjbqxJCINh9Wg274huxVoWuMSd9fbRfDfWAnU2uG/CHPgs1/EaHhVmwxQ0hKUCbh9W4wQWKAylsOBno6TNLLXzdmA1cuiv4VH529+d+ANaDNwzgUgyzQAAAABJRU5ErkJggg==';

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
      <img src="<?php echo $qr_code ?>" alt="qr_code">
    </section>
  </body>
</html>
