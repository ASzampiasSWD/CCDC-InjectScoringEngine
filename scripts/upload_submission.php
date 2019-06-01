<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../functions.php';
$uploadOk = 1;
$connection = db_connect();
$origin = $_POST['origin'];

if ($origin == "createsubmission") {
  $target_file = "../uploads/" . GetGroupName($_SESSION["group_id"]) . "/" . $_SESSION["team_name"] . "/" .  basename($_FILES["fileToUpload"]["name"]);
  if ($_FILES["fileToUpload"]["name"] != null && $_FILES["fileToUpload"]["name"] != "") {
    $location2 = "uploads/" . GetGroupName($_SESSION["group_id"]) . "/" . $_SESSION["team_name"] . "/" .  basename($_FILES["fileToUpload"]["name"]);
  } else {
    $location2 = null;
  }
	$title = htmlspecialchars($_POST['title']);
  $text = nl2br(htmlspecialchars($_POST['body']));
  $inject_id = htmlspecialchars($_POST['inject_id']);
	$team_id = $_SESSION['team_id'];
	$is_late = "F";
	$filename = "";
  /* User can upload reverse-shells. Make sure you don't execute anything in uploads directory. */
	if ($_FILES["fileToUpload"]["size"] > 0) {
	  $filename = IsFile($target_file);
	}  /* FOR SAFETY PURPOSES DON"T DO IT (Make sure you have an .htaccess file.) */
	InsertSubmission($team_id, $inject_id, $location2, $title, $filename, $text, $is_late);
	echo 'Submission created.';
  header('Refresh: 2; URL = ../submission.php');
}

else if ($origin == "admincreateinject") {
	$inject_name = $_POST['inject_name'];
	$inject_duration = $_POST['inject_duration'];
	$inject_points = $_POST['inject_points'];
	$group_id = $_POST['group_id_1'];
	$is_active = $_POST['is_active'];
	$is_multi = $_POST['is_multi'];
	$inject_from = $_POST['inject_from'];
	$inject_to = $_POST['inject_to'];
	$message = nl2br($_POST['inject_body']);
	$inject_id = GetLastInjectID($group_id) + 1;
	$group_name = GetGroupName($group_id);
	$start_time = GetTime();
	$location = CreatePDF($inject_id, $inject_duration, $start_time, $group_name, $inject_from, $inject_to, $inject_name, $message);
	InsertInject($inject_duration, $group_id, $inject_name, $location, $inject_points, $is_active, $is_multi, $inject_from, $inject_to, $message, $start_time);
	echo 'Inject created.';
  header('Refresh: 2; URL = ../admin.php?view=createinject');
}

else if ($origin == "admincreatenotification") {
	$group_id = $_POST['group_id_2'];
  $team_id = $_POST['team_id_not'];
	$not_message = $_POST['not_message'];
  if ($team_id == "everyone") {
    $team_id = NULL;
  }
	InsertNotification($group_id, $team_id, $not_message);
	echo 'Notification created.';
	header('Refresh: 2; URL = ../admin.php?view=createnotification');
}

else if ($origin == "admingradeinjects") {
  $team_name = $_SESSION['team_name'];
  $entry_id = $_POST['inject_id_grade'];
  $inject_points = $_POST['inject_points'];
  UpdateSubmission($inject_points, $team_name, $entry_id);
  echo 'Submission Updated';
  header('Refresh: 2; URL = ../admin.php?view=gradeinject');
  return;
}

else if ($origin == "createpasswordchange") {
	$team_id = $_SESSION['team_id'];
	$service = htmlspecialchars($_POST['service_name']);
	$new_password = htmlspecialchars($_POST['service_password']);
	InsertPassword($team_id, $service, $new_password, 'F');
	echo 'Password Change created';
	header('Refresh: 2; URL = ../passwordchange.php');
}

else if ($origin == "adminaddservice") {
  $team_id = $_POST['team_id_2'];
  $service_type = $_POST['service_type'];
  $service_name = $_POST['service_name'];
  $ip = $_POST['service_ip'];
  $port = $_POST['service_port'];
  $graded = 0;
  if (isset($_POST['service_active'])) {
    $graded = 1;
  }
  InsertService($team_id, $service_name, $service_type, $ip, $port, $graded);
  echo 'Service Created';
  header('Refresh: 2; URL = ../admin.php?view=addservice');
}

else if ($origin == "admincreategroup") {
  $group_name = $_POST['group_name'];
  $group_type = $_POST['group_type'];
  $comp_start_date = $_POST['comp_start_date'];
  $comp_start_time =  $_POST['comp_start_time'];
  $comp_start = $comp_start_date . ' ' . $comp_start_time;
  $dateCompStart = new DateTime($comp_start);
  $dtStart =  date_format($dateCompStart, 'r');
  $comp_end_date = $_POST['comp_end_date'];
  $comp_end_time = $_POST['comp_end_time'];

  $comp_end = $comp_end_date . ' ' . $comp_end_time;
  $dateCompEnd = new DateTime($comp_end);
  $dtEnd = date_format($dateCompEnd, 'r');

  InsertCategory($group_type, $group_name, $dtStart, $dtEnd);
  header('Refresh: 2; URL = ../admin.php');
  echo 'Group created.';
  return;
}

else if ($origin == "adminpasschange") {
  $passchange_id = $_POST['passchange_id'];
  UpdatePasswordChange($passchange_id);
  header('Refresh: 2; URL = ../admin.php?view=passchange');
  echo 'Password Change updated.';
  return;
}

else if ($origin == "admincreateteam") {
   $group_id = $_POST['group_id_3'];
   $team_name = $_POST['team_name'];
   $team_password = $_POST['team_password'];
   InsertAccount($group_id, $team_name, $team_password);
   header('Refresh: 2; URL = ../admin.php');
   echo 'Team created.';
   return;
}
else {
	echo "Path unknown.";
	$uploadOk = 0;
}

function IsFile($target_file) {
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
	header('Refresh: 0; URL = ../create.php');
  }

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $filename = basename($_FILES["fileToUpload"]["name"]);
    return $filename;
  } else {
     echo "Sorry, there was an error uploading your file.";
     return "";
  }
}
?>
