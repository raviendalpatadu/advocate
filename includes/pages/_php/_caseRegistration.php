<?php
require('../../connection.php');
$func = new functions();

if (isset($_POST['submit'])) {

    $caseNumber = mysqli_real_escape_string($connection, $_POST['caseNumber']);
    $sectionNumber = mysqli_real_escape_string($connection, $_POST['sectionNumber']);
    $court = mysqli_real_escape_string($connection, $_POST['court']);
    $decision = mysqli_real_escape_string($connection, $_POST['decision']);
    $caseName = mysqli_real_escape_string($connection, $_POST['caseName']);
    $caseType = mysqli_real_escape_string($connection, $_POST['caseType']);
    $c_id = mysqli_real_escape_string($connection, $_POST['id']);
    $clientName = mysqli_real_escape_string($connection, $_POST['name']);
    if (isset($_FILES)) {
        $file_name = $_FILES['file']['name'][0];
        $temp_name = $_FILES['file']['tmp_name'][0];
        // echo"<pre>";
        // print_r($_FILES);
        // echo"</pre>";
    }

    if (isset($_SESSION['clientID'])) {

        //checking required fields
        $required_field = array('caseNumber', 'sectionNumber', 'court', 'decision', 'caseName', 'caseType');
        $func->check_required_fields($required_field);

        //checking max characters
        $maxchar = array('caseNumber' => '200', 'sectionNumber' => 500, 'court' => 500, 'decision' => 500, 'caseName' => 500, 'caseType' => 500);
        $func->check_max_len($maxchar);

        if (empty($_SESSION['errors'])) {
            $query = "SELECT * FROM casedetails WHERE case_number='$caseNumber'";
            $result = mysqli_query($connection, $query);
            $func->verify_query($result);
            if (mysqli_num_rows($result) > 0) {

                $_SESSION['errors'][] = 'Case Already Exixsts';
                header('location:' . BASE_URL . 'includes/pages/caseRegistration.php');
            } else {
                $query = "INSERT INTO casedetails (client_fk, case_name, case_number, case_sectionNumber, case_court, case_decision, case_type) ";
                $query .= "VALUES ('{$c_id}','{$caseName}','{$caseNumber}','{$sectionNumber}','{$court}','{$decision}', '{$caseType}') LIMIT 1";
                $result = mysqli_query($connection, $query);
                $func->verify_query($result);

                $upload_to = LOCAL_PATH . "client_documents\clients\\" . $clientName . "\\";
                move_uploaded_file($temp_name, $upload_to . $file_name);
                if ($result == 1) {
                    $_SESSION['active'] = 'main';
                    unset($_SESSION['clientID']);
                    header('Location:' . BASE_URL . 'includes/pages/clientRegistration.php?create=ture');
                }
            }
        } else {
            $_SESSION['active'] = 'main';
            header('Location:' . BASE_URL . 'includes/pages/caseRegistration.php');
        }
    } else {
        $required_field = array('caseNumber', 'sectionNumber', 'court', 'decision', 'caseName', 'caseType');
        $func->check_required_fields($required_field);

        //checking max characters
        $maxchar = array('caseNumber' => '200', 'sectionNumber' => 500, 'court' => 500, 'decision' => 500, 'caseName' => 500, 'caseType' => 500);
        $func->check_max_len($maxchar);

        if (empty($_SESSION['errors'])) {
            $query = "SELECT * FROM casedetails WHERE case_number='$caseNumber' AND case_type='$caseType'";
            $result = mysqli_query($connection, $query);
            // $func->verify_query($result);
            if (mysqli_num_rows($result) > 0) {
                unset($_SESSION['clientID']);
                $_SESSION['errors'][] = 'Case Already Exixsts';
                header('location:' . BASE_URL . 'includes/pages/caseRegistration.php');
            } 
            else {
                $query = "INSERT INTO casedetails (client_fk, case_name, case_number, case_sectionNumber, case_court, case_decision, case_type) ";
                $query .= "VALUES ('{$c_id}','{$caseName}','{$caseNumber}','{$sectionNumber}','{$court}','{$decision}', '{$caseType}') LIMIT 1";
                $result = mysqli_query($connection, $query);
                // $func->verify_query($result);

                $upload_to = LOCAL_PATH . "client_documents\clients\\" . $clientName . "\\";
                move_uploaded_file($temp_name, $upload_to . $file_name);

                if ($result == 1) {
                    $_SESSION['active'] = 'main';
                    unset($_SESSION['clientID']);
                    //    echo "mkmvkv";
                    header('Location:' . BASE_URL . 'includes/pages/caseRegistration.php?create=ture');
                }elseif ($result == false) {
                    if (mysqli_errno($connection) == 1062) {
                        $_SESSION['errors'][] = "Case Alredy Exsits";
                        header('Location:' . BASE_URL . 'includes/pages/caseRegistration.php');
                    }
                }
            }
        } else {
            // error occured
            $_SESSION['active'] = 'main';
            header('Location:' . BASE_URL . 'includes/pages/caseRegistration.php');
        }
    }
}

mysqli_close($connection);
