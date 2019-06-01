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
    <title>Create Submission | Inject Scoring Engine 3.8</title>
    <link href="styles/create.css" rel="stylesheet" type="text/css" />
    <link href="styles/global.css" rel="stylesheet" type="text/css" />
    <link href="styles/passwordchange.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="scripts/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="scripts/js/validate.min.js"></script>
    <script type="text/javascript" src="scripts/js/jquery.serialize-object.js"></script>
    <script type="text/javascript" src="scripts/js/custom.js"></script>
  </head>
  <body class="page not-front logged-in page-node-add-ise-submission section-node-add one-sidebar sidebar-first empty-nav ">
    <div id="page-wrapper"><div id="page">
      <div id="header"><div class="section clearfix">
        <div id="logo-title">
          <div id="title-slogan">
            <div class="no-slogan">
              <h1 id="site-name">
                <a href="https://www.tri-c.edu/" target="_blank" title="Home" rel="home">Inject Scoring Engine 3.8</a>
              </h1>
            </div>
          </div> <!-- /#title-slogan -->
        </div> <!-- /#logo-title -->


    </div></div> <!-- /.section, /#header -->

    <div id="main-wrapper"><div id="main" class="clearfix ">
      <div id="content" class="column">
        <div class="section">
        <h1 class="title">Create Submission</h1>
        <div class="tabs"><ul class="tabs primary clearfix"><li class="active"><a href="passwordchange.php" class="active" indepth="true"><span class="tab" style="color: rgb(119, 119, 119);">General Information</span></a></li>
<li><a href="createpasschange.php"><span class="tab" style="color: black;">Create New Password Change Request</span></a></li>
</ul></div>

<div class="form-item">
 <label>Current System Competition: </label>
 <?php echo GetGroupName($group_id) ?>
</div>
<div class="form-item">
 <label>Team: </label>
 <?php echo $team_name; ?>
</div>
<form action="scripts/upload_submission.php" method="post" onsubmit="return fastCheck()" id="passwordchange-form"  enctype="multipart/form-data">
<div class="form-item form-group" id="edit-title-wrapper">
 <label for="service_name">Service Name: <span class="form-required" title="This field is required.">*</span></label>
 <input maxlength="25" name="service_name" id="service_name" size="60" class="form-text required" type="text" />
 <div class="description messages">Please enter the service that requires the password change.</div>
</div>
<div class="form-item form-group" id="edit-title-wrapper">
  <label for="service_password">New Password: <span class="form-required" title="This field is required.">*</span></label>
  <input maxlength="50" name="service_password" id="service_password" size="60" class="form-text required" type="text" />
  <div class="description messages">Please enter the new password here. No spaces allowed. All other standard printable characters are acceptable.</div>
</div>
<div class="form-item form-group">
  <label>Request Status: </label>
  New
</div>
<div class="form-group">
  <input name="origin" value="createpasswordchange" type="hidden" />
  <input name="op" id="edit-submit" value="Save" class="form-submit" type="submit" />
</div>
</form>

      </div></div>  <!-- /.section, /#content -->

      <div id="navigation"><div class="section clearfix">

      </div></div> <!-- /.section, /#navigation -->

      <div class="region region-sidebar-first column sidebar"><div class="section">

<div id="block-user-1" class="block block-user first last region-odd odd region-count-1 count-1  block-1"><div class="block-inner">

      <h2 class="title"><?php echo $_SESSION['nav_title'] ?></h2>

  <div class="content">
    <ul class="menu"><li class="leaf first"><a href="dashboard.php" indepth="true">Dashboard</a></li>
<?php
if ($role == 0)
{
	echo '<li class="leaf"><a href="admin.php">Admin</a></li>';
}
?>
<li class="leaf"><a href="create.php" title="Add, edit, or delete submissions." indepth="true">Submissions</a></li>
<li class="leaf"><a href="notification.php" title="Add, edit, or delete notifications." indepth="true">Notifications</a></li>
<li class="leaf"><a href="passwordchange.php" title="Add, edit, or delete password change requests to this competition." indepth="true">Password Change Requests</a></li>
<li class="leaf"><a id="time"><?php echo 'System Time: ' . GetTime(); ?></a></li>
<li class="leaf"><a href="myaccount.php" indepth="true">My account</a></li>
<li class="leaf last"><a href="logout.php" indepth="true">Log out</a></li>
</ul>  </div>


</div></div> <!-- /block-inner, /block -->
</div></div><!-- /.section, /.region -->


    </div></div> <!-- /#main, /#main-wrapper -->


  </div></div> <!-- /#page, /#page-wrapper -->
  <script type="text/javascript">
  function validatePasswordChangeForm(form, data) {
    var formConstraints = {
       service_name : {
           presence: {
             allowEmpty: false,
             message: '^Service must have name.'
           },
           length: {
            minimum: 1,
            maximum: 25,
            message: '^Service must be between 1 and 25 characters.'
          }
         },
       service_password : {
          presence: {
            allowEmpty: false,
            message: '^Service must have password.'
          },
          length: {
           minimum: 1,
           maximum: 50,
           message: '^Service must be between 1 and 50 characters.'
         }
       }
    };
    return handleValidate(form, data, formConstraints);
  }

  function fastCheck() {
    var modalForm = document.getElementById("passwordchange-form");
    var modalFormData = $("#passwordchange-form").serializeObject();
    if (validatePasswordChangeForm(modalForm, modalFormData)) {
      return true;
    }
    return false;
  }

  </script>
</body>
</html>
