<?php
require_once('../../connection.php');
$func = new functions();
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = sha1(mysqli_real_escape_string($connection, $_POST['password']));

    //checking required fields
    $required_field = array('username', 'password');
    $func->check_required_fields($required_field);

    if (empty($_SESSION['errors'])) {
        $query = "SELECT * FROM userdetails WHERE user_email = '{$username}' AND user_password = '{$password}' LIMIT 1";
        $res = mysqli_query($connection, $query);
        $func->verify_query($res);


        if (mysqli_num_rows($res) == 1) {

            $query = "SELECT count(casedetails.case_id) AS today_cases FROM casedetails, clientdetails WHERE clientdetails.client_id = casedetails.client_fk  AND casedetails.case_date=CURRENT_DATE() ";
            $result = mysqli_query($connection, $query);
            $func->verify_query($result);
            $case = mysqli_fetch_assoc($result);
            $_SESSION['today_total_cases'] = $case['today_cases'];
             

            $data = mysqli_fetch_assoc($res);
            $_SESSION['dbId'] =  $data['user_id'];
            $_SESSION['dbName'] =  $data['user_name'];
            $_SESSION['usertype'] = $data['user_type'];

            $query = "UPDATE userdetails SET last_login = NOW() WHERE user_id = {$_SESSION['dbId']} LIMIT 1";

            $result_set = mysqli_query($connection, $query);

            $func->verify_query($result_set);

            if ($result_set) {
                $_SESSION['active'] = 'main';
                header('Location:' . BASE_URL . 'includes/pages/main.php');
            }
        } else {
            $_SESSION['errors'][] = "No user Found";
            header('Location:' . BASE_URL . 'index.php');
        }
    } else {
        header("Location:" . BASE_URL . "index.php");
    }
}
