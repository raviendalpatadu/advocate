<?php
require_once('../../connection.php');
$func = new functions();

$user_list = '';
if (isset($_POST['startdate']) && $_POST['enddate']) {
    // filter set
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];

    $query = "SELECT * FROM `casedetails`,`clientdetails` WHERE clientdetails.client_id=casedetails.client_fk AND clientdetails.client_isDelete=0 AND casedetails.case_date>='$startdate' AND casedetails.case_date<='$enddate' ORDER BY `case_date`  ASC";
    $result = mysqli_query($connection, $query);

    $func->verify_query($result);
    // echo mysqli_num_rows($result);
   
    while ($user = mysqli_fetch_assoc($result)) {
        $user_list .= "<tr>";
        $user_list .= "<td>{$user['client_name']}</td>";
        $user_list .= "<td>{$user['client_nic']}</td>";
        $user_list .= "<td>{$user['case_number']}</td>";
        $user_list .= "<td>{$user['case_name']}</td>";
        $user_list .= "<td>{$user['case_date']}</td>";
        $user_list .= "<td>{$user['case_type']}</td>";
        $user_list .= "<td><a href=\"" . BASE_URL . "includes/pages/caseUpdate.php?clientId={$user['client_id']}&caseId={$user['case_id']}&resultTemplate=single&caseType={$user['case_type']}&from=cases\" class=\"badge badge-warning\"><i class=\"far fa-edit\"></i> Modify</a></td>";
        $user_list .= "</tr>";
    }
    echo $user_list;
} else {
    echo 'filter not set';
}
