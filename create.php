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
    <script type="text/javascript" src="scripts/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="scripts/js/validate.min.js"></script>
    <script type="text/javascript" src="scripts/js/jquery.serialize-object.js"></script>
    <script type="text/javascript" src="scripts/js/custom.js"></script>
    <link href="styles/submission.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="page not-front logged-in page-node-add-ise-submission section-node-add one-sidebar sidebar-first empty-nav ">
    <div id="page-wrapper"><div id="page">
      <div id="header"><div class="section clearfix">
        <div id="logo-title">
          <div id="title-slogan">
            <div class="no-slogan">
              <h1 id="site-name">
                <a href="http://www.tri-c.edu/" target="_blank" title="Home" rel="home">Inject Scoring Engine 3.8</a>
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
            <li class="active"><a href="submission.php" class="active"><span class="tab" style="color: rgb(119, 119, 119);">General Information</span></a></li>
            <li><a href="create.php"><span class="tab" style="color: black;">Create New Submission</span></a></li>
          </ul></div>

<div class="form-item">
 <label>Current System Competition: </label>
 <?php echo GetGroupName($group_id) ?>
</div>
<form action="scripts/upload_submission.php" onsubmit="return fastCheck()" method="post" id="submission-form"  enctype="multipart/form-data">
<div class="form-item form-group">
 <label>Team: </label>
 <?php echo $team_name; ?>
</div>
<div class="form-item form-group">
 <label for="inject_id">Inject: <span class="form-required" title="This field is required.">*</span></label>
 <select name="inject_id" class="form-select required" id="inject_id">
   <option value=""></option>
   <?php
    $arInjects = GetInjects($group_id);
    if ($arInjects != 0) {
      for ($i = 0; $i < count($arInjects); $i++) {
        $arrInject = $arInjects[$i];
	      if (GetInjectAlreadyDone($arrInject["team_id"], $arrInject["inject_id"]) == true OR $arrInject["is_multi"] == 'T') {
		      # end_time must be greater than Now.
            if (GetTimeDiff($arrInject["end_time"]) == true) {
              echo '<option value="' . $arrInject["inject_id"] . '">' . $arrInject["inject_id"] . ' - ' . $arrInject["title"] . '</option>';
	          }
	       }
       }
     }
    ?>
 </select>
 <div class="description messages">Select the inject to associate with this submission.</div>
</div>
<div class="form-item form-group">
 <label for="title">Submission Title: <span class="form-required" title="This field is required.">*</span></label>
 <input maxlength="128" name="title" id="title" size="60" class="form-text required" type="text" />
 <div class="description messages">Please name this submission.</div>
</div>
<div class="form-item form-group">
 <label for="body">Submission Text: </label>
 <textarea cols="60" rows="5" name="body" id="body" class="form-textarea resizable"></textarea>
 <div class="description messages">This field can be used to describe your attachment, or be used as the submission itself.</div>
</div>
<div class="form-item form-group">
 <label for="edit-submission-filename">Submission File: </label>
 <input type="file" name="fileToUpload" id="fileToUpload" class="form-file" size="60" />
 <div class="description">Please select a file to upload for this submission. Maximum file size of 2 megabytes.</div>
</div>
<div class="form-item form-group">
<input name="origin" value="createsubmission" type="hidden" />
<input name="op" id="edit-submit" value="Save" class="form-submit" type="submit">
</div>
</form>

      </div></div> <!-- /.section, /#content -->

      <div id="navigation"><div class="section clearfix">

      </div></div> <!-- /.section, /#navigation -->

      <div class="region region-sidebar-first column sidebar"><div class="section">

<div id="block-user-1" class="block block-user first last region-odd odd region-count-1 count-1  block-1"><div class="block-inner">

      <h2 class="title"><?php echo $_SESSION['nav_title'] ?></h2>

  <div class="content">
    <ul class="menu"><li class="leaf first"><a href="dashboard.php" indepth="true">Dashboard</a></li>
<?php
if ($role == 0) {
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

  function validateSubmissionForm(form, data) {
    var formConstraints = {
       inject_id : {
           presence: {
             allowEmpty: false,
             message: '^Inject must be selected.'
           }
         },
       title : {
          presence: {
            allowEmpty: false,
            message: '^Submission must have title.'
          },
          length: {
           minimum: 1,
           maximum: 50,
           message: '^Title must be between 1 and 50 characters.'
         }
       }
    };
    return handleValidate(form, data, formConstraints);
  }

  function fastCheck() {
    var modalForm = document.getElementById("submission-form");
    var modalFormData = $("#submission-form").serializeObject();
    if (validateSubmissionForm(modalForm, modalFormData)) {
      return true;
    }
    return false;
  }
  </script>
</body>
</html>
