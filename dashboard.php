<?php
  include 'functions.php';
  session_start();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  if(isset($_SESSION['team_id']) && isset($_SESSION['group_id'])) {
    $team_id = $_SESSION['team_id'];
    $group_id = $_SESSION['group_id'];
	  $team_name = $_SESSION['team_name'];
	  $role = $_SESSION['role'];
	  $group_m = GetCompInfo($group_id);
	  $group_name = $group_m["group_name"];
	  $comp_start = $group_m["comp_start"];
	   $comp_end = $group_m["comp_end"];
  } else {
	header('Refresh: 0; URL="login.php');
	exit();
  }
  if (isset($_SESSION["not_id"]) == false) {
	 $_SESSION["not_id"] = GetLastNotID($group_id, $team_id);
  }

 ?>
<!DOCTYPE html>
<head>
  <title>Team Dashboard | Inject Scoring Engine 3.8</title>
  <meta http-equiv="refresh" content="60" />
  <link href="styles/dashboard.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    #notbox { width: 65%;
	            line-height: 45px;
			        border: 1px dashed black;
			        display: block;
			        visibility: visible;}
  </style>
  <!--<link href="styles/global.css" rel="stylesheet" type="text/css" /> -->
</head>
<body class="page front logged-in one-sidebar sidebar-first empty-nav ">
  <div id="page-wrapper"><div id="page">

    <div id="header"><div class="section clearfix">
              <div id="logo-title">
              <div id="title-slogan">

                      <div class="no-slogan">              <h1 id="site-name">
                <a href="http://www.tri-c.edu" target="_blank" title="Home" rel="home">
                Inject Scoring Engine 3.8</a>
              </h1>
            </div>

          </div> <!-- /#title-slogan -->

        </div> <!-- /#logo-title -->


    </div></div> <!-- /.section, /#header -->

    <div id="main-wrapper"><div id="main" class="clearfix ">

      <div id="content" class="column">
        <div class="section">
		<?php
  		$not_id = GetLastNotID($group_id, $team_id);
  		if ($not_id != "null") {
  		   $arNotification = GetNotificationMessage($not_id);
         if (GetTimeDiff($arNotification["expire"]) == true && ($arNotification["team_id"] == $team_id || $arNotification["team_id"] == NULL)) {
  		   echo '<div id="notbox"><img src="images/info_icon.png" style="width: 40px; height: 40px; float: left;"  />' . $arNotification["message"] . '</div>';
       }
     }
	  ?>
		<br />
      <h1 class="title">Team Dashboard</h1>
        <div id="content-area">
          <b>Competition Name:</b> <?php echo $group_name ?><div style="height: 10px;"></div>
          <b>Competition Location:</b> CSSIA Virtual Lab Environment<div style="height: 10px;"></div>
          <b>Competition Address:</b> Cuyahoga Community College, Parma, OH
          <div style="height: 10px;"></div><b>Competition Start Date:</b> <?php echo $comp_start ?>
          <div style="height: 10px;"></div><b>Competition End Date:</b> <?php echo $comp_end ?>
          <div style="height: 10px;"></div><b>Team Name:</b> <?php echo $team_name ?><div style="height: 10px;"></div>
          <b>Available Injects (Rows in bold are recently released):</b><br></b>
          <?php
          $arInjects = GetInjects($group_id);

          if (!empty($arInjects)) {
             for($i = 0; $i <  count($arInjects); $i++) {
               $arrInject = $arInjects[$i];
               echo '<a href="injtemp.php?id=' . $arrInject["inject_id"] . '">' . $arrInject["inject_id"] . ' - ' . $arrInject["title"] .
			              '</a> <a target="_blank" href="' . $arrInject["location"] . '">(PDF)</a><br />';
             }
          } else {
		         echo 'No injects to show.';
		      }
          ?>
          <table class="sticky-enabled">
            <caption>Service Checks</caption>
            <thead><tr><th>Team</th><th>Service Name</th><th>Last Check Status</th> </tr></thead>
              <tbody>
                <?php
                $arServices = GetServicesByTeamId($team_id);
                if (!empty($arServices)) {
                   for($x = 0; $x < count($arServices); $x++) {
                     $arrService = $arServices[$x];
                     echo '<tr style="font-style: italic;" class="odd"><td>' . $team_name . '</td><td>' . $arrService["service_name"] . '</td>';
                     if ($arrService["is_active"] == 1) {
                       echo '<td style="background-color: rgb(152, 251, 152);">Passed</td></tr>';
                     }
                     else {
                       echo '<td style="background-color: rgb(255, 193, 193);">Failed</td></tr>';
                     }
                   }
                } else {
                  echo '<tr><td colspan="3" style="text-align: center; font-style: italic; border: 1px solid rgb(139, 183, 106);">No services to show.</td></tr>';
                }
                ?>
              </tbody>
          </table>
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
</div></div><!-- /.section, /.region -->


    </div></div> <!-- /#main, /#main-wrapper -->
  </div></div> <!-- /#page, /#page-wrapper -->
</body>
</html>
