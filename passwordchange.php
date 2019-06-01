<?php
  session_start();
  if(isset($_SESSION['team_id']) && isset($_SESSION['group_id'])) {
    $team_id = $_SESSION['team_id'];
    $group_id = $_SESSION['group_id'];
	  $team_name = $_SESSION['team_name'];
	  $role = $_SESSION['role'];
  } else {
	  header('Refresh: 0; URL="login.php');
	  exit();
  }
  include 'functions.php';
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Password Change Requests | Inject Scoring Engine 3.8</title>
	<meta http-equiv="refresh" content="60" />
    <link href="styles/passwordchange.css" rel="stylesheet" type="text/css" />
    <link href="styles/global.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="page not-front logged-in page-ise-passwordchange section-ise one-sidebar sidebar-first empty-nav ">

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

      <div id="content" class="column"><div class="section">

                          <h1 class="title">Password Change Requests</h1>
                                  <div class="tabs"><ul class="tabs primary clearfix"><li class="active"><a href="passwordchange.php" class="active" indepth="true"><span class="tab">General Information</span></a></li>
<li><a href="createpasschange.php"><span class="tab">Create New Password Change Request</span></a></li>
</ul></div>


        <div id="content-area">
          <table class="sticky-enabled">
<caption>Password Change Requests - Rows in bold are new entries. Italic entries have been completed.</caption>
 <thead><tr><th>Team</th><th>Service</th><th>Partial Password</th><th>Status</th><th>Operations</th> </tr></thead>
<tbody>
 <?php
 $arPassword = GetPasswords($team_id);
 if (!empty($arPassword)) {
   for($i = 0; $i < count($arPassword); $i++) {
     $arrPasswords = $arPassword[$i];
	 $strPattern = "odd";
	 if (($i + 1) % 2 == 0) {
		 $strPattern = "even";
	 }
     echo '<tr class=' . $strPattern . '><td>' .
     $arrPasswords['team_id'] . '</td><td>' .
     $arrPasswords['service'] . '</td><td>' .
     $arrPasswords['new_password'] . '</td><td>' .
     $arrPasswords['status'] . '</td><td>' .
     $arrPasswords['time_changed'] . '</td></tr>';
   }
 } else {
   echo '<tr class="odd"><td colspan="5" style="text-align: center;">No password change requests found.</td></tr>';
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
    <ul class="menu"><li class="leaf first"><a href="dashboard.php">Dashboard</a></li>
<?php
if ($role == 0) {
	echo '<li class="leaf"><a href="admin.php">Admin</a></li>';
}
?>
<li class="leaf"><a href="submission.php" title="Add, edit, or delete submissions.">Submissions</a></li>
<li class="leaf"><a href="notification.php" title="Add, edit, or delete notifications.">Notifications</a></li>
<li class="leaf active-trail"><a href="passwordchange.php" title="Add, edit, or delete password change requests to this competition." class="active">Password Change Requests</a></li>
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
