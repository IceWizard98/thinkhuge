<?php
  
  $nextPage = '/product/list/';
  
  do
  {
    session_start();
  
    if (!isset($_SESSION['user_id']))
    {
      $nextPage = '/login/';
      break;
    }
  
    require_once __DIR__ . '/../../db_connection.php';
  
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
  
    if (empty($id))
      die('Invalid product ID');
  
    $mysqli->begin_transaction(MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
  
    try
    {
      $check_query = sprintf("SELECT id FROM product WHERE id = %d AND deleted_at IS NULL FOR UPDATE", $id);
      $result      = $mysqli->query($check_query);
  
      if (!$result || $result->num_rows === 0)
        throw new Exception("Product not found or already deleted");
  
      $query = sprintf(
        "UPDATE product SET deleted_at = CURRENT_TIMESTAMP WHERE id = %d",
        $id
      );
  
      if (!$mysqli->query($query))
        throw new Exception("Error deleting product: " . $mysqli->error);
  
      $mysqli->commit();
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
