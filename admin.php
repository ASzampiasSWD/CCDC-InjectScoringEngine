<?php
  session_start();
  if(isset($_SESSION['role']) && $_SESSION['role'] == 0) {
	   $team_id = $_SESSION['team_id'];
     $group_id = $_SESSION['group_id'];
     $team_name = $_SESSION['team_name'];
     $role = $_SESSION['role'];
  } else {
	  header('Refresh: 0; URL="dashboard.php');
	  exit();
  }
  include 'functions.php';
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
  <head>
  <title>Submissions | Inject Scoring Engine 3.8</title>
  <link href="styles/create.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="scripts/js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="scripts/js/validate.min.js"></script>
  <script type="text/javascript" src="scripts/js/jquery.serialize-object.js"></script>
  <script type="text/javascript" src="scripts/js/custom.js"></script>
  <style type="text/css">
	a { cursor: pointer;}

  td, th { padding: 5px;
           border: 1px solid blue;
           font-size: 12pt; }

  table { border-collapse: collapse;}
  </style>
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
	   <h1 class="title">Admin Panel</h1>
		<div class="tabs">
		  <ul class="tabs primary clearfix">
			  <li><a id="tabCreateInject"><span class="tab">Create Inject</span></a></li>
		    <li><a id="tabNotification"><span class="tab">Create Notification</span></a></li>
			  <li><a id="tabCompetitionGroup"><span class="tab">Create Competition Group</span></a></li>
			  <li><a id="tabTeam"><span class="tab">Create Team/Admin/User</span></a></li>
        <li><a id="tabShowDatabase"><span class="tab">Show Database</span></a></li>
        <li><a id="tabAddService"><span class="tab">Add Service</span></a></li>
        <li><a id="tabPassChange"><span class="tab">Password Change Requests</span></a></li>
			  <li><a id="tabGradeInjects"><span class="tab">Grade Submitted Injects</span></a></li>
		  </ul>
		</div>
		<div id="content-area">


		<div id="CreateInject">
      <h1>Create Inject</h1>
	    <form action="scripts/upload_submission.php" onsubmit="return fastCheck()" method="post" id="createinject-form"  enctype="multipart/form-data">
        <div class="form-item form-group" id="edit-inject-id-wrapper">
          <label for="group_id_1">Group: <span class="form-required" title="This field is required.">*</span></label>
          <select name="group_id_1" class="form-select required" id="group_id_1">
            <option value=""></option>
            <?php
        	   $arCategory = GetCategory();
        	    if (!empty($arCategory)) {
        	       for ($i = 0; $i < count($arCategory); $i++) {
      		         $arrCategory = $arCategory[$i];
    		           echo '<option value="' . $arrCategory['group_id'] . '">' . $arrCategory['group_name'] . '</option>';
  	            }
      	      }
        	?>
         </select>
         <div class="description messages">Select a Group to associate with this inject.</div>
     </div>
      <div class="form-item form-group" id="edit-inject-id-wrapper">
       <label for="is_multi">Multiple Submissions: <span class="form-required" title="This field is required.">*</span></label>
       <select name="is_multi" class="form-select required" id="is_multi">
         <option value=""></option>
         <option value="T">Yes</option>
         <option value="F">No</option>
       </select>
       <div class="description messages">Are multiple submissions allowed for this inject?</div>
      </div>
      <div class="form-item form-group" id="edit-inject-id-wrapper">
       <label for="is_active">Inject Active: <span class="form-required" title="This field is required.">*</span></label>
       <select name="is_active" class="form-select required" id="is_active">
         <option value=""></option>
         <option value="T">Yes</option>
         <option value="F">No</option>
       </select>
       <div class="description messages">Is this Inject Active?</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
        <label for="inject_name">Inject Name: <span class="form-required" title="This field is required.">*</span></label>
        <input maxlength="128" name="inject_name" id="inject_name" size="60" class="form-text required" type="text" />
        <div class="description messages">Please name this submission.</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
        <label for="inject_duration">Inject Duration: <span class="form-required" title="This field is required.">*</span></label>
        <input maxlength="128" name="inject_duration" id="inject_duration" size="60" class="form-text required" type="text" />
        <div class="description messages">Use an integer in minutes. Example: 90 for 90 minutes.</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
        <label for="inject_points">Points for Inject: <span class="form-required" title="This field is required.">*</span></label>
        <input maxlength="128" name="inject_points" id="inject_points" size="60" value="" class="form-text required" type="text" />
        <div class="description messages">Total point value for the Inject.</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
        <label for="inject_from">From: <span class="form-required" title="This field is required.">*</span></label>
        <input maxlength="128" name="inject_from" id="inject_from" size="60" value="" class="form-text required" type="text" />
        <div class="description messages">Who is requesting this inject? Example: CEO.</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
        <label for="inject_to">To: <span class="form-required" title="This field is required.">*</span></label>
        <input maxlength="128" name="inject_to" id="inject_to" size="60" value="" class="form-text required" type="text" />
        <div class="description messages">Who is receiving this inject? Example: IT Staff.</div>
      </div>
      <div class="form-item form-group" id="edit-body-wrapper">
        <label for="inject_body">Message Body: <span class="form-required" title="This field is required.">*</span></label>
        <textarea cols="60" rows="5" name="inject_body" id="inject_body" style="white-space: pre-wrap;" class="form-textarea resizable"></textarea>
        <div class="description messages">Message of the Inject.</div>
      </div>
      <div class="form-group">
        <input type="hidden" name="origin" id="origin" value="admincreateinject" />
        <input name="op" id="edit-submit" value="Save" class="form-submit" type="submit" />
      </div>
      </form>
    </div> <!-- create Inject -->


    <div id="CreateNotification"> <!-- Create Notification -->
      <h1>Create Notification</h1>
    <form action="scripts/upload_submission.php" onsubmit="return fastCheck()"  method="post" id="notification-form"  enctype="multipart/form-data">
      <div class="form-item form-group" id="edit-inject-id-wrapper">
       <label for="group_id_2">Group: <span class="form-required" title="This field is required.">*</span></label>
       <select name="group_id_2" onchange="onChangeNotificationGroup()" class="form-select required" id="group_id_2">
         <option value=""></option>
         <?php
      	 $arCategory = GetCategory();
      	 if (!empty($arCategory)) {
      	   for ($i = 0; $i < count($arCategory); $i++) {
      		     $arrCategory = $arCategory[$i];
      		     echo '<option value="' . $arrCategory['group_id'] . '">' . $arrCategory['group_name'] . '</option>';
      	   }
      	 }
      	?>
       </select>
       <div class="description messages" id="errGroupID_2">Select a Group to send notification to.</div>
      </div>
      <div class="form-item form-group" id="edit-inject-id-wrapper">
       <label for="team_id_not">Team: <span class="form-required" title="This field is required.">*</span></label>
       <select name="team_id_not" class="form-select required" id="team_id_not">
       </select>
       <div class="description messages">Select a Team to associate with this notification. Default is everyone in a group.</div>
      </div>
      <div class="form-item form-group" id="edit-body-wrapper">
       <label for="not_message">Message: </label>
       <input type="text" size="60" name="not_message" id="not_message" value="" />
       <div class="description messages" id="errNotMessage">Write the Notification Message here. Notifications will display on the dashboard for 5 minutes.</div>
      </div>
      <div class="form-group">
        <input name="op" id="edit-submit" value="Save" class="form-submit" type="submit" />
        <input type="hidden" name="origin" id="origin" value="admincreatenotification" />
      </div>
    </form>
    </div><!-- Create Notification -->

    <div id="CreateCompetitionGroup"><!-- Create Competition Group -->
      <h1>Create Competition Group</h1>
      <form action="scripts/upload_submission.php" onsubmit="return fastCheck()"  method="post" id="creategroup-form"  enctype="multipart/form-data">
      <div class="form-item form-group" id="edit-title-wrapper">
     <label for="group_type">Group Type: <span class="form-required" title="This field is required.">*</span></label>
     <select name="group_type" class="form-select required" id="group_type">
       <option value=""></option>
       <option value="0">New Admin For Website</option>
       <option value="1">Teams vs Teams</option>
       <option value="2">One User Practice Only</option>
     </select>
     <div class="description messages">Select a Group to associate with this Team.</div>
    </div>
    <div class="form-item form-group" id="edit-inject-id-wrapper">
       <label for="group_name">Group Name: <span class="form-required" title="This field is required.">*</span></label>
       <input maxlength="128" name="group_name" id="group_name" size="60" value="" class="form-text required" type="text" />
       <div class="description messages">Name for the Group.</div>
    </div>
    <div class="form-item form-group" id="edit-inject-id-wrapper">
       <label for="comp_start_date">Competition Start Date: <span class="form-required" title="This field is required.">*</span></label>
       <input maxlength="128" name="comp_start_date" id="comp_start_date" size="60" class="form-text required" type="date" />
       <div class="description messages">Start time Injects will show up.</div>
    </div>
    <div class="form-item form-group" id="edit-inject-id-wrapper">
       <label for="comp_start_time">Competition Start Time: <span class="form-required" title="This field is required.">*</span></label>
       <input maxlength="128" name="comp_start_time" id="comp_start_time" size="60" class="form-text required" type="time" />
       <div class="description messages">Start time Injects will show up.</div>
    </div>
    <div class="form-item form-group" id="edit-inject-id-wrapper">
       <label for="comp_end_date">Competition End Date: <span class="form-required" title="This field is required.">*</span></label>
       <input maxlength="128" name="comp_end_date" id="comp_end_date" size="60" value="" class="form-text required" type="date" />
       <div class="description messages">Date Competition will end.</div>
    </div>
    <div class="form-item form-group" id="edit-inject-id-wrapper">
       <label for="comp_end_time">Competition End Time: <span class="form-required" title="This field is required.">*</span></label>
       <input maxlength="128" name="comp_end_time" id="comp_end_time" size="60" class="form-text required" type="time" />
       <div class="description messages">Time when Injects will end.</div>
    </div>
    <div class="form-group">
      <input type="hidden" name="origin" id="origin" value="admincreategroup" />
      <input name="op" id="edit-submit" value="Save" class="form-submit" type="submit" />
    </div>
    </form>
    </div><!-- Create Competition Group -->

    <div id="ShowDatabase"> <!-- Show Database -->
      <h1>Show Tables</h1>
      <?php
      $arCategory = GetCategory();
      echo '<h2>Category Table</h2>';
      echo '<table>
      <tr>
      <th>Group Id</th>
      <th>Group Name</th>
      <th>Comp Start</th>
      <th>Comp End</th>
      <th>Role Number</th>
      </tr>';
      if (!empty($arCategory))
      {
        for ($i = 0; $i < count($arCategory); $i++)
        {

        $arrCategory = $arCategory[$i];
        echo '<tr><td>' . $arrCategory['group_id'] . '</td>' .
              '<td>' . $arrCategory['group_name'] . '</td>' .
              '<td>' . $arrCategory['comp_start'] . '</td>'  .
              '<td>' . $arrCategory['comp_end'] . '</td>' .
              '<td style="text-align: center">' . $arrCategory['role'] . '</td></tr>';
        }
      }
      echo '</table><br /><br />';
      $arTeam = GetTeam();
      echo '<h2>Team Table</h2>';
      echo '<table>
      <tr>
      <th>Team Id</th>
      <th>Group Id</th>
      <th>Team Name</th>
      <th>Team Password</th>
      <th>Team Score</th>
      </tr>';
      if (!empty($arTeam)) {
        for ($i = 0; $i < count($arTeam); $i++) {
        $arrTeam = $arTeam[$i];
        echo '<tr><td>' . $arrTeam['team_id'] . '</td>' .
              '<td>' . $arrTeam['group_id'] . '</td>' .
              '<td>' . $arrTeam['team_name'] . '</td>' .
              '<td>' . $arrTeam['team_password'] . '</td>'  .
              '<td style="text-align: center">' . $arrTeam['team_score'] . '</td></tr>';
        }
      }
      echo '</table>';

      $arNotification = GetAllNotifications();
      echo '<br /><br /><h2>Notification Table</h2>';
      echo '<table>
      <tr>
      <th>Notification Id</th>
      <th>Group Id</th>
      <th>Team Id</th>
      <th>Message</th>
      <th>Init Submitted</th>
      </tr>';
      if (!empty($arNotification)) {
        for ($i = 0; $i < count($arNotification); $i++) {
        $arrNotification = $arNotification[$i];
        echo '<tr><td>' . $arrNotification['not_id'] . '</td>' .
              '<td>' . $arrNotification['group_id'] . '</td>' .
              '<td>' . $arrNotification['team_id'] . '</td>' .
              '<td>' . $arrNotification['message'] . '</td>'  .
              '<td>' . $arrNotification['init_submitted'] . '</td></tr>';
        }
      }
      echo '</table>';

      $arService = GetAllServices();
      echo '<br /><br /><h2>Service Table</h2>';
      echo '<table>
      <tr>
      <th>Service Id</th>
      <th>Team Id</th>
      <th>Service Name</th>
      <th>Service Type</th>
      <th>IP</th>
      <th>Port</th>
      <th>Is Active?</th>
      <th>Is Graded?</th>
      <th>Service Score</th>
      </tr>';
      if (!empty($arService )) {
        for ($i = 0; $i < count($arService ); $i++) {
        $arrService  = $arService [$i];
        echo '<tr><td>' . $arrService['service_id'] . '</td>' .
              '<td>' . $arrService['team_id'] . '</td>' .
              '<td>' . $arrService['service_name'] . '</td>' .
              '<td>' . $arrService['service_type'] . '</td>'  .
              '<td>' . $arrService['ip'] . '</td>' .
              '<td>' . $arrService['port'] . '</td>' .
              '<td style="text-align: center">' . $arrService['is_active'] . '</td>' .
              '<td style="text-align: center">' . $arrService['is_graded'] . '</td>' .
              '<td style="text-align: center">' . $arrService['service_score'] . '</td></tr>';
        }
      }
      echo '</table><br /><br />';

      $arPasswordChange = GetAllPasswordChanges();
      echo '<h2>Password Change Table</h2>';
      echo '<table>
      <tr>
      <th>Team Name</th>
      <th>Service</th>
      <th>Team Password</th>
      <th>Status</th>
      </tr>';

      if (!empty($arPasswordChange)) {
        for ($w = 0; $w < count($arPasswordChange); $w++) {
        $arrChange = $arPasswordChange[$w];
        echo '<tr><td>' . $arrChange['team_name'] . '</td>' .
              '<td>' . $arrChange['service'] . '</td>' .
              '<td>' . $arrChange['new_password'] . '</td>' .
              '<td style="text-align: center;">' . $arrChange['status'] . '</td></tr>';
        }
      }
      echo '</table><br /><br />';

      $arInjects = GetAllInjects();
      echo '<h2>Inject Table</h2>';
      echo '<table>
      <tr>
      <th>Inject Id</th>
      <th>Group Id</th>
      <th>Title</th>
      <th>Points</th>
      <th>Is Active?</th>
      <th>Is Multi?</th>
      <th>Duration</th>
      <th>Start Time</th>
      <th>End Time</th>
      </tr>';
      if (!empty($arInjects)) {
        for ($h = 0; $h < count($arInjects); $h++) {
        $arrInject = $arInjects[$h];
        echo '<tr><td>' . $arrInject['inject_id'] . '</td>' .
              '<td>' . $arrInject['group_id'] . '</td>' .
              '<td>' . $arrInject['title'] . '</td>' .
              '<td>' . $arrInject['points'] . '</td>'  .
              '<td style="text-align: center">' . $arrInject['is_active'] . '</td>' .
              '<td style="text-align: center">' . $arrInject['is_multi'] . '</td>' .
              '<td>' . $arrInject['duration'] . '</td>' .
              '<td>' . $arrInject['start_time'] . '</td>' .
              '<td>' . $arrInject['end_time'] . '</td></tr>';
        }
      }
      echo '</table><br /><br />';

     ?>
    </div> <!-- Show Database -->

    <div id="CreateTeam"><!-- Create Team -->
      <h1>Create New Team</h1>
      <form action="scripts/upload_submission.php" onsubmit="return fastCheck()"  method="post" id="createteam-form"  enctype="multipart/form-data">
      	<div class="form-item form-group" id="edit-inject-id-wrapper">
         <label for="group_id_3">Group: <span class="form-required" title="This field is required.">*</span></label>
         <select name="group_id_3" class="form-select required" id="group_id_3">
           <option value=""></option>
           <?php
        	 $arCategory = GetCategory();
        	 if (!empty($arCategory)) {
        	   for ($i = 0; $i < count($arCategory); $i++) {
        		 $arrCategory = $arCategory[$i];
        		 echo '<option value="' . $arrCategory['group_id'] . '">' . $arrCategory['group_name'] . '</option>';
        	   }
        	 }
        	?>
         </select>
         <div class="description messages" id="errGroupID_3">Select a Group to associate with this Team.</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
         <label for="team_name">Team Name: <span class="form-required" title="This field is required.">*</span></label>
         <input maxlength="128" name="team_name" id="team_name" size="60" value="" class="form-text required" type="text" />
         <div class="description messages">Name for the User, Team, or Admin.</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
         <label for="team_password">Password: <span class="form-required" title="This field is required.">*</span></label>
         <input maxlength="128" name="team_password" id="team_password" size="60" value="" class="form-text required" type="text" />
         <div class="description messages">Password for new Account.</div>
      </div>
       <div class="form-group">
         <input type="hidden" name="origin" id="origin" value="admincreateteam" />
         <input name="op" id="edit-submit" value="Save" class="form-submit" type="submit" />
       </div>
     </form>
  </div> <!-- Create Team -->


  <div id="AddService"><!-- Add Service -->
      <form action="scripts/upload_submission.php" onsubmit="return fastCheck()"  method="post" id="addservice-form"  enctype="multipart/form-data">
        <h1>Add Service</h1>
        <div class="form-item form-group" id="edit-inject-id-wrapper">
          <label for="team_id_2">Team: <span class="form-required" title="This field is required.">*</span></label>
          <select name="team_id_2" class="form-select required" id="team_id_2">
           <option value=""></option>
           <?php
           $arTeam = GetTeam();
           if (!empty($arTeam)) {
             for ($z = 0; $z < count($arTeam); $z++) {
             $arrTeam = $arTeam[$z];
             echo '<option value="' . $arrTeam['team_id'] . '">' . $arrTeam['team_name'] . '</option>';
             }
           }
          ?>
          </select>
          <div class="description messages">Select a Group to associate with this Team.</div>
      </div>
      <div class="form-item form-group" id="edit-inject-id-wrapper">
     <label for="service_type">Type of Service: <span class="form-required" title="This field is required.">*</span></label>
       <select name="service_type" class="form-select required" id="service_type">
         <option value=""></option>
         <option value="http">http</option>
         <option value="ssh">ssh</option>
         <option value="https">https</option>
         <option value="ftp">ftp</option>
       </select>
       <div class="description messages">Select which team to add a service for.</div>
    </div>
      <div class="form-item form-group" id="edit-title-wrapper">
         <label for="service_name">Service Name: <span class="form-required" title="This field is required.">*</span></label>
         <input maxlength="128" name="service_name" id="service_name" size="60" value="" class="form-text required" type="text" />
         <div class="description messages">Name that shows up in service box.</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
         <label for="service_ip">IP Address: <span class="form-required" title="This field is required.">*</span></label>
         <input maxlength="128" name="service_ip" id="service_ip" size="60" value="" class="form-text required" type="text" />
         <div class="description messages">Example: 192.168.0.5.</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
         <label for="service_port">Port Number: <span class="form-required" title="This field is required.">*</span></label>
         <input maxlength="128" name="service_port" id="service_port" size="60" value="" class="form-text required" type="text" />
         <div class="description messages">Example: 80 for http</div>
      </div>
      <div class="form-item form-group" id="edit-title-wrapper">
        <label for="service_active">Active Now?: <span class="form-required" title="This field is required.">*</span></label>
        <input name="service_active" id="service_active" class="form-text required" type="checkbox" />
        <div class="description messages">This service will be scored immediately if Checked.</div>
      </div>
      <div class="form-group">
        <input type="hidden" name="origin" id="origin" value="adminaddservice" />
        <input name="op" id="edit-submit" value="Save" class="form-submit" type="submit" />
      </div>
    </form>
    </div> <!-- Add Service -->

    <div id="PassChange">
      <h1>Password Change Requests</h1>
      <?php
      $arPasswordChange = GetAllPasswordChanges();
      echo 'Password Change Table';
      echo '<table>
      <tr>
      <td>Team Name</td>
      <td>Service</td>
      <td>Team Password</td>
      <td>Status</td>
      </tr>';

      if (!empty($arPasswordChange)) {
        for ($w = 0; $w < count($arPasswordChange); $w++) {
        $arrChange = $arPasswordChange[$w];
        echo '<tr><td>' . $arrChange['team_name'] . '</td>' .
              '<td>' . $arrChange['service'] . '</td>' .
              '<td>' . $arrChange['new_password'] . '</td>' .
              '<td style="text-align: center">' . $arrChange['status'] . '</td></tr>';
        }
      }
      echo '</table>';
      ?>
      <form action="scripts/upload_submission.php" onsubmit="return fastCheck()"  method="post" id="createpasswordchange-form"  enctype="multipart/form-data">
        <div class="form-item form-group" id="edit-inject-id-wrapper">
        <label for="passchange_id">Pass Change: <span class="form-required" title="This field is required.">*</span></label>

          <?php
          echo '<select class="form-select required" id="passchange_id" name="passchange_id">';
          echo '<option value=""></option>';
          if (!empty($arPasswordChange)) {
            for ($s = 0; $s < count($arPasswordChange); $s++) {
                $arrPassOption = $arPasswordChange[$s];
                if ($arrPassOption['status'] == 'F') {
                echo '<option value="' . $arrPassOption['passchange_id'] . '">' . $arrPassOption['team_name'] . ' - ' . $arrPassOption['service'] . ' - ' . $arrPassOption['new_password'] . '</option>';
                }
            }
          }
          echo '</select>';
         ?>
         <div class="description messages">Which service password did you change?</div>
        </div>
        <div class="form-group">
          <input type="hidden" name="origin" id="origin" value="adminpasschange" />
          <input name="op" id="edit-submit" value="Save" class="form-submit" type="submit" />
        </div>
      </form>
    </div> <!-- Password Change Requests -->


    <div id="GradeInjects"> <!-- Grade Injects -->
      <h1>Grade Injects</h1>
      <?php
        $arInjects = GetInjectsNotGraded();

        echo '<br /><h2>Injects That Need Graded Table</h2>';
        echo '<table>
        <tr>
        <td>Group</td>
        <td>Team Name</td>
        <td>Inject Id</td>
        <td>Inject Title</td>
        </tr>';

        if (!empty($arInjects)) {
          for ($w = 0; $w < count($arInjects); $w++) {
          $arrInject = $arInjects[$w];
          echo '<tr><td>' . $arrInject['group_name'] . '</td>' .
                '<td>' . $arrInject['team_name'] . '</td>' .
                '<td>' . $arrInject['inject_id'] . '</td>' .
                '<td>' . $arrInject['title'] . '</td></tr>';
          }
        }
        echo '</table><br /><br />';


       ?>

      <form action="scripts/upload_submission.php" onsubmit="return fastCheck()" method="post" id="gradeinjects-form"  enctype="multipart/form-data">
        <div class="form-item form-group" id="edit-inject-id-wrapper">
          <label for="group_id_4">Group: <span class="form-required" title="This field is required.">*</span></label>
          <select name="group_id_4" onchange="onChangeGradeGroup()" class="form-select required" id="group_id_4">
            <option value=""></option>
             <?php
             $arCategory = GetCategory();
             if (!empty($arCategory)) {
               for ($i = 0; $i < count($arCategory); $i++) {
               $arrCategory = $arCategory[$i];
               echo '<option value="' . $arrCategory['group_id'] . '">' . $arrCategory['group_name'] . '</option>';
               }
             }
            ?>
          </select>
          <div class="description messages">Select a Group to grade injects for.</div>
        </div>
        <div class="form-item form-group" id="edit-inject-id-wrapper">
          <label for="team_id_grade">Team: <span class="form-required" title="This field is required.">*</span></label>
          <select name="team_id_grade" onchange="onChangeGradeTeam()" class="form-select required" id="team_id_grade">
            <option value=""></option>
          </select>
          <div class="description messages">Select a Team to grade.</div>
        </div>
        <div class="form-item form-group" id="edit-inject-id-wrapper">
          <label for="inject_id_grade">Inject: <span class="form-required" title="This field is required.">*</span></label>
          <select name="inject_id_grade" onchange="onChangeGradeInject()" class="form-select required" id="inject_id_grade">
            <option value=""></option>
          </select>
          <div class="description messages">Select an Inject to grade. Injects that have a score of 0 will show up in this list.</div>
        </div>
        <div class="form-group" id="inject_table">
        </div>
        <div class="form-item form-group" id="edit-title-wrapper">
           <label for="inject_points">How many points: <span class="form-required" title="This field is required.">*</span></label>
           <input maxlength="128" name="inject_points" id="inject_points" size="60" value="" class="form-text required" type="text" />
           <div class="description messages">Give points to this inject.</div>
        </div>
        <div class="form-group">
          <input type="hidden" name="origin" id="origin" value="admingradeinjects" />
          <input name="op" id="edit-submit" value="Save" class="form-submit" type="submit" />
        </div>
      </form>
    </div> <!-- Grade Injects -->

    </div>

	  </div></div> <!-- /.section, /#content -->

	  <div id="navigation"><div class="section clearfix">
	  </div></div> <!-- /.section, /#navigation -->

	  <div class="region region-sidebar-first column sidebar"><div class="section">

