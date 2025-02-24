<?php
  
  $nextPage = '';
  $products = [];
  
  do
  {
    session_start();
  
    if (!isset($_SESSION['user_id']))
    {
      $nextPage = '/login/';
      break;
    }
  
    require_once __DIR__ . '/../../db_connection.php';
  
    $query = 'SELECT * FROM product WHERE deleted_at IS NULL';
  
    $result = mysqli_query($mysqli, $query);
  
    mysqli_close($mysqli);

    if ($result)
    {
      while ($row = mysqli_fetch_assoc($result))
        $products[] = $row;

      mysqli_free_result($result);
    }
  
  }
  while (FALSE);
  
  if (!empty($nextPage))
  {
    header('Location: ' . $nextPage);
    exit();
  }
  require_once __DIR__ . '/../../pages/product_list.php';
