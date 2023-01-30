<?php require('../connection.php'); ?>

<!DOCTYPE html>
<html lang="en">

<?php
$template = new template();
$func = new functions();
$template->getHeader('Dashboard');

// current cases
$query = "SELECT COUNT(casedetails.case_id) AS current_cases FROM casedetails, clientdetails WHERE clientdetails.client_id = casedetails.client_fk AND casedetails.case_isDelete=0";
$result = mysqli_query($connection, $query);
$cases = mysqli_fetch_assoc($result);
$current_cases = $cases['current_cases'];
// finished cases
$query = "SELECT COUNT(casedetails.case_id) AS finished_cases FROM casedetails, clientdetails WHERE clientdetails.client_id = casedetails.client_fk AND casedetails.case_isDelete=1";
$result = mysqli_query($connection, $query);
$cases = mysqli_fetch_assoc($result);
$finished_cases = $cases['finished_cases'];
// tommorrow cases
$query = "SELECT COUNT(casedetails.case_id) AS tomorrow_cases FROM casedetails, clientdetails WHERE clientdetails.client_id = casedetails.client_fk AND casedetails.case_date=CURRENT_DATE()+1";
$result = mysqli_query($connection, $query);
$cases = mysqli_fetch_assoc($result);
$tomorrow_cases = $cases['tomorrow_cases'];
// yesterday cases
$query = "SELECT COUNT(casedetails.case_id) AS yesterday_cases FROM casedetails, clientdetails WHERE clientdetails.client_id = casedetails.client_fk AND casedetails.case_date=CURRENT_DATE()-1";
$result = mysqli_query($connection, $query);
$cases = mysqli_fetch_assoc($result);
$yesterday_cases = $cases['yesterday_cases'];
// total cases
$query = "SELECT COUNT(case_id) AS total_cases FROM casedetails";
$result = mysqli_query($connection, $query);
$cases = mysqli_fetch_assoc($result);
$total_cases = $cases['total_cases'];

// today cases
$query = "SELECT count(casedetails.case_id) AS today_cases FROM casedetails, clientdetails WHERE clientdetails.client_id = casedetails.client_fk  AND casedetails.case_date=CURRENT_DATE() ";
$result = mysqli_query($connection, $query);
$func->verify_query($result);
$case = mysqli_fetch_assoc($result);
$today_cases = $case['today_cases'];


$queryQ = "SELECT * FROM casedetails, clientdetails WHERE clientdetails.client_id = casedetails.client_fk  AND casedetails.case_date=CURRENT_DATE() ";
$resultQ = mysqli_query($connection, $queryQ);
$func->verify_query($resultQ);
$case_list = '';
while ($case = mysqli_fetch_assoc($resultQ)) {
    $case_list .= "<a href=\"caseUpdate.php?clientId=" . $case['client_id'] . "&caseId=" . $case['case_id'] . "&resultTemplate=single&caseType=" . $case['case_type'] . "&from=main\"><li>";
    $case_list .= "<div class=\"user-thumb\"> <img width=\"40\" height=\"40\" alt=\"Client\" src=\"../../img/case.jpg\"> </div>";
    $case_list .= "<div class=\"article-post\"> <span class=\"user-info\">";
    $case_list .= "{$case['client_name']}</span>";
    $case_list .= "<p>{$case['case_type']}</p>";
    $case_list .= "</div></li></a>";
}


?>
<link rel="stylesheet" href="../../css/matrix-style.css">
<link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.css">

<body onload="startTime()">
    <!-- begin of nav bar -->
    <?php $template->getNavBar('main');
    $template->getSideBar(); ?>

    <div id="content">
        <div class="container-fluid">
            <!-- from here -->
            <!--Action boxes -->
            <div class="container-fluid">
                <div class="quick-actions_homepage">
                    <ul class="quick-actions">
                        <li class="bg_lb span3"> <a href="clientProfile.php"> <i class="icon-user"></i><!-- <span class="label label-important">20</span>--> CLient Profiles </a> </li>
                        <li class="bg_lg span3"> <a href="userProfile.php"> <i class="icon-user"></i> User Profile</a> </li>
                        <li class="bg_ly span3"> <a href="cases.php"> <i class="icon-inbox"></i> Cases</a> </li>
                        <li class="bg_lo span5"> <a href="#"> <i class="icon-th"></i> Case Study</a> </li>
                        <li class="bg_lr span5"> <a href="calender.php"> <i class="icon-calendar"></i> Calendar</a> </li>


                    </ul>
                </div>
                <!--End-Action boxes-->
               
                <!--Chart-box-->
                <div class="row-fluid">
                    <div class="widget-box">
                        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                            <h5>Case Status</h5>
                            
                        </div>
                        <div class="widget-content">
                            <div class="row-fluid">
                                <div class="span6">
                                    <ul class="site-stats">
                                        <li class="bg_lh"><i class="icon-briefcase"></i> <strong><?php echo $current_cases; ?></strong> <small>Current Cases</small></li>
                                        <li class="bg_lh"><i class="icon-briefcase"></i> <strong><?php echo $finished_cases; ?></strong> <small>Finised Cases</small></li>
                                        <li class="bg_lh"><i class="icon-briefcase"></i> <strong><?php echo $total_cases; ?></strong> <small>Total No. Of Cases</small></li>
                                        <li class="bg_lh"><i class="icon-briefcase"></i> <strong><?php echo $today_cases; ?></strong> <small>Todays Cases</small></li>
                                        <li class="bg_lh"><i class="icon-briefcase"></i> <strong><?php echo $tomorrow_cases; ?></strong> <small>Tomorrow's cases</small></li>
                                        <li class="bg_lh"><i class="icon-briefcase"></i> <strong><?php echo $yesterday_cases; ?></strong> <small>Yesterday's Cases</small></li>
                                    </ul>
                                </div>
                                <div class="span6">
                                    <div class="widget-box">
                                        <div class="widget-title"><span class="icon"><i class="icon-user"></i></span>
                                            <h5>TODAYS CASES</h5>
                                        </div>

                                        <div class="widget-content nopadding fix_hgt">
                                            <ul class="recent-posts">
                                                
                                                <?php echo $case_list; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End-Chart-box-->


                <!-- closing of nav bar -->
                <!-- main part -->



                <?php
                $template->getFooter();
                mysqli_close($connection);
                ?>
</body>

</html>