<div id="block-user-1" class="block block-user first last region-odd odd region-count-1 count-1  block-1"><div class="block-inner">

	  <h2 class="title"><?php echo $_SESSION['nav_title'] ?></h2>

  <div class="content">
	<ul class="menu">
	<li class="leaf first"><a href="dashboard.php">Dashboard</a></li>
	<li class="leaf first active-trail"><a href="admin.php" class="active" style="color: black;">Admin</a></li>
<li class="leaf"><a href="submission.php" title="Add, edit, or delete submissions." class="active">Submissions</a></li>
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
  <script type="text/javascript">
  var hidOrigin = document.getElementById("origin");

  var jsonTeams = <?php echo json_encode(GetTeam()); ?>;
  var jsonSubmissions = <?php echo json_encode(GetAllSubmissions()); ?>;
  var view = "<?php if (isset($_GET["view"])) { echo $_GET["view"]; } else { echo "createinject"; } ?>";

  function onChangeNotificationGroup() {
  var selectTeam = document.getElementById("team_id_not");
  var selectGroupValue = document.getElementById("group_id_2").value;
  document.getElementById("team_id_not").innerHTML = "";
  var le = document.createElement("option");
  le.textContent = "";
  le.value = ""
  selectTeam.appendChild(le);
  var everyone = document.createElement("option");
  everyone.textContent = "Everyone in Group";
  everyone.value = "everyone";
  selectTeam.appendChild(everyone);
  for (var i = 0; i < jsonTeams.length; i++) {
    if (jsonTeams[i]["group_id"] == selectGroupValue) {
    var teamName = jsonTeams[i]["team_name"];
    var teamId = jsonTeams[i]["team_id"];
    var el = document.createElement("option");
    el.textContent = teamName;
    el.value = teamId;
    selectTeam.appendChild(el);
   }
  }
}


  function onChangeGradeGroup() {
  var selectTeam = document.getElementById("team_id_grade");
  var selectGroupValue = document.getElementById("group_id_4").value;

  var gradeInject = document.getElementById("inject_table");
  gradeInject.innerHTML = "";

  var selectInject = document.getElementById("inject_id_grade");
  selectInject.innerHTML = "";

  document.getElementById("team_id_grade").innerHTML = "";
  var le = document.createElement("option");
  le.textContent = "";
  le.value = ""
  selectTeam.appendChild(le);
  for (var i = 0; i < jsonTeams.length; i++) {
    if (jsonTeams[i]["group_id"] == selectGroupValue) {
    var teamName = jsonTeams[i]["team_name"];
    var teamId = jsonTeams[i]["team_id"];
    var el = document.createElement("option");
    el.textContent = teamName;
    el.value = teamId;
    selectTeam.appendChild(el);
   }
  }
}

