<?php
  
  require_once __DIR__ . '/../db_connection.php';
  $nextPage = '';
  
  do
  {
    session_start();
  
    if (isset($_SESSION['user_id']))
    {
      $nextPage = '/product/list/';
      break;
    }
  
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
      break;
  
    $username = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';
  
  
    if (empty($username) || empty($password) || !is_string($username) || !is_string($password))
      break;
  
    $username = trim($username);
    $password = trim($password);
    $username = mysqli_real_escape_string($mysqli, $username);
  
    $query = sprintf(
      "SELECT id, username, password FROM user WHERE username = '%s' LIMIT 1",
      $username
    );
  
    try
    {
      $result = mysqli_query($mysqli, $query);
  
      mysqli_close($mysqli);
  
      if (!$result || mysqli_num_rows($result) <= 0)
        break;
  
      $user = mysqli_fetch_assoc($result);
  
      if (!password_verify($password, $user['password']))
        break;
  
      $_SESSION['user_id']  = $user['id'];
      $_SESSION['username'] = $user['username'];
  
      $nextPage = '/product/list/';
  
      mysqli_free_result($result);
    }
    catch (Exception $_)
    {
      //TODO logging
    }
  }
  while (FALSE);
  
  
  if (!empty($nextPage))
  {
    header('Location: ' . $nextPage);
    exit();
  }
  
  require_once __DIR__ . '/../pages/login.php';
