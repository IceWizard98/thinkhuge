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
  
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
      break;
  
    $id              = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $name            = trim($_POST['name']);
    $ram             = filter_var($_POST['ram'], FILTER_VALIDATE_INT);
    $cpu             = filter_var($_POST['cpu_cores'], FILTER_VALIDATE_INT);
    $disk            = filter_var($_POST['memory_space'], FILTER_VALIDATE_INT);
    $memory_type     = strtoupper($_POST['disk_type']);
    $os              = trim($_POST['os']);
    $icon            = trim($_POST['icon']);
    $is_dedicated_ip = isset($_POST['is_dedicated_ip']) ? 1 : 0;
    $is_suggested    = isset($_POST['is_suggested']) ? 1 : 0;
    $price           = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $discount        = filter_var($_POST['discount'], FILTER_VALIDATE_FLOAT);
  
    if (
      empty($id)
      || empty($name)
      || strlen($name) > 50
      || $ram  < 1
      || $cpu  < 1
      || $disk < 1
      || !in_array($memory_type, ['SSD', 'HDD'])
      || empty($os)
      || strlen($os) > 255
      || empty($icon)
      || $price    < 0
      || $discount < 0
    ) 
      die('Invalid input data');
  
    $name        = $mysqli->real_escape_string($name);
    $os          = $mysqli->real_escape_string($os);
    $icon        = $mysqli->real_escape_string($icon);
    $memory_type = $mysqli->real_escape_string($memory_type);
  
    $mysqli->begin_transaction(MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
  
    try
    {
      $check_query = sprintf("SELECT id FROM product WHERE id = %d FOR UPDATE", $id);
      $result      = $mysqli->query($check_query);
  
      if (!$result || $result->num_rows === 0)
        throw new Exception("Product not found");
  
      $query = sprintf(
        "UPDATE product 
         SET name = '%s', 
             ram = %d, 
             cpu = %d, 
             disk = %d, 
             memory_type = '%s', 
             os = '%s', 
             icon = '%s', 
             is_dedicated_ip = %d, 
             is_suggested = %d,
             price = %.2f,
             discount = %.2f,
             updated_at = CURRENT_TIMESTAMP
         WHERE id = %d",
        $name,
        $ram,
        $cpu,
        $disk,
        $memory_type,
        $os,
        $icon,
        $is_dedicated_ip,
        $is_suggested,
        $price,
        $discount,
        $id
      );
  
      if (!$mysqli->query($query))
        throw new Exception("Error updating product: " . $mysqli->error);
  
      $mysqli->commit();
      $nextPage = '/product/list/';
    }
    catch (Exception $e)
    {
      $mysqli->rollback();
      die($e->getMessage());
    }
  }
  while (FALSE);
  
  if (!empty($nextPage))
  {
    header('Location: ' . $nextPage);
    exit();
  }
  
  $product = [];
  $id      = filter_var($_GET['id'] ?? $_POST['id'] ?? null, FILTER_VALIDATE_INT);
  
  if ($id)
  {
    $query  = sprintf("SELECT * FROM product WHERE id = %d", $id);
    $result = $mysqli->query($query);
  
    if ($result && $result->num_rows > 0)
    {
      $product = $result->fetch_assoc();
    }
    else
    {
      die("Product not found");
    }
  }
  
  $action = 'edit';
  require_once __DIR__ . '/../../pages/product_detail.php';