function onChangeGradeTeam() {
  var gradeInject = document.getElementById("inject_table");
  gradeInject.innerHTML = "";

  var team_id = document.getElementById("team_id_grade").value;
  var selectInject = document.getElementById("inject_id_grade");
  selectInject.innerHTML = "";
  var le = document.createElement("option");
  le.textContent = "";
  le.value = ""
  selectInject.appendChild(le);
  for (var f = 0; f < jsonSubmissions.length; f++) {
    if (jsonSubmissions[f]["team_id"] == team_id && jsonSubmissions[f]["graded_by"] == null) {
      var injectName = jsonSubmissions[f]["injTitle"];
      var injectId = jsonSubmissions[f]["inject_id"];
      var entryId = jsonSubmissions[f]["entry_id"];
      var el = document.createElement("option");
      el.textContent = injectId + " - " + injectName;
      el.value = entryId;
      selectInject.appendChild(el);
    }
  }
}

function onChangeGradeInject() {
  var gradeInject = document.getElementById("inject_table");
  gradeInject.innerHTML = "";
  var d = document.getElementById("inject_id_grade").value;
  var team_id = document.getElementById("team_id_grade").value;
  var del = document.createElement("div");
  for (var f = 0; f < jsonSubmissions.length; f++) {
    if (jsonSubmissions[f]["entry_id"] == d) {
      var title = jsonSubmissions[f]["title"];
      var injectId = jsonSubmissions[f]["inject_id"];
      var location = jsonSubmissions[f]["location"];
      var userText = jsonSubmissions[f]["user_text"];
      var fileName = jsonSubmissions[f]["filename"];
      var entryId = jsonSubmissions[f]["entry_id"];
      var points = jsonSubmissions[f]["points"];
      var injLocation = jsonSubmissions[f]["injLocation"];
      var injTitle = jsonSubmissions[f]["injTitle"];
      textInjectLocation = "<tr><td>Inject File:</td> <td><a href='" + injLocation + "' target='_blank'>" + injTitle  + "</a></td></tr>";
      if (location != null) {
      textLocation = "<tr><td>Submission File:</td> <td><a href='" + location + "' target='_blank'>" + fileName + "</a></td></tr>";
    } else {
      textLocation = "<tr><td>Submission File:</td><td>No File</td></tr>";
    }
      gradeInject.innerHTML += "<table style='margin-bottom: 15px;'><tr><td>Entry Id:</td><td>" + entryId + "</td></tr>" +
                              "<tr><td>Submission Title:</td><td>" + title + "</td></tr>" +
                              "<tr><td>Comments:</td><td>" + userText + "</td></tr>" +
                              textLocation +
                              textInjectLocation +
                              "<tr><td>Total Points:</td><td> " + points + "</td></tr></table>";
      break;
    }
  }
}


  var tabNotification = document.getElementById("tabNotification");
  var tabCreateInject = document.getElementById("tabCreateInject");
  var tabTeam = document.getElementById("tabTeam");
  var tabCompetitionGroup = document.getElementById("tabCompetitionGroup");
  var tabShowDatabase = document.getElementById("tabShowDatabase");
  var tabAddService = document.getElementById("tabAddService");
  var tabPassChange = document.getElementById("tabPassChange");
  var tabGradeInjects = document.getElementById("tabGradeInjects");

  var secCreateInject = document.getElementById("CreateInject");
  var secCreateNotification = document.getElementById("CreateNotification");
  var secCreateCompetitionGroup = document.getElementById("CreateCompetitionGroup");
  var secCreateTeam = document.getElementById("CreateTeam");
  var secShowDatabase = document.getElementById("ShowDatabase");
  var secAddService = document.getElementById("AddService");
  var secPassChange = document.getElementById("PassChange");
  var secGradeInjects = document.getElementById("GradeInjects");

  function hideAllSections() {
    secCreateInject.style.display = "none";
	  secCreateNotification.style.display = "none";
	  secCreateCompetitionGroup.style.display = "none";
	  secCreateTeam.style.display = "none";
    secShowDatabase.style.display = "none";
    secAddService.style.display = "none";
    secCreateNotification.style.display = "none";
    secPassChange.style.display = "none";
    secGradeInjects.style.display = "none";
  }

  window.onload = function() {
    hideAllSections();
    hidOrigin.value = view;
    if (view == "createnotification") {
      secCreateNotification.style.display = "block";
      hidOrigin.value = "admincreatenotification";
    }
    else if (view == "createinject") {
      secCreateInject.style.display = "block";
      hidOrigin.value = "admincreateinject";
    }
    else if (view == "createcompetitiongroup") {
      secCreateCompetitionGroup.style.display = "block";
      hidOrigin.value = "admincreategroup";
    }
    else if (view == "createteam") {
      secCreateTeam.style.display = "block";
      hidOrigin.value = "admincreateteam";
    }
    else if (view == "showdatabase") {
      secShowDatabase.style.display = "block";
      hidOrigin.value = "none";
    }
    else if (view == "addservice") {
      secAddService.style.display = "block";
      hidOrigin.value = "adminaddservice";
    }
    else if (view == "passchange") {
      secPassChange.style.display = "block";
      hidOrigin.value = "adminpasschange";
    }
    else if (view == "gradeinject") {
      secGradeInjects.style.display = "block";
      hidOrigin.value = "admingradeinjects";
    } else {
      secCreateInject.style.display = "block";
      hidOrigin.value = "admincreateinject";
    }
  }

  tabNotification.onclick = function() {
    hideAllSections();
	  secCreateNotification.style.display = "block";
	  hidOrigin.value = "admincreatenotification";
  }
  tabCreateInject.onclick = function() {
    hideAllSections();
	  secCreateInject.style.display = "block";
	  hidOrigin.value = "admincreateinject";
  }
  tabTeam.onclick = function() {
    hideAllSections();
	  secCreateTeam.style.display = "block";
	  hidOrigin.value = "admincreateteam";
  }
  tabCompetitionGroup.onclick = function() {
  	hideAllSections();
    secCreateCompetitionGroup.style.display = "block";
  	hidOrigin.value = "admincreategroup";
  }
  tabShowDatabase.onclick = function() {
    hideAllSections();
    secShowDatabase.style.display = "block";
    hidOrigin.value = "none";
  }
  tabAddService.onclick = function() {
    hideAllSections();
    secAddService.style.display = "block";
    hidOrigin.value = "adminaddservice";
  }
  tabPassChange.onclick = function() {
    hideAllSections();
    secPassChange.style.display = "block";
    hidOrigin.value = "adminpasschange";
  }
  tabGradeInjects.onclick = function() {
    hideAllSections();
    secGradeInjects.style.display = "block";
    hidOrigin.value = "admingradeinjects";
  }

