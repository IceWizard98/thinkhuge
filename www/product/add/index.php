<?php
  
  $nextPage = '';
  do
  {
    session_start();
  
    if (!isset($_SESSION['user_id']))
    {
      $nextPage = '/login/';
      break;
    }

    require_once __DIR__ . '/../../db_connection.php';
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' )
      break;
    
    $name            = trim($_POST['name']);
    $ram             = filter_var($_POST['ram'], FILTER_VALIDATE_INT);
    $cpu             = filter_var($_POST['cpu_cores'], FILTER_VALIDATE_INT);
    $disk            = filter_var($_POST['memory_space'], FILTER_VALIDATE_INT);
    $memory_type     = strtoupper($_POST['disk_type']);
    $os              = trim($_POST['os']);
    $icon            = trim($_POST['icon']);
    $is_dedicated_ip = isset($_POST['dedicated_ip']) ? 1 : 0;
    $is_suggested    = isset($_POST['suggested_product']) ? 1 : 0;
    
    if (
      empty($name)
      || strlen($name) > 50
      || $ram  < 1
      || $cpu  < 1
      || $disk < 1
      || !in_array($memory_type, ['SSD', 'HDD'])
      || empty($os)
      || strlen($os) > 255
      || empty($icon)
    ) {
      die('Invalid input data');
    }
    
    $name        = $mysqli->real_escape_string($name);
    $os          = $mysqli->real_escape_string($os);
    $icon        = $mysqli->real_escape_string($icon);
    $memory_type = $mysqli->real_escape_string($memory_type);
    
    $query = sprintf(
      "INSERT INTO product (name, ram, cpu, disk, memory_type, os, icon, is_dedicated_ip, is_suggested, price, discount) 
           VALUES ('%s', %d, %d, %d, '%s', '%s', '%s', %d, %d, 0, 0)",
      $name,
      $ram,
      $cpu,
      $disk,
      $memory_type,
      $os,
      $icon,
      $is_dedicated_ip,
      $is_suggested
    );
    
    if (!$mysqli->query($query))
      die("Error saving product: " . $mysqli->error);
    
    $nextPage = '/product/list/';
  } while(false);

  if (!empty($nextPage))
  {
    header('Location: ' . $nextPage);
    exit();
  }
  $action = 'add';
  require_once __DIR__ . '/../../pages/product_detail.php';
