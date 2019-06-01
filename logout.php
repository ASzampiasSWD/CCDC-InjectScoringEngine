<?php
   session_start();
   unset($_SESSION['team_id']);
   unset($_SESSION['group_id']);
   unset($_SESSION['team_name']);
   unset($_SESSION['role']);
   unset($_SESSION["not_id"]);
   unset($_SESSION['nav_title']);
   header('Refresh: 1; URL = login.php');
?>
