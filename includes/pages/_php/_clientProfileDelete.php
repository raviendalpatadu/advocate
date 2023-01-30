<?php
require('../../connection.php');
$func = new functions();
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    $query = "UPDATE clientdetails SET client_isDelete = 1 WHERE client_id= '$id' LIMIT 1";
    $result = mysqli_query($connection,$query);
    $func->verify_query($result);
    if ($result == 1) {
        header('Location:'.BASE_URL.'includes/pages/clientProfile.php?delete=ture');
    } else{
        $_SESSION['errors'][] = "User Not Deleted";
        header('Location:'.BASE_URL.'includes/pages/clientProfile.php');
    }
}

mysqli_close($connection);
?>