function validateCreateInjectForm(form, data) {
  var formConstraints = {
     group_id_1 : {
         presence: {
           allowEmpty: false,
           message: '^A Group must be selected.'
         }
       },
     is_multi : {
        presence: {
          allowEmpty: false,
          message: '^Multi Option must be picked'
        }
     },
     is_active : {
        presence: {
          allowEmpty: false,
          message: '^Active option must be picked.'
        }
     },
     inject_name : {
        presence: {
          allowEmpty: false,
          message: '^Inject must be Named.'
        }
     },
     inject_duration : {
        presence: {
          allowEmpty: false,
          message: '^Inject Duration must be set.'
        },
        numericality: {
           onlyInteger: true,
           greaterThanOrEqualTo: 1,
           lessThanOrEqualTo: 1000000,
           message: '^Minutes must be between 1 and 1,000,000'
        }
     },
     inject_points : {
        presence: {
          allowEmpty: false,
          message: '^A point value must be set.'
        },
        numericality: {
           onlyInteger: true,
           greaterThanOrEqualTo: 1,
           lessThanOrEqualTo: 100000,
           message: '^Point value must be between 0 and 100,000'
        }
     },
     inject_from : {
        presence: {
          allowEmpty: false,
          message: '^Inject must be From someone'
        }
     },
     inject_to : {
        presence: {
          allowEmpty: false,
          message: '^Inject must be To someone'
        }
     }
  };
  return handleValidate(form, data, formConstraints);
}

