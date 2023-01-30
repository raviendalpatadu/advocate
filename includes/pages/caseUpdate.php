<?php
require('../connection.php');
$template = new template();
$func = new functions();
?>
<?php
if (isset($_GET['clientId']) && isset($_GET['caseId'])) {
    $clientID = mysqli_real_escape_string($connection, $_GET['clientId']);
    $caseID = mysqli_real_escape_string($connection, $_GET['caseId']);
    // echo $clientID;
    $query = "SELECT * FROM clientdetails,casedetails WHERE clientdetails.client_isDelete=0 AND casedetails.case_id='$caseID' AND clientdetails.client_id='$clientID'";
    $result = mysqli_query($connection, $query);
    $func->verify_query($result);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $clientName = $data['client_name'];
        $clientAddress = $data['client_address'];
        $clientEmail = $data['client_email'];
        $clientNic = $data['client_nic'];
        $clientPhone = $data['client_tel'];
        $caseName = $data['case_name'];
        $caseNumber = $data['case_number'];
        $caseSectionNumber = $data['case_sectionNumber'];
        $caseCourt = $data['case_court'];
        $caseDecision = $data['case_decision'];
        $caseType = $data['case_type'];
        $caseDate = $data['case_date'];
        $client_id = $data['client_id'];
        $case_id = $data['case_id'];
    } else {
        $_SESSION['errors'][] = "sql query failed";
    }
    $total_fields_query = "SELECT COUNT(*) AS total_fields FROM information_schema.columns WHERE table_name = 'datedetails'";
    $total_fields_result = mysqli_query($connection, $total_fields_query);
    $func->verify_query($total_fields_result);
    $v = mysqli_fetch_assoc($total_fields_result);
    $fields_needed = $v['total_fields'] - 3;
    // echo $fields_needed;


    $query_select = "SELECT * FROM datedetails WHERE client_id={$client_id} AND case_id={$case_id}";
    $result_select = mysqli_query($connection, $query_select);
    $func->verify_query($result_select);
    $c = 1;
    $date = mysqli_fetch_assoc($result_select);
    $date_list = '';
    if (mysqli_num_rows($result_select) == 1) {
        while ($c != $fields_needed + 1) {
            $date_filed = $date["date_{$c}"];
            if ($date_filed == '0000-00-00') {
                break;
            } else {
                // echo $date_filed.'<br>';
                $date_list .= "<li>";
                $date_list .= "<div class=\"user-thumb\"> <img width=\"40\" height=\"40\" alt=\"Client\" src=\"../../img/c.jpg\"> </div>";
                $date_list .= "<div class=\"article-post\"> <span class=\"user-info\">";
                $date_list .= "Date {$c}</span>";
                $date_list .= "<p>" . $date_filed . "</p>";
                $date_list .= "</div></li>";
                $c++;
            }
        }
    } elseif (mysqli_num_rows($result_select) == 0) {
        $date_list = "No Previous dates Entered";
    }

    $files = scandir(LOCAL_PATH."client_documents\clients\\" . $clientName);
    $data_files = '';
    for ($a = 2; $a < count($files); $a++) {
        $data_files .= "<a href=\"".LOCAL_PATH."client_documents\clients\\".$clientName."\\".$files[$a]."\"><li>";
        $data_files .= "<div class=\"user-thumb\"> <img width=\"40\" height=\"40\" alt=\"Client\" src=\"../../img/file.jpg\"> </div>";
        $data_files .= "<div class=\"article-post\"> <span class=\"user-info\">";
        $data_files .= "</span>";
        $data_files .= "<p>" . $files[$a] . "</p>";
        $data_files .= "</div></li></a>";
        
        
    }
} else {
    $_SESSION['errors'][] = "ClientId not set";
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('Case Update'); ?>
<link rel="stylesheet" href="../../css/matrix-style.css">
<link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.css">

<body onload="startTime()">
    <?php $template->getNavBar('main');
    $template->getSideBar();
    ?>
    <section class="get-in-touch">
        <h1 class="title">Case Update </h1>
        <form action="_php/_caseUpdate.php" method="post" enctype="multipart/form-data">
            <div class="container-fluid">
                <?php
                if (!empty($_SESSION['errors'])) {
                    $func->display_errors($_SESSION['errors'], 'errors');
                }
                if (isset($_GET['create'])) {
                    echo '<div class="alert alert-success" id="alert-msg">Client/Case Updated. </div>';
                }
                ?>
                <div class="contact-form row">
                    <h5 id="btn_casedetails">&nbsp Case Details &nbsp </h1>
                        <h5 id="btn_clientdetails">&nbsp Client Details &nbsp </h1>
                            <h5 id="btn_previousdates">&nbsp Previous Dates &nbsp </h1>
                                <h5 id="btn_files">&nbsp Files &nbsp </h1>
                </div>
                <!-- client details section -->
                <div class="contact-form row" id="clientdetails">
                    <div class="form-field col-lg-6">
                        <input id="client_name" class="input-text" type="text" name="clientName" value="<?php echo $clientName; ?>">
                        <label for="client_name" class="label"> Client Name</label>
                        <i class="far fa-user"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="clientNic" class="input-text" type="text" name="clientNic" value="<?php echo $clientNic; ?>">
                        <label for="clientNic" class="label"> Client NIC</label>
                        <i class="far fa-address-card"></i>
                        <input type="hidden" name="clientId" value="<?php echo $clientID; ?>">
                        <input type="hidden" name="from" value="<?php echo $_GET['from']; ?>">
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="clientAddress" class="input-text" type="text" name="clientAddress" value="<?php echo $clientAddress; ?>">
                        <label for="clientAddress" class="label"> Client Address</label>
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="clientEmail" class="input-text" type="text" name="clientEmail" value="<?php echo $clientEmail; ?>">
                        <label for="clientEmail" class="label"> Client Email</label>
                        <i class="far fa-envelope"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="clientEmail" class="input-text" type="text" name="clientPhone" value="<?php echo $clientPhone; ?>">
                        <label for="clientEmail" class="label"> Client Phone</label>
                        <i class="fas fa-phone-alt"></i>
                    </div>
                </div>
                <!-- case details section -->
                <div class="contact-form row" id="casedetails">

                    <div class="form-field col-lg-6">
                        <input id="case_num" class="input-text" type="text" name="caseNumber" value="<?php echo $caseNumber; ?>">
                        <label for="case_num" class="label"> Case Number</label>
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="case_num" class="input-text" type="text" name="caseName" value="<?php echo $caseName; ?>">
                        <label for="case_num" class="label"> Case Name</label>
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="Section_num" class="input-text" type="text" name="caseSectionNumber" value="<?php echo $caseSectionNumber; ?>">
                        <label for="Section_num" class="label">Section Number</label>
                        <i class="fas fa-list-ol"></i>
                    </div>

                    <div class="form-field col-lg-6">
                        <input id="case_court" class="input-text" type="text" name="caseCourt" value="<?php echo $caseCourt; ?>">
                        <label for="case_court" class="label"> Case Court</label>
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="case_decision" class="input-text" type="text" name="caseDecision" value="<?php echo $caseDecision; ?>">
                        <label for="case_decision" class="label"> Case Decision</label>
                        <i class="fas fa-poll"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="case_date" class="input-text" type="date" name="caseDate" value="<?php echo $caseDate; ?>">
                        <label for="case_date" class="label"> Case Date</label>
                        <input type="hidden" id="saved_date" name="saved_date" value="">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <label for="Case_type" class="label" style="bottom:35px;"> Case Type</label>
                        <i class="fas fa-font" style="color: #297186;top: 9px;left: 25px;"></i>
                        <select name="caseType" id="Case_type" class="btn btn-info dropdown-toggle" style="padding-left: 30px;height: 34px;padding-top: 4px;">
                            <option value="<?php echo $caseType; ?>"><?php echo $caseType; ?></option>
                            <option value="DEED">DEED</option>
                            <option value="SUBMISSION">SUBMISSION</option>
                            <option value="CHARGE SHEET">CHARGE SHEET</option>
                            <option value="ESTATE CASE">ESTATE CASE</option>
                            <option value="URBAN CONCIL-PRADESHEEYA SABHA">URBAN CONCIL/PRADESHEEYA SABHA</option>
                            <option value="BAIL">BAIL CASES</option>
                            <option value="HIGH COURT">HIGH COURT</option>
                            <option value="ARBITRATION(ENTHARAWASI)">ARBITRATION(ENTHARAWASI)</option>
                            <option value="AGREEMENTS">AGREEMENTS</option>
                            <option value="FAMILY MATTERS">FAMILY MATTERS</option>
                            <option value="S-LIST">S-LIST</option>
                        </select>
                        <input type="hidden" name="casetype" value="<?php echo $_GET['caseType'] ?>">
                    </div>

                    <div class="form-field col-lg-6">
                        <input id="Case_file" class="btn btn-primary" type="File" name="file[]" multiple>
                        <label for="Case_file" class="label" style="bottom:35px;">UPLOAD FILES</label>
                    </div>

                </div>
                <!-- previous dates section -->
                <div class="contact-form row" id="previousdates">
                    <div class="widget-box span12">
                        <div class="widget-title">
                            <h5><?php echo $clientName . "'s Previous Dates" ?></h5>
                        </div>
                        <div class="widget-content nopadding fix_hgt">
                            <ul class="recent-posts">
                                <?php echo $date_list; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- file section -->
                <div class="contact-form row" id="files">
                    <div class="widget-box span12">
                        <div class="widget-title">
                            <h5><?php echo "Files" ?></h5>
                        </div>
                        <div class="widget-content nopadding fix_hgt">
                            <ul class="recent-posts">
                                <?php echo $data_files; ?>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="contact-form row">
                    <div class="form-field col-lg-6">
                        <input type="submit" name="submit" value="Update" class="Submit-btn">
                    </div>

                    <div class="form-field col-lg-6">
                        <input type="submit" name="back" value="Back" class="Submit-btn">
                    </div>
                    <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                    <input type="hidden" name="case_id" value="<?php echo $case_id; ?>">
                </div>
            </div>
        </form>
    </section>
    <script>
        $(document).ready(function() {
            $('h5').css({
                'cursor': 'pointer'
            });
            var clienthead = $('#clientdetails').hide();
            var previousdates = $('#previousdates').hide();
            var files = $('#files').hide();
            var casehead = $('#casedetails').show();
            $('#btn_clientdetails,#btn_previousdates,#btn_files').css({
                'border-bottom': '1px solid #17a2b8',
                'border-left': '1px solid #17a2b8',
                'border-right': '1px solid #17a2b8'
            });
            $('#btn_casedetails').css({
                'border-left': '1px solid #17a2b8'
            });
            $('#btn_clientdetails').click(function() {
                $('#btn_casedetails').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-right': '1px solid #17a2b8'
                });
                $('#btn_previousdates').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-right': '1px solid #17a2b8'
                });
                $('#btn_files').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-right': '1px solid #17a2b8'
                });
                $('#btn_clientdetails').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': 'none',
                    'border-left': '1px solid #17a2b8'
                });
                $('#clientdetails').show();
                $('#casedetails').hide();
                $('#previousdates').hide();
                $('#files').hide();
            });
            $('#btn_casedetails').click(function() {
                $('#btn_casedetails').css({
                    'border-left': '2px solid #17a2b8',
                    'border-bottom': 'none',
                    'border-right': '1px solid #17a2b8'
                });
                $('#btn_clientdetails').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-left': '1px solid #17a2b8'
                });
                $('#btn_files').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-left': '1px solid #17a2b8'
                });
                $('#btn_previousdates').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-left': '1px solid #17a2b8'
                });
                $('#casedetails').show();
                $('#clientdetails').hide();
                $('#previousdates').hide();
                $('#files').hide();
            });
            $('#btn_previousdates').click(function() {
                $('#btn_casedetails').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-right': '1px solid #17a2b8'
                });
                $('#btn_clientdetails').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-left': '1px solid #17a2b8'
                });
                $('#btn_files').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-left': '1px solid #17a2b8'
                });
                $('#btn_previousdates').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': 'none',
                    'border-left': '1px solid #17a2b8'
                });
                $('#previousdates').show();
                $('#clientdetails').hide();
                $('#casedetails').hide();
                $('#files').hide();
            });
            $('#btn_files').click(function() {
                $('#btn_casedetails').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-right': '1px solid #17a2b8'
                });
                $('#btn_clientdetails').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-left': '1px solid #17a2b8'
                });
                $('#btn_previousdates').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': '1px solid #17a2b8',
                    'border-left': '1px solid #17a2b8'
                });
                $('#btn_files').css({
                    'border-left': '1px solid #17a2b8',
                    'border-bottom': 'none',
                    'border-left': '1px solid #17a2b8'
                });
                $('#files').show();
                $('#clientdetails').hide();
                $('#previousdates').hide();
                $('#casedetails').hide();
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            
            var SavedDate = $("#case_date").val();
            $("#case_date").change(function() {
                $("#saved_date").val(SavedDate);
            });
        });
    </script>


</body>

</html>
<?php
$template->getFooter();
mysqli_close($connection);
?>