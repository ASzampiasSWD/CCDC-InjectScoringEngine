<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../functions.php';
$connection = db_connect();

if (isset($_POST['name']) && isset($_POST['pass'])) {
  $username = $_POST['name'];
	$password = $_POST['pass'];
} else {
  echo "POST information was altered.";
  header('Refresh: 2; URL="../login.php');
  exit();
}

$arUser = GetUser($username, $password);
if ($arUser != "DNE") {
  $_SESSION['team_id'] = $arUser['team_id'];
  $_SESSION['group_id'] = $arUser['group_id'];
  $team_name = $arUser['team_name'];
  $_SESSION['role'] = $arUser['role'];
  // If role = 0, user is an Admin.
  if ($_SESSION['role'] == 0) {
	$title = 'Admin';
  }
  // If role = 1, user is a Team.
  else if ($_SESSION['role'] == 1) {
	$title = "Team";
  }
  // If role = 2, user is a User.
  else {
	$title = "User";
  }
  $_SESSION['nav_title'] = htmlspecialchars($title . " " . $team_name, ENT_QUOTES, 'UTF-8');
  $_SESSION['team_name'] = htmlspecialchars($team_name, ENT_QUOTES, 'UTF-8');
  header('Refresh: 0; URL="../dashboard.php');
 }
else
{
  echo "Wrong Login Information.";
  header('Refresh: 2; URL="../login.php');
  exit();
}

?>