function validateCreateGroupForm(form, data) {
  var formConstraints = {
     group_type : {
         presence: {
           allowEmpty: false,
           message: '^A Group type must be selected.'
         }
       },
     group_name : {
        presence: {
          allowEmpty: false,
          message: '^Group must be named.'
        }
     },
     comp_start_date : {
        presence: {
          allowEmpty: false,
          message: '^Date must be picked.'
        }
     },
     comp_start_time : {
        presence: {
          allowEmpty: false,
          message: '^Start time must be set.'
        }
     },
     comp_end_date : {
        presence: {
          allowEmpty: false,
          message: '^Date must be picked.'
        }
     },
     comp_end_time : {
        presence: {
          allowEmpty: false,
          message: '^Time must be set.'
        }
     }
  };
  return handleValidate(form, data, formConstraints);
}

function validateAddServiceForm(form, data) {
  var formConstraints = {
     team_id_2 : {
         presence: {
           allowEmpty: false,
           message: '^A Group must be selected.'
         }
       },
     service_type : {
        presence: {
          allowEmpty: false,
          message: '^Type of Service must be selected.'
        }
     },
     service_name : {
        presence: {
          allowEmpty: false,
          message: '^Service must be named.'
        }
     },
     service_ip : {
        presence: {
          allowEmpty: false,
          message: '^IP Address must be set.'
        }
     },
     service_port : {
        presence: {
          allowEmpty: false,
          message: '^IP Port must be set.'
        },
        numericality: {
           onlyInteger: true,
           greaterThanOrEqualTo: 0,
           lessThanOrEqualTo: 65535,
           message: '^Port must be between 0 and 65535'
        }
     }
  };
  return handleValidate(form, data, formConstraints);
}

