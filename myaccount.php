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
  <title>Account | Inject Scoring Engine 3.8</title>
  <link href="styles/myaccount.css" rel="stylesheet" type="text/css" />
  <link href="styles/global.css" rel="stylesheet" type="text/css" />
</head>
<body class="page not-front logged-in page-user-415 section-user one-sidebar sidebar-first empty-nav ">
  <div id="page-wrapper"><div id="page">
    <div id="header"><div class="section clearfix">


              <div id="logo-title">


              <div id="title-slogan">

                      <div class="no-slogan">              <h1 id="site-name">
                <a href="http://www.tri-c.edu/" target="_blank" title="Home" rel="home">
                Inject Scoring Engine 3.8</a>
              </h1>
            </div>

          </div> <!-- /#title-slogan -->

        </div> <!-- /#logo-title -->


    </div></div> <!-- /.section, /#header -->

    <div id="main-wrapper"><div id="main" class="clearfix ">

      <div id="content" class="column"><div class="section">
      <h1 class="title"><?php echo $_SESSION['nav_title'] ?></h1>
        <div id="content-area">
          <div class="profile">
  <div class="picture">
  </div>
  <h3>History</h3>

<dl class="user-member">
  <dt>Member for</dt>
  <dd><?php echo GetMyAccountTimeDiff($team_id) ?> </dd>
</dl>
</div>
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
<li class="leaf"><a href="passwordchange.php" title="Add, edit, or delete password change requests to this competition.">Password Change Requests</a></li>
<li class="leaf"><a id="time"><?php echo 'System Time: ' . GetTime(); ?></a></li>
<li class="leaf active-trail"><a href="myaccount.php" class="active">My account</a></li>
<li class="leaf last"><a href="logout.php">Log out</a></li>
</ul>  </div>


</div></div> <!-- /block-inner, /block -->
</div></div><!-- /.section, /.region -->


    </div></div> <!-- /#main, /#main-wrapper -->

  </div></div> <!-- /#page, /#page-wrapper -->
  </body>
</html>
