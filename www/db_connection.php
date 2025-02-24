<?php
  $db_host = 'db';
  $db_user = 'thinkhuge';
  $db_pass = 'thinkhuge';
  $db_name = 'thinkhuge';
  
  try
  {
    $mysqli = mysqli_init();
    
    if (!$mysqli->real_connect($db_host, $db_user, $db_pass, $db_name, 3306))
    {
      die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
  
    mysqli_set_charset($mysqli, "utf8mb4");
  }
  catch (Exception $_)
  {
    die("Failed to connect to MySQL: " . $_->getMessage());
  }
