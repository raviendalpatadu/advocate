<?php require('../connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php
$template = new template();
$func = new functions();
$template->getHeader('Cases');
?>

<link rel="stylesheet" href="../../css/matrix-style.css">


<body onload="startTime()">
  <!-- begin of nav bar -->
  <?php $template->getNavBar('main');
  $template->getSideBar(); ?>

  <div id="content">
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">

          <h1><?php echo 'Cases'; ?></h1>
          <?php
          if (!empty($_SESSION['errors'])) {
            $func->display_errors($_SESSION['errors'], 'errors');
          }
          if (isset($_GET['create'])) {
            echo '<div class="alert alert-success" id="alert-msg">Client/Case Registered. </div>';
          }
          if (isset($_GET['Deleted'])) {
            echo '<div class="alert alert-success" id="alert-msg">Case Removed. </div>';
          }
          ?>

          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Cases</h5>
              <div>

                <div id="reportrange" style="background: transparent; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 250px;float:right;">
                  <i class="fa fa-calendar"></i>&nbsp;
                  <span id="dat"> </span><i class="fa fa-caret-down" style="float: right;"></i>
                </div>

                <script type="text/javascript">
                  jQuery(function() {

                    var start = moment();
                    var end = moment();

                    function cb(start, end) {

                      jQuery('#dat').html(start.format('YYYY-MM-D') + ' / ' + end.format('YYYY-MM-D'));

                      jQuery('#dat').on('apply.daterangepicker', function(ev, picker) {
                        var fDate = picker.startDate.format('YYYY-MM-DD');
                        var eDate = picker.endDate.format('YYYY-MM-DD');
                        var $j = jQuery.noConflict();
                        jQuery.ajax({
                          type: "POST",
                          url: "_php/_dateFilter.php",
                          data: {
                            startdate: fDate,
                            enddate: eDate,
                          },
                          success: function(data, status) {
                            jQuery('tbody').html(data);
                            console.log(status);
                          }
                        });
                      });
                    }

                    jQuery('#dat').daterangepicker({
                      startDate: start,
                      endDate: end,
                      ranges: {
                        'Today': [moment(), moment()],
                        'Tommorow': [moment().add(1, 'days'), moment().add(1, 'days')],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                      }
                    }, cb);

                    cb(start, end);
                  });
                </script>
              </div>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Client Name</th>
                    <th>Client NIC</th>
                    <th>Case Number</th>
                    <th>Case Name</th>
                    <th>Case Date</th>
                    <th>Case Type</th>
                    <th>Modify</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT * FROM clientdetails,casedetails WHERE clientdetails.client_isDelete=0 AND casedetails.case_isDelete=0 AND clientdetails.client_id=casedetails.client_fk ORDER BY casedetails.case_date ASC ";
                  $users = mysqli_query($connection, $query);

                  $func->verify_query($users);
                  // echo mysqli_num_rows($users);
                  
                  // getting the list of users
                  while ($user = mysqli_fetch_assoc($users)) {?>
                    <tr>
                      <td><?php echo $user['client_name']; ?></td>
                      <td><?php echo $user['client_nic']; ?> </td>
                      <td><?php echo $user['case_number']; ?></td>
                      <td><?php echo $user['case_name']; ?></td>
                      <td><?php echo $user['case_date']; ?></td>
                      <td><?php echo $user['case_type']; ?></td>
                      <td><a href="caseUpdate.php?<?php echo "clientId={$user['client_id']}&caseId={$user['case_id']}&resultTemplate=single&caseType={$user['case_type']}&from=cases"; ?>" class="badge badge-warning"><i class="far fa-edit"></i> Modify</a>
                      <br><button style="border:1px soild black;" id ='del' class="badge badge-danger" onclick="dele(<?php echo $user['client_id'].','.$user['case_id']; ?>)"><i class="fas fa-user-times"></i> Delete</button></td>
                    </tr>
              <?php } ?>
                </tbody>
                  <script>
                    function dele(client,cas){
                      if(confirm("Are you sure you want to finish this case?")){
                        window.location.href="_php/_caseDelete.php?clientId="+client+"&caseId="+cas+"&from=cases";
                        return true
                      }
                    }
                  </script>
              </table>
            </div>
          </div>


        </div>
      </div>
    </div>

    <!-- closing of nav bar -->
    <!-- main part -->

    <?php $template->getFooter(); ?>
    <script src="../../js/daterangepicker.js"></script>

    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="../../js/matrix.tables.js"></script>
</body>

</html>
<?php
mysqli_close($connection);
?>