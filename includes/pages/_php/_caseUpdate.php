<?php
require_once('../../connection.php');
$func = new functions();
if (isset($_POST['submit'])) {

    $clientName = mysqli_real_escape_string($connection, $_POST['clientName']);
    $clientNic = mysqli_real_escape_string($connection, $_POST['clientNic']);
    $clientAddress = mysqli_real_escape_string($connection, $_POST['clientAddress']);
    $clientPhone = mysqli_real_escape_string($connection, $_POST['clientPhone']);
    $clientEmail = mysqli_real_escape_string($connection, $_POST['clientEmail']);
    $caseNumber = mysqli_real_escape_string($connection, $_POST['caseNumber']);
    $caseName = mysqli_real_escape_string($connection, $_POST['caseName']);
    $caseSectionNumber = mysqli_real_escape_string($connection, $_POST['caseSectionNumber']);
    $caseCourt = mysqli_real_escape_string($connection, $_POST['caseCourt']);
    $caseDecision = mysqli_real_escape_string($connection, $_POST['caseDecision']);
    $caseDate = mysqli_real_escape_string($connection, $_POST['caseDate']);
    $caseType = mysqli_real_escape_string($connection, $_POST['caseType']);
    $clientId = mysqli_real_escape_string($connection, $_POST['clientId']);
    $casetype = mysqli_real_escape_string($connection, $_POST['casetype']);
    $savedDate = mysqli_real_escape_string($connection, $_POST['saved_date']);
    $client_id = mysqli_real_escape_string($connection, $_POST['client_id']);
    $case_id = mysqli_real_escape_string($connection, $_POST['case_id']);
    if (isset($_FILES)) {
        $file_name = $_FILES['file']['name'][0];
        $temp_name = $_FILES['file']['tmp_name'][0];
    }   


    // echo 'client name:' . $clientName . '<br>';
    // echo 'client nic:' . $clientNic . '<br>';
    // echo 'client address' . $clientAddress . '<br>';
    // echo 'client phone' . $clientPhone . '<br>';
    // echo 'client email' . $clientEmail . '<br>';
    // echo 'client id' . $clientId . '<br>';
    // echo 'case id' . $case_id . '<br>';
    // echo 'case no' . $caseNumber . '<br>';
    // echo 'case name' . $caseName . '<br>';
    // echo 'section no' . $caseSectionNumber . '<br>';
    // echo 'court ' . $caseCourt . '<br>';
    // echo 'decision' . $caseDecision . '<br>';
    // echo 'date now' . $caseDate . '<br>';
    // echo 'type' . $caseType . '<br>';
    // echo 'previous date ' . $savedDate . '<br>';
    // echo "<pre>";
    // print_r($_FILES);
    // echo "</pre>";




    //checking required fields
    $required_field = array('clientName', 'clientNic', 'clientAddress', 'clientPhone', 'caseNumber', 'caseName', 'caseSectionNumber', 'caseCourt', 'caseType');
    $func->check_required_fields($required_field);

    // check whether the email is valid
    if (!isset($clientEmail) || !empty($clientEmail)) {

        // echo $clientEmail;
        if (!filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errors'][] = 'Email address is invalid.';
        }
    } else {
        echo 'email not set<br>';
        $clientEmail = '';
    }

    //checking max characters
    $maxchar = array('clientName' => 500, 'clientNic' => 13, 'clientPhone' => 10, 'clientAddress' => 500);
    $func->check_max_len($maxchar);

    if (empty($_SESSION['errors'])) {

        $query = "UPDATE clientdetails,casedetails SET clientdetails.client_name='{$clientName}', clientdetails.client_nic='{$clientNic}', clientdetails.client_email='{$clientEmail}',";
        $query .= " clientdetails.client_address='{$clientAddress}', clientdetails.client_tel={$clientPhone}, ";
        $query .= "casedetails.case_number='{$caseNumber}', casedetails.case_name='{$caseName}', casedetails.case_sectionNumber='{$caseSectionNumber}', ";
        $query .= "casedetails.case_court='{$caseCourt}', casedetails.case_decision='{$caseDecision}', casedetails.case_type='{$caseType}', casedetails.case_date='{$caseDate}', casedetails.case_dateupdateted= NOW()  WHERE  casedetails.case_id={$case_id} AND clientdetails.client_id={$clientId}  LIMIT 1";
        $result = mysqli_query($connection, $query);
        $func->verify_query($result);

        $select_date = "SELECT client_id,case_id FROM datedetails WHERE case_id={$case_id} AND client_id={$client_id}";
        $result_select = mysqli_query($connection, $select_date);
        $func->verify_query($result_select);

        // previous date upate process
        if (mysqli_num_rows($result_select) == 1) {
            // user found updating dates
            echo " 01 result found<br>";
            // getting totlal fields in table datedetails
            $total_fields_query = "SELECT COUNT(*) AS total_fields FROM information_schema.columns WHERE table_name = 'datedetails'";
            $total_fields_result = mysqli_query($connection, $total_fields_query);
            $func->verify_query($total_fields_result);
            $f = mysqli_fetch_assoc($total_fields_result);
            $total_fields = $f['total_fields'];
            $date_fields = $total_fields - 2;
            // last field name will be : date_$date_field_number
            $last_date_field_name = $total_fields - 3;
            // echo "total fileds " .  $total_fields . '<br>';
            // echo "date fileds " .  $date_fields . '<br>';
            // echo "date filed name " .  $last_date_field_name . '<br>';

            // checking whether the last field is null or not
            $query_select = "SELECT date_{$last_date_field_name} FROM datedetails WHERE case_id={$case_id} AND client_id={$client_id}";
            $result_select = mysqli_query($connection, $query_select);
            $func->verify_query($result_select);
            $v = mysqli_fetch_assoc($result_select);
            $last_value = $v["date_{$last_date_field_name}"];
            // echo "last value: " . $last_value . '<br>';
            


            // if last field is null in datedetails
            if ($last_value == '0000-00-00') {
                // echo 'null<br>';
                $query_select = "SELECT * FROM datedetails WHERE case_id={$case_id} AND client_id={$client_id}";
                $result_select = mysqli_query($connection,$query_select);
                $func->verify_query($result_select);
                $v = mysqli_fetch_assoc($result_select);
                $i = 1;
                // finding a free field
                while($v["date_{$i}"] != '0000-00-00'){ 
                    $i++;
                }
                $free_field = $i;
                // echo'free field: '. $free_field;
                $update_query = "UPDATE datedetails SET date_$free_field='{$savedDate}', date_now='{$caseDate}' WHERE case_id={$case_id} AND client_id={$client_id} LIMIT 1";
                $update_result = mysqli_query($connection, $update_query);
                $func->verify_query($update_result);
            }
            // if last filed is not null in datedetails
            else {
                // echo 'not null<br>';
                $query_select = "SELECT date_now, date_{$last_date_field_name} FROM datedetails WHERE case_id={$case_id} AND client_id={$client_id}";
                $result_select = mysqli_query($connection, $query_select);
                $func->verify_query($result_select);
                $v = mysqli_fetch_assoc($result_select);
                $date_now = $v['date_now'];
                $date_previous = $v["date_{$last_date_field_name}"];
                // echo "date now: " . $date_now . "<br>date pre: " . $date_previous;

                $new_date_field = $last_date_field_name + 1;
                // adding  a col
                $alter_query = "ALTER TABLE datedetails ADD date_{$new_date_field} DATE NOT NULL";
                $alter_result = mysqli_query($connection, $alter_query);
                $func->verify_query($alter_result);

                $update_query = "UPDATE datedetails SET date_{$new_date_field}='{$savedDate}', date_now='{$caseDate}' WHERE case_id={$case_id} AND client_id={$client_id} LIMIT 1";
                $update_result = mysqli_query($connection, $update_query);
                $func->verify_query($update_result);
            }
        } else {
            // user not found inserting user_id and case_id
            echo "result not found<br>";
            $query = "INSERT INTO datedetails (client_id,case_id) VALUES($client_id,$case_id) LIMIT 1";
            $result = mysqli_query($connection, $query);
            $func->verify_query($result);

            $query = "UPDATE datedetails SET date_now='{$caseDate}', date_1='{$savedDate}' WHERE case_id={$case_id} AND client_id={$client_id} LIMIT 1";
            $result = mysqli_query($connection, $query);
            $func->verify_query($result);
        }

        $upload_to = LOCAL_PATH."client_documents\clients\\".$clientName."\\";
        move_uploaded_file($temp_name, $upload_to . $file_name);

        if ($result == 1) {       
            header("Location:" . BASE_URL . "includes/pages/".$_POST['from'].".php?create=true&caseType={$casetype}");
        }
    } else {
        $_SESSION['errors'][] = 'Update Failed';
        header("Location:" . BASE_URL . "includes/pages/" . $_POST['from'] . ".php?clientId={$clientId}&resultTemplate=single&caseType={$casetype}");
    }
}

if (isset($_POST['back'])) {
    $casetype = mysqli_real_escape_string($connection, $_POST['casetype']);
    header("Location:" . BASE_URL . "includes/pages/" . $_POST['from'] . ".php?caseType={$casetype}");
}
$connection->close();
?>