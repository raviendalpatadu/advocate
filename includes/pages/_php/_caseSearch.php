<?php
require('../../connection.php');
$func = new functions();
if (isset($_POST['submit'])) {
    if (empty($_POST['caseNumber']) && empty($_POST['sectionNumber']) && empty($_POST['caseDate']) && empty($_POST['client_nic']) ) {
        $_SESSION['errors'][] = 'Please Enter Data';
        header('Location:' . BASE_URL . 'includes/pages/caseSearch.php');
    } elseif (isset($_GET['client_id'])) {
        # code...
    }
    
    
    else {
        
        $caseNumber = mysqli_real_escape_string($connection,$_POST['caseNumber']);
        $client_nic = mysqli_real_escape_string($connection,$_POST['client_nic']);
        $query = "SELECT  * FROM casedetails,clientdetails WHERE clientdetails.client_id=casedetails.client_fk AND (casedetails.case_number='$caseNumber' OR clientdetails.client_nic='$client_nic')";
        if (!empty($caseNumber)) {
            $caseNumber = null;
        }
        if (!empty($client_nic)) {
            $client_nic = null;
        }
        $result = mysqli_query($connection, $query);
        //verifying query
        $func->verify_query($result);
        //getting data from sql table
        
        if (mysqli_num_rows($result) != 0) {
            if (mysqli_num_rows($result) == 1) {
                $data = mysqli_fetch_assoc($result);
                $_SESSION['search_res'] ['number'] = $data['case_number'];
                $_SESSION['search_res'] ['court'] = $data['case_court'];
                $_SESSION['search_res'] ['name'] = $data['case_name'];
                $_SESSION['search_res'] ['sectionNumber'] = $data['case_sectionNumber'];
                $_SESSION['search_res'] ['decision'] = $data['case_decision'];
                $_SESSION['search_res'] ['type'] = $data['case_type'];
                $_SESSION['search_res'] ['date'] = $data['case_date'];
                $_SESSION['search_res'] ['case_id'] = $data['case_id'];
                $_SESSION['search_res'] ['client_id'] = $data['client_id'];
                $_SESSION['search_res'] ['client_nic'] = $data['client_nic'];
                $_SESSION['search_res'] ['delete'] = $data['case_isDelete'];
                header("Location:" . BASE_URL . "includes/pages/searchResult.php?resultTemplate=single&clientId={$_SESSION['search_res'] ['client_id']}");
                // print_r($_SESSION['search_res']);
            
            } elseif (mysqli_num_rows($result) > 1) {
                $data = mysqli_fetch_assoc($result);
                $_SESSION['search_res'] ['date'] = $data['case_date'];
                $_SESSION['search_res'] ['sectionNumber'] = $data['case_sectionNumber'];
                $_SESSION['search_res'] ['number'] = $data['case_number'];
                $_SESSION['search_res'] ['client_nic'] = $data['client_nic'];
                
                header('Location:' . BASE_URL . 'includes/pages/searchResult.php?resultTemplate=many');
            } 
        } else {
            $_SESSION['errors'][] = 'No Match Found';
            header('Location:' . BASE_URL . 'includes/pages/caseSearch.php');
        }
    }
}


mysqli_close($connection);
?>

