<?php
  session_start();
  include 'functions.php';
  if(isset($_SESSION['team_id']) && isset($_SESSION['group_id'])) {
    $team_id = $_SESSION['team_id'];
    $group_id = $_SESSION['group_id'];
	  $team_name = $_SESSION['team_name'];
	  $role = $_SESSION['role'];
	  $group_name = GetGroupName($group_id);
	} else {
	   header('Refresh: 0; URL="login.php');
	   exit();
  }
  if (isset($_GET['id'])) {
	   $inject_id = $_GET['id'];
  } else {
	  $inject_id = 1;
  }
  $json = GetInjectInfo($inject_id);
  $from = $json['sent_by'];
  $to = $json['deliver_to'];
  $title = $json['title'];
  $message = $json['message'];
  $duration = $json['duration'];
  $start_time = $json['start_time'];
  $end_time = $json['end_time'];
  $is_active = $json['is_active'];
  if (GetTimeDiff($end_time) == true) {
	  $status = "Running";
  } else {
	  $status = "Stopped";
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title ?> | Inject Scoring Engine 3.8</title>
    <link href="styles/dashboard.css" type="text/css" rel="stylesheet" />
  </head>
  <body class="page not-front logged-in node-type-ise-inject page-node-33101 section-node one-sidebar sidebar-first empty-nav ">

  <div id="page-wrapper"><div id="page">

    <div id="header"><div class="section clearfix">

              <div id="logo-title">

              <div id="title-slogan">

                      <div class="no-slogan">              <h1 id="site-name">
                <a href="https://www.tri-c.edu/" target="_blank" title="Home" rel="home">
                Inject Scoring Engine 3.8                </a>
              </h1>
            </div>

          </div> <!-- /#title-slogan -->

        </div> <!-- /#logo-title -->


    </div></div> <!-- /.section, /#header -->

    <div id="main-wrapper"><div id="main" class="clearfix ">

      <div id="content" class="column"><div class="section">
        <h1 class="title"><?php echo $title ?></h1>
        <div id="content-area">
          <div id="node-33101" class="node node-type-ise-inject build-mode-full clearfix">

  <div class="content">
    <br><div id="inject-preview" style="font-size: larger; border: 1px solid black; padding: 10px; background-color: white;">
	<b>Inject Number: </b><?php echo $inject_id ?><br /><br />
	<b>Competition: </b><?php echo $group_name ?><br /><br />
	<b>From: </b><?php echo $from ?><br /><br />
	<b>To: </b><?php echo $to ?><br /><br />
	<b>Subject: </b><?php echo $title ?><br /><br />
	<p><?php echo $message ?></div><br /><br/>

	<div id="inject-preview" style="font-size: larger; border: 1px solid black; padding: 10px;">
	<b>Inject General Information</b></div>
	<div id="inject-preview" style="font-size: larger; border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; padding: 10px; background-color: white;">
	<b>Duration: </b><?php echo $duration . " Minutes" ?><br><br>
	<b>Inject Start Date/Time: </b><?php echo $start_time ?><br /><br />
	<b>Inject Stop Date/Time: </b><?php echo $end_time ?><br /><br />
	<b>Status: </b><?php echo $status ?></div>
   </div>

  <div class="node-links">
      </div>


</div> <!-- /.node -->

          </div>



      </div></div> <!-- /.section, /#content -->

      <div id="navigation"><div class="section clearfix">

      </div></div> <!-- /.section, /#navigation -->

      <div class="region region-sidebar-first column sidebar"><div class="section">

<div id="block-user-1" class="block block-user first last region-odd odd region-count-1 count-1  block-1"><div class="block-inner">

      <h2 class="title"><?php echo $_SESSION['nav_title'] ?></h2>

  <div class="content">
    <ul class="menu">

<li class="leaf first active-trail"><a href="dashboard.php" class="active">Dashboard</a></li>
<?php
if ($role == 0) {
	echo '<li class="leaf"><a href="admin.php">Admin</a></li>';
}
?>
<li class="leaf"><a href="submission.php" title="Add, edit, or delete submissions.">Submissions</a></li>
<li class="leaf"><a href="notification.php" title="Add, edit, or delete notifications.">Notifications</a></li>
<li class="leaf"><a href="passwordchange.php" title="Add, edit, or delete password change requests to this competition.">Password Change Requests</a></li>
<li class="leaf"><a id="time"><?php echo 'System Time: ' . GetTime(); ?></a></li>
<li class="leaf"><a href="myaccount.php">My account</a></li>
<li class="leaf last"><a href="logout.php">Log out</a></li>
</ul>  </div>

</div></div> <!-- /block-inner, /block -->


    </div></div> <!-- /#main, /#main-wrapper -->


  </div></div> <!-- /#page, /#page-wrapper -->
</body></html>
