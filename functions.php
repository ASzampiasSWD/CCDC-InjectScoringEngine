<?php
/* Author: Amanda Szampias
 * Date: August 18, 2018
 * School: Cuyahoga Community College
 * Email: ASzampiasSWD@gmail.com
*/

include __DIR__ . '/vendor/autoload.php';

/* GetTime()
 * Get US Military Eastern Ohio time.
 * return String
*/
function GetTime() {
  date_default_timezone_set('US/Eastern');
  $dtToday = new DateTime();
  return date_format($dtToday, 'r');
}
/* GetTimeDiff(Date $dtNow, Date $dtPast)
 * Take two dates and subtract the difference.
 * Return String
*/
function GetTimeDiff($dtEndTime) {
  $dtNow = new DateTime(GetTime());
  $dtEnd = new DateTime($dtEndTime);

  // If the current time is greater than the end time, return false.
  if ($dtNow > $dtEnd) {
	  return false;
  }
  // If the end_time is in the future, return true.
  else {
	  return true;
  }
}

function GetMyAccountTimeDiff($team_id) {
  $conn = db_connect();
  $stmt = $conn->prepare("SELECT creation_date
                          FROM Team
                          WHERE team_id = ?");
  $stmt->bind_param("i", $team_id);
  $result = $stmt->execute();
  $stmt->bind_result($creation_date);
  $stmt->fetch();
  $dtNow = new DateTime(GetTime());
  $dtEnd = new DateTime($creation_date);
  return $dtNow->diff($dtEnd)->format("%y years %m months %d days");
}

/* db_connect()
 * Create a Database Connection String
 * Return ConnectionString
 */
function db_connect() {
  // Define connection as a static variable, to avoid connecting more than once
  static $connection;

  // Try and connect to the database, if a connection has not been established yet
  if(!isset($connection)) {
    // Load configuration as an array. Use the actual location of your configuration file
    #$config = parse_ini_file('config.ini');
	  $config = parse_ini_file('/var/www/html/injectscoringengine/config.ini');
    $connection = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);
  }

  // If connection was not successful, handle the error
  if($connection === false) {
    // Handle error - notify administrator, log to a file, show an error screen, etc.
    return mysqli_connect_error();
  }
   return $connection;
}

