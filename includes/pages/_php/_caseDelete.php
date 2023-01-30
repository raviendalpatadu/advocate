<?php
require_once('../../connection.php');
$func = new functions();
if (isset($_GET['clientId']) && isset($_GET['caseId'])) {

    
    $client_id = mysqli_real_escape_string($connection, $_GET['clientId']);
    $case_id = mysqli_real_escape_string($connection, $_GET['caseId']);
    

    
    echo 'client id' . $clientId . '<br>';
    echo 'case id' . $case_id . '<br>';



   
    if (empty($_SESSION['errors'])) {

        $query  = "UPDATE casedetails SET case_isDelete = 1 ";
        $query .= "WHERE  case_id={$case_id} AND client_fk={$client_id}  LIMIT 1";
        $result = mysqli_query($connection, $query);
        $func->verify_query($result);

        if ($result == 1) {       
            header("Location:" . BASE_URL . "includes/pages/".$_GET['from'].".php?Deleted=true");
        } else {
            echo 'jkjkjk';
            $_SESSION['errors'][] = 'Delete Failed';
            header("Location:" . BASE_URL . "includes/pages/" . $_GET['from'] . ".php");
        }
    }
}

$connection->close();
