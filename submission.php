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
  <title>Submissions | Inject Scoring Engine 3.8</title>
  <link href="styles/submission.css" rel="stylesheet" type="text/css" />
</head>
<body class="page not-front logged-in page-ise-submission section-ise one-sidebar sidebar-first empty-nav ">
  <div id="page-wrapper"><div id="page">
    <div id="header"><div class="section clearfix">
              <div id="logo-title">
              <div id="title-slogan">
                      <div class="no-slogan">
               <h1 id="site-name">
                <a href="http://www.tri-c.edu/" target="_blank" title="Home" rel="home">
                Inject Scoring Engine 3.8</a>
              </h1>
            </div>

          </div> <!-- /#title-slogan -->

        </div> <!-- /#logo-title -->

    </div></div> <!-- /.section, /#header -->

    <div id="main-wrapper"><div id="main" class="clearfix ">
      <div id="content" class="column"><div class="section">
       <h1 class="title">Submissions</h1>
        <div class="tabs">
          <ul class="tabs primary clearfix">
            <li class="active"><a href="submission.php" class="active"><span class="tab">General Information</span></a></li>
            <li><a href="create.php"><span class="tab">Create New Submission</span></a></li>
          </ul></div>

        <div id="content-area">
          <table class="sticky-enabled">
<caption>Inject Submissions - Rows in bold represent late submissions, or submissions that were edited after the inject was stopped.</caption>
 <thead><tr><th>Inject Number</th><th>Team</th><th>Title</th><th>Initially Submitted</th><th>Last Updated</th><th>Filename</th> </tr></thead>
<tbody>
  <?php
    $arSubmissions = GetSubmissions($team_id);
	if (!empty($arSubmissions)) {
    for($i = 0; $i <  count($arSubmissions); $i++) {
       $arrSubmission = $arSubmissions[$i];
       echo '<tr class="odd"><td>' . $arrSubmission["inject_id"] . '</td><td>' .
       $team_name . '</td><td>'  .
       $arrSubmission["title"] . '</td><td>' .
		   $arrSubmission["init_submitted"] .
       '</td><td>-</td><td><a target="_blank" href="' .
       $arrSubmission["location"] . '">' .
       $arrSubmission["filename"] . '</a></td>';
    }
	} else {
	   echo '<tr class="odd"><td colspan="7" style="text-align: center">No Submissions to show.</td></tr>';
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
<li class="leaf active-trail"><a href="submission.php" title="Add, edit, or delete submissions." class="active">Submissions</a></li>
<li class="leaf"><a href="notification.php" title="Add, edit, or delete notifications.">Notifications</a></li>
<li class="leaf"><a href="passwordchange.php" title="Add, edit, or delete password change requests to this competition.">Password Change Requests</a></li>
<li class="leaf"><a href="time"><?php echo 'System Time: ' . GetTime(); ?></a></li>
<li class="leaf"><a href="myaccount.php">My account</a></li>
<li class="leaf last"><a href="logout.php">Log out</a></li>
</ul>  </div>


</div></div> <!-- /block-inner, /block -->
</div></div><!-- /.section, /.region -->


    </div></div> <!-- /#main, /#main-wrapper -->


  </div></div> <!-- /#page, /#page-wrapper -->

</body>
</html>
