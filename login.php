<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include 'functions.php';
  session_start();
?>
<!DOCTYPE html>
<head>
  <title>Team Dashboard | Inject Scoring Engine 3.8</title>
  <link href="styles/dashboard.css" rel="stylesheet" type="text/css" />
  <link href="styles/global.css" rel="stylesheet" type="text/css" />
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
      <h1 class="title">Welcome to the Collegiate Cyber Defense Competition Scoring Engine.</h1>
        <div id="content-area">
          Please sign in to continue.
        </div>
      </div></div> <!-- /.section, /#content -->
      <div id="navigation"><div class="section clearfix">

      </div></div> <!-- /.section, /#navigation -->

    <div class="region region-sidebar-first column sidebar"><div class="section">


<div id="block-user-1" class="block block-user first region-odd odd region-count-1 count-1  block-1"><div class="block-inner">

      <h2 class="title">Navigation</h2>

  <div class="content">
    <ul class="menu"><li class="leaf first active-trail"><a class="active">Dashboard</a></li>
<li class="leaf last"><a id="time"><?php echo 'System Time: ' . GetTime(); ?></a></li>
</ul>  </div>


</div></div> <!-- /block-inner, /block -->
<div id="block-user-1" class="block block-user first last region-odd odd region-count-1 count-1  block-1"><div class="block-inner">

      <h2 class="title">User Login</h2>

  <div class="content">
  <form action="scripts/login_script.php" method="post" enctype="multipart/form-data" id="user-login-form">
<div><div class="form-item" id="edit-name-wrapper">
 <label for="edit-name">Username: <span class="form-required" title="This field is required.">*</span></label>
 <input type="text" maxlength="60" name="name" id="edit-name" size="15" value="" class="form-text required" />
</div>
<div class="form-item" id="edit-pass-wrapper">
 <label for="edit-pass">Password: <span class="form-required" title="This field is required.">*</span></label>
 <input type="password" name="pass" id="edit-pass"  maxlength="60"  size="15"  class="form-text required" />
</div>
<input type="submit" name="op" id="edit-submit" value="Log in"  class="form-submit" />
<div class="item-list"><ul><li class="first last"><a onclick="passDetail();" style="cursor: pointer" title="Request new password via e-mail.">Request new password</a></li>
</ul></div><input type="hidden" name="form_build_id" id="form-154fb64051ed57d138f1296c3fdbc6df" value="form-154fb64051ed57d138f1296c3fdbc6df"  />
<input type="hidden" name="form_id" id="edit-user-login-block" value="user_login_block"  />

</div></form>
</div></div> <!-- /block-inner, /block -->
</div></div><!-- /.section, /.region -->


    </div></div> <!-- /#main, /#main-wrapper -->
  </div></div> <!-- /#page, /#page-wrapper -->
  <script type="text/javascript">
  function passDetail() {
	  alert("Contact Amanda Szampias for a new password.");
  }
  </script>
</body>
</html>