function InsertPassword($team_id, $service, $new_password, $status) {
	$conn = db_connect();
	$stmt = $conn->prepare("INSERT INTO Password_Change (team_id, service, new_password, status) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("isss", $team_id, $service, $new_password, $status);
	$stmt->execute();
	$stmt->close();
}

function InsertSubmission($team_id, $inject_id, $location, $title, $filename, $text, $is_late) {
  $conn = db_connect();
  $init_submitted = GetTime();
  $stmt = $conn->prepare("INSERT INTO Submission (team_id, inject_id, location, init_submitted, title, filename, user_text, is_late)  VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("iissssss", $team_id, $inject_id, $location, $init_submitted, $title, $filename, $text, $is_late);
  $stmt->execute();
  $stmt->close();
}

function GetInjects($group_id) {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT inject_id, location, title, is_active, is_multi, end_time
                          FROM Inject
                          WHERE group_id = ?");
  $stmt->bind_param("i", $group_id);
  $result = $stmt->execute();
  $stmt->bind_result($inject_id, $location, $title, $is_active, $is_multi, $end_time);
  while ($stmt->fetch()) {
	  if ($is_active == "T") {
		  $arInject = array("location" => $location, "inject_id" => $inject_id,
		                      "title" => $title, "is_multi" => $is_multi,
	                        "end_time" => $end_time);
        array_push($stack, $arInject);
	  }
  }
  return $stack;
}

function GetServicesByTeamId($team_id) {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT service_name, is_active, is_graded
                          FROM Service
                          WHERE team_id = ?
                          ORDER BY service_name ASC");
  $stmt->bind_param("i", $team_id);
  $result = $stmt->execute();
  $stmt->bind_result($service_name, $is_active, $is_graded);
  while ($stmt->fetch()) {
	  if ($is_graded == "1") {
		  $arService = array("service_name" => $service_name, "is_active" => $is_active);
        array_push($stack, $arService);
	  }
  }
  return $stack;
}

function GetPasswords($team_id) {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT team_id, service, new_password, status, time_changed
                          FROM Password_Change
                          WHERE team_id = ?");
  $stmt->bind_param("i", $team_id);
  $result = $stmt->execute();
  $stmt->bind_result($team_id, $service, $new_password, $status, $time_changed);
  while($stmt->fetch())
  {
	$arPassword = array("team_id" => $team_id, "service" => $service,
	                    "new_password" => $new_password, "status" => $status,
                      "time_changed" => $time_changed);
	array_push($stack, $arPassword);
  }
  $stmt->close();
  return $stack;
}

function GetInjectAlreadyDone($team_id, $inject_id) {
  $conn = db_connect();
  $stmt = $conn->prepare("SELECT entry_id
                          FROM Submission
                          WHERE team_id = ?
                          AND inject_id = ?");
  $stmt->bind_param("ii", $team_id, $inject_id);
  $stmt->execute();
  $arr = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  if(!$arr) {
    return false;
  } else {
	  return true;
  }
}

function GetCompInfo($group_id) {
  $conn = db_connect();
  $stmt = $conn->prepare("SELECT group_name, comp_start, comp_end
                          FROM Category
                          WHERE group_id = ?");
  $stmt->bind_param("i", $group_id);
  $result = $stmt->execute();
  $stmt->bind_result($group_name, $comp_start, $comp_end);
  $stmt->fetch();
  $arCategory = array("group_name" => $group_name, "comp_start" => $comp_start, "comp_end" => $comp_end);
  $stmt->close();
  return $arCategory;
}

function GetAllPasswordChanges() {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT Team.team_name,
                                service,
                                new_password,
                                status,
                                passchange_id
                          FROM Password_Change
                          INNER JOIN Team
                          ON Password_Change.team_id = Team.team_id");
  $result = $stmt->execute();
  $stmt->bind_result($team_name, $service, $new_password, $status, $passchange_id);
  while ($stmt->fetch())
  {
    $arPC = array("team_name" => $team_name, "service" => $service, "new_password" => $new_password, "status" => $status, "passchange_id" => $passchange_id);
      array_push($stack, $arPC);
  }
  $stmt->close();
  return $stack;
}

function GetUser($username, $password) {
	$conn = db_connect();
	$stmt = $conn->prepare("SELECT team_id, team_name, role, Team.group_id
                          FROM Team
                          INNER JOIN Category
                          ON Category.group_id = Team.group_id WHERE team_name = ? AND " .
	                         "Team.team_password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows === 0) { return 'DNE';}
    $stmt->bind_result($team_id, $team_name, $role, $group_id);
    $stmt->fetch();
	$arUserInfo = array("team_id" => $team_id, "team_name" => $team_name,
					    "role" => $role, "group_id" => $group_id);
    $stmt->close();
	return $arUserInfo;
}

function GetSubmissions($team_id) {
  $conn = db_connect();
  $stack = array();
  $count = 0;
  /*$stmt = $conn->prepare("SELECT inject_id, location, init_submitted, title, filename
                          FROM Submission
                          WHERE team_id = ?");*/
  $stmt = $conn->prepare("SELECT Submission.inject_id, Submission.location, init_submitted, Submission.title, filename, user_text, inject_score, graded_by, is_late
                          FROM  Submission
                          INNER JOIN Inject
                          ON Submission.inject_id = Inject.inject_id
                          WHERE team_id = ?");

  $stmt->bind_param("i", $team_id);
  $result = $stmt->execute();
  $stmt->bind_result($inject_id, $location, $init_submitted, $title, $filename, $user_text, $inject_score, $graded_by, $is_late);
  while($stmt->fetch()) {
	  $arSub = array("inject_id" => $inject_id, "location" => $location,
                   "init_submitted" => $init_submitted,
	  					     "title" => $title, "filename" => $filename,
                   "user_text" => $user_text, "inject_score" => $inject_score,
                   "graded_by" => $graded_by, "is_late" => $is_late);
	  array_push($stack, $arSub);
  }
  $stmt->close();
  return $stack;
}

function GetAllSubmissions() {
  $conn = db_connect();
  $stack = array();
  $count = 0;
  $stmt = $conn->prepare("SELECT entry_id, Submission.inject_id, Submission.team_id, Submission.location, init_submitted, Submission.title, Inject.points, Inject.title, Inject.location, filename, user_text, inject_score, graded_by, is_late
                          FROM  Submission
                          INNER JOIN Inject
                          ON Submission.inject_id = Inject.inject_id");

  $result = $stmt->execute();
  $stmt->bind_result($entry_id, $inject_id, $team_id, $location, $init_submitted, $title, $points, $injTitle, $injLocation, $filename, $user_text, $inject_score, $graded_by, $is_late);
  while($stmt->fetch()) {
	  $arSub = array("entry_id" => $entry_id, "inject_id" => $inject_id, "location" => $location,
                   "init_submitted" => $init_submitted,
	  					     "title" => $title, "filename" => $filename,
                   "user_text" => $user_text, "inject_score" => $inject_score,
                   "graded_by" => $graded_by, "is_late" => $is_late,
                   "team_id" => $team_id, "points" => $points,
                   "injLocation" => $injLocation, "injTitle" => $injTitle);
	  array_push($stack, $arSub);
  }
  $stmt->close();
  return $stack;
}

function GetInjectInfo($inject_id) {
  $conn = db_connect();
  $stmt = $conn->prepare("SELECT sent_by, deliver_to, title, message, duration, start_time, end_time, is_active
                          FROM Inject
                          WHERE inject_id = ?");
  $stmt->bind_param("i", $inject_id);
  $result = $stmt->execute();
  $stmt->bind_result($sent_by, $deliver_to, $title, $message, $duration, $start_time, $end_time, $is_active);
  $stmt->fetch();
  $arInject = array("sent_by" => $sent_by, "deliver_to" => $deliver_to, "title" => $title,
	  		    "duration" => $duration, "start_time" => $start_time, "end_time" => $end_time,
				"is_active" => $is_active, "message" => $message);
  $stmt->close();
  return $arInject;
}

function GetAllInjects() {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT inject_id, group_id, title, points, is_active, is_multi, duration, start_time, end_time
                          FROM Inject");
  $result = $stmt->execute();
  $stmt->bind_result($inject_id, $group_id, $title, $points, $is_active, $is_multi, $duration, $start_time, $end_time);
  while ($stmt->fetch()) {
    $arInject = array("inject_id" => $inject_id, "group_id" => $group_id, "title" => $title,
                      "points" => $points, "is_active" => $is_active, "is_multi" => $is_multi,
                      "duration" => $duration, "start_time" => $start_time, "end_time" => $end_time);
    array_push($stack, $arInject);
  }
  $stmt->close();
  return $stack;
}

function GetAllNotifications() {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT not_id, group_id, team_id, message, init_submitted, last_updated
                          FROM Notification");
  $result = $stmt->execute();
  $stmt->bind_result($not_id, $group_id, $team_id, $message, $init_submitted, $last_updated);
  while ($stmt->fetch()) {
	  $arNot = array("not_id" => $not_id, "group_id" => $group_id, "team_id" => $team_id,
                    "message" => $message, "init_submitted" => $init_submitted, "last_updated" => $last_updated);
	  array_push($stack, $arNot);
  }
  $stmt->close();
  return $stack;
}

function GetAllServices() {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT service_id, team_id, service_name, service_type, ip, port, is_active, is_graded, service_score
                          FROM Service");
  $result = $stmt->execute();
  $stmt->bind_result($service_id, $team_id, $service_name, $service_type, $ip, $port, $is_active, $is_graded, $service_score);
  while ($stmt->fetch()) {
	  $arSer = array("service_id" => $service_id, "team_id" => $team_id, "service_name" => $service_name,
                    "service_type" => $service_type, "ip" => $ip, "port" => $port,
                    "is_active" => $is_active, "is_graded" => $is_graded, "service_score" => $service_score);
	  array_push($stack, $arSer);
  }
  $stmt->close();
  return $stack;
}


function GetNotifications($group_id, $team_id) {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT message, init_submitted, last_updated
                          FROM Notification
                          WHERE group_id = ?
                          AND team_id IS null
                          OR team_id = ?");
  $stmt->bind_param("ii", $group_id, $team_id);
  $result = $stmt->execute();
  $stmt->bind_result($message, $init_submitted, $last_updated);
  while ($stmt->fetch()) {
	  $arNot = array("message" => $message, "init_submitted" => $init_submitted, "last_updated" => $last_updated);
	  array_push($stack, $arNot);
  }
  $stmt->close();
  return $stack;
}

/********************** ADMIN SECTION **********************/
/********************** ADMIN SECTION **********************/
function GetCategory() {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT group_id, group_name, comp_start, comp_end, role
                          FROM Category");
  $result = $stmt->execute();
  $stmt->bind_result($group_id, $group_name, $comp_start, $comp_end, $role);
  while ($stmt->fetch()) {
	  $arCategory = array("group_id" => $group_id, "group_name" => $group_name, "comp_start" => $comp_start, "comp_end" => $comp_end, "role" => $role);
      array_push($stack, $arCategory);
  }
  $stmt->close();
  return $stack;
}

function GetTeam() {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT team_name, team_password, team_score, group_id, team_id, creation_date
                          FROM Team");
  $result = $stmt->execute();
  $stmt->bind_result($team_name, $team_password, $team_score, $group_id, $team_id, $creation_date);
  while ($stmt->fetch()) {
	  $arTeam = array("team_name" => $team_name, "team_password" => $team_password,
                        "team_score" => $team_score, "group_id" => $group_id,
                        "team_id" => $team_id, "creation_date" => $creation_date);
    array_push($stack, $arTeam);
  }
  $stmt->close();
  return $stack;
}

function GetInjectsNotGraded() {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT Submission.team_id, Category.group_name, Submission.inject_id, Inject.title, Team.team_name
                          FROM Submission
                          INNER JOIN Team
                          ON Submission.team_id = Team.team_id
                          INNER JOIN Inject
                          ON Submission.inject_id = Inject.inject_id
                          INNER JOIN Category
                          ON Team.group_id = Category.group_id
                          WHERE graded_by IS NULL;");
  $result = $stmt->execute();
  $stmt->bind_result($team_id, $group_name, $inject_id, $title, $team_name);
  while ($stmt->fetch()) {
	  $arInjects = array("team_id" => $team_id, "inject_id" => $inject_id,
                        "title" => $title, "team_name" => $team_name, "group_name" => $group_name);
    array_push($stack, $arInjects);
  }
  $stmt->close();
  return $stack;
}

function GetLastNotID($group_id, $team_id) {
	$conn = db_connect();
	$stmt = $conn->prepare("SELECT not_id
                          FROM Notification
                          WHERE group_id = ?
                          AND (team_id IS NULL OR team_id = ?)
                          ORDER BY not_id
                          DESC LIMIT 1");
  $stmt->bind_param("ii", $group_id, $team_id);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows === 0) { return "null"; }
	$stmt->bind_result($not_id);
	$stmt->fetch();
	return $not_id;
}

function GetNotificationMessage($not_id) {
	$conn = db_connect();
	$stmt = $conn->prepare("SELECT group_id, team_id, message, init_submitted FROM Notification WHERE not_id = ?");
	$stmt->bind_param("i", $not_id);
	$stmt->execute();
	$stmt->bind_result($group_id, $team_id, $message, $init_submitted);
	$stmt->fetch();
  $expire = TimeAddFive($init_submitted);
  $arNotification = array("message" => $message, "init_submitted" => $init_submitted,
                          "expire" => $expire, "group_id" => $group_id, "team_id" => $team_id);
  return $arNotification;
}

function TimeAddFive($dtDate) {
  $dateTime = new DateTime($dtDate);
  $dateTime->modify('+5 minutes');
  return date_format($dateTime, 'r');
}

function GetLastInjectID($group_id) {
	$conn = db_connect();
	$stmt = $conn->prepare("SELECT inject_id FROM Inject WHERE group_id = ? ORDER BY inject_id DESC LIMIT 1");
	$stmt->bind_param("i", $group_id);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows === 0) { return 0; }
	$stmt->bind_result($inject_id);
	$stmt->fetch();
	return $inject_id;
}

function GetLastCategoryID() {
	$conn = db_connect();
	$stmt = $conn->prepare("SELECT group_id FROM Category ORDER BY group_id DESC LIMIT 1");
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows === 0) { return 0; }
	$stmt->bind_result($group_id);
	$stmt->fetch();
	return $group_id;
}

function InsertNotification($group_id, $team_id, $not_message) {
	$init_submitted = GetTime();
	$conn = db_connect();
	$stmt = $conn->prepare("INSERT INTO Notification (group_id, team_id, init_submitted, message) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("iiss", $group_id, $team_id, $init_submitted, $not_message);

  $stmt->execute();
  $stmt->close();
}

function UpdatePasswordChange($passchange_id) {
  $init_submitted = GetTime();
  $conn = db_connect();
  $stmt = $conn->prepare("UPDATE Password_Change SET status = 'T', time_changed = ? WHERE passchange_id = ?");
  $stmt->bind_param("ss", $init_submitted, $passchange_id);
  $stmt->execute();
  $stmt->close();
}

function UpdateSubmission($inject_score, $graded_by, $entry_id) {
  $conn = db_connect();
  $stmt = $conn->prepare("UPDATE Submission
                          SET inject_score = ?, graded_by = ?
                          WHERE entry_id = ?");
  $stmt->bind_param("isi", $inject_score, $graded_by, $entry_id);
  $stmt->execute();
  $stmt->close();
}

function InsertService($team_id, $service_name, $service_type, $ip, $port, $graded) {
	$conn = db_connect();
	$stmt = $conn->prepare("INSERT INTO Service (team_id, service_name, service_type, ip, port, is_graded) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("isssii", $team_id, $service_name, $service_type, $ip, $port, $graded);
  $stmt->execute();
  $stmt->close();
}

function GetGroupName($group_id) {
	$conn = db_connect();
	$stmt = $conn->prepare("SELECT group_name FROM Category WHERE group_id = ?");
	$stmt->bind_param("i", $group_id);
	$stmt->execute();
	$stmt->bind_result($group_name);
	$stmt->fetch();
	return $group_name;
}

function InsertCategory($group_type, $group_name, $comp_start, $comp_end) {
  $conn = db_connect();
  $lastGroupId = GetLastCategoryID() + 1;
  $stmt = $conn->prepare("INSERT INTO Category (group_id, group_name, comp_start, comp_end, role) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("isssi", $lastGroupId, $group_name, $comp_start, $comp_end, $group_type);
  $stmt->execute();
  $stmt->close();
  $directory = "../uploads/" . $group_name;
  if (!is_dir($directory))
  {
    mkdir($directory);
  }
}

function InsertAccount($group_id, $team_name, $team_password) {
	$dtNow = GetTime();
	$conn = db_connect();
	$stmt = $conn->prepare("INSERT INTO Team (group_id, team_name, team_password, creation_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $group_id, $team_name, $team_password, $dtNow);
    $stmt->execute();
    $stmt->close();
	$group_name = GetGroupName($group_id);
	$directory = "../uploads/" . $group_name;
	if (!is_dir($directory)) {
	  mkdir($directory);
	}
	if (!is_dir($directory . "/" . $team_name)) {
	  mkdir($directory . "/" . $team_name);
	}
}

function InsertInject($duration, $group_id, $title, $location, $points, $is_active, $is_multi, $from, $to, $message, $start_time) {
	$dtEndTime = strtotime($start_time . '+ ' .  $duration . 'minute');
	$end_time = date('r', $dtEndTime);
  $conn = db_connect();
	$stmt = $conn->prepare("INSERT INTO Inject (group_id, title, location, points, is_active, is_multi, duration, start_time, end_time, sent_by, deliver_to, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("isssssssssss", $group_id, $title, $location, $points, $is_active, $is_multi, $duration, $start_time, $end_time, $from, $to, $message);
	$stmt->execute();
	$stmt->close();
}

function CreatePDF($inject_id, $duration, $start_time, $group_name, $from, $to, $title, $message)
{
  $mpdf = new \Mpdf\Mpdf([
	'default_font_size' => 15,
	'default_font' => 'dejavusans']);

  $strWrite = '<p><b>Inject Number: </b>' . $inject_id . '</p>' .
			  '<p><b>Inject Duration: </b>' . $duration . '</p>' .
			  '<p><b>Inject Start Date/Time: </b>' . $start_time . '</p>' .
              '<p><b>Competition: </b>'. $group_name  . '</p>' .
			  '<p><b>From: </b>' . $from . '</p>' .
			  '<p><b>To: </b>' . $to . '</p>' .
			  '<p><b>Subject: </b>' . $title    . '</p>' .
			  '<p><br/>' . $message . '</p>';


  $mpdf->WriteHTML($strWrite);
  $filename = $title . ".pdf";
  $insertDir = "../CCDC_Injects/" . $filename;
  $mpdf->Output($insertDir,'F');
  $location = "CCDC_Injects/" . $filename;
  return $location;
}
?>
