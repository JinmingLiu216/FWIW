<?php

$mysqli = new mysqli("35.225.156.98","root","","fwiw");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
