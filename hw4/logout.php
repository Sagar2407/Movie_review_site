<?php
 
require_once'checkSession.php';
 

  if(isset($_SESSION['user'])!="") {
  header("Location: list.php");
 }
 
 if (isset($_GET['logout'])) {
  unset($_SESSION['user']);
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit;
 }
 ?>