function validateGradeInjectsForm(form, data) {
  var formConstraints = {
     group_id_4 : {
         presence: {
           allowEmpty: false,
           message: '^A Group must be selected.'
         }
       },
     team_id_grade : {
        presence: {
          allowEmpty: false,
          message: '^A team must be selected.'
        }
     },
     inject_id_grade : {
        presence: {
          allowEmpty: false,
          message: '^Inject must be selected.'
        }
     },
     inject_points : {
        presence: {
          allowEmpty: false,
          message: '^Point value must be set.'
        },
        numericality: {
           onlyInteger: true,
           greaterThanOrEqualTo: 0,
           lessThanOrEqualTo: 500,
           message: '^Point value must be between 0 and max point value'
        }
     }
   };
  return handleValidate(form, data, formConstraints);
}

function validateCreateTeamForm(form, data) {
  var formConstraints = {
     group_id_3 : {
         presence: {
           allowEmpty: false,
           message: '^A Group must be selected.'
         }
       },
     team_name : {
        presence: {
          allowEmpty: false,
          message: '^Team name must be set.'
        }
     },
     team_password : {
        presence: {
          allowEmpty: false,
          message: '^Password must be set.'
        }
     }
  };
  return handleValidate(form, data, formConstraints);
}

function validatePasswordChangeForm(form, data) {
  var formConstraints = {
     passchange_id : {
         presence: {
           allowEmpty: false,
           message: '^A team-service-password combo must be selected.'
         }
       }
  };
  return handleValidate(form, data, formConstraints);
}

  function validateNotificationForm(form, data) {
    var formConstraints = {
       group_id_2 : {
           presence: {
             allowEmpty: false,
             message: '^A Group must be selected.'
           }
         },
         team_id_not : {
           presence: {
             allowEmpty: false,
             message: '^A Team must be selected.'
           }
       },
       not_message : {
          presence: {
            allowEmpty: false,
            message: '^Notification message must be filled out.'
          }
       }
    };
    return handleValidate(form, data, formConstraints);
  }

  function fastCheck() {
	  var hidOrigin = document.getElementById("origin");
    if (hidOrigin.value == "admincreategroup") {
      var modalForm = document.getElementById("creategroup-form");
      var modalFormData = $("#creategroup-form").serializeObject();
      if (validateCreateGroupForm(modalForm, modalFormData)) {
        return true;
      }
      return false;
    }
    if (hidOrigin.value == "adminaddservice") {
      var modalForm = document.getElementById("addservice-form");
      var modalFormData = $("#addservice-form").serializeObject();
      if (validateAddServiceForm(modalForm, modalFormData)) {
        return true;
      }
      return false;
    }

	  if (hidOrigin.value == "admincreatenotification") {
      var modalForm = document.getElementById("notification-form");
      var modalFormData = $("#notification-form").serializeObject();
      if (validateNotificationForm(modalForm, modalFormData)) {
        return true;
      }
		  return false;
	  }
	  if (hidOrigin.value == "admincreateteam") {
      var modalForm = document.getElementById("createteam-form");
      var modalFormData = $("#createteam-form").serializeObject();
      if (validateCreateTeamForm(modalForm, modalFormData)) {
        return true;
      }
		  return false;
	  }

	  if (hidOrigin.value == "admincreateinject") {
      var modalForm = document.getElementById("createinject-form");
      var modalFormData = $("#createinject-form").serializeObject();
      if (validateCreateInjectForm(modalForm, modalFormData)) {
        return true;
      }
      return false;
	  }
    if (hidOrigin.value == "adminpasschange") {
      var modalForm = document.getElementById("createpasswordchange-form");
      var modalFormData = $("#createpasswordchange-form").serializeObject();
      if (validatePasswordChangeForm(modalForm, modalFormData)) {
        return true;
      }
      return false;
    }
    if (hidOrigin.value == "admingradeinjects") {
      var modalForm = document.getElementById("gradeinjects-form");
      var modalFormData = $("#gradeinjects-form").serializeObject();
      if (validateGradeInjectsForm(modalForm, modalFormData)) {
        return true;
      }
      return false;
    }

    else {
		  return false;
	  }
  }
  </script>
</body>
</html>
