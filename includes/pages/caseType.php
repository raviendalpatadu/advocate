<?php require('../connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php
$template = new template();
$func = new functions();
$template->getHeader('Cases');

$caseType = strtoupper($_GET['caseType']);
$casetype = $_GET['caseType'];


$user_list = '';

// getting the list of users
$query = "SELECT * FROM clientdetails,casedetails WHERE clientdetails.client_isDelete=0 AND  casedetails.case_isDelete=0 AND clientdetails.client_id=casedetails.client_fk AND casedetails.case_type='$caseType'";
$users = mysqli_query($connection, $query);

$func->verify_query($users);
// echo mysqli_num_rows($users);

while ($user = mysqli_fetch_assoc($users)) {
    $user_list .= "<tr>";
    $user_list .= "<td>{$user['client_name']}</td>";
    $user_list .= "<td>{$user['client_nic']}</td>";
    $user_list .= "<td>{$user['case_number']}</td>";
    $user_list .= "<td>{$user['case_name']}</td>";
    $user_list .= "<td>{$user['case_date']}</td>";
    $user_list .= "<td><a href=\"".BASE_URL."includes/pages/caseUpdate.php?clientId={$user['client_id']}&caseId={$user['case_id']}&caseType={$caseType}&resultTemplate=single&from=caseType\" class=\"badge badge-warning\"><i class=\"far fa-edit\"></i> Update</a></td>";
    $user_list .= "</tr>";
}
?>


<link rel="stylesheet" href="../../css/matrix-style.css">
<script type="text/javascript" src="../../js/datepicker.js"></script>


<body onload="startTime()">
  <!-- begin of nav bar -->
  <?php $template->getNavBar('main');
  $template->getSideBar(); ?>

  <div id="content">
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">

          <h1><?php echo $caseType; ?></h1>
          <?php
          if (!empty($_SESSION['errors'])) {
            $func->display_errors($_SESSION['errors'], 'errors');
          }
          if (isset($_GET['create'])) {
            echo '<div class="alert alert-success" id="alert-msg">Client/Case Registered. </div>';
          }
          ?>

          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Cases</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Client Name</th>
                    <th>Client NIC</th>
                    <?php
                    if ($casetype == 'deed') {
                      echo '<th>Deed Number</th>';
                    } else {
                      echo '<th>Case Number</th>';
                    }
                    ?>
                    <th>Case Name</th>
                    <th>Case Date</th>
                    <th>Modify</th>
                  </tr>
                </thead>
                <tbody>
                  <?php echo $user_list; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- closing of nav bar -->
    <!-- main part -->

    <?php $template->getFooter(); ?>
    <script type="text/javascript" src="../../js/daterangepicker.js"></script>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="../../js/matrix.tables.js"></script>
</body>

</html>
<?php
mysqli_close($connection);
?>