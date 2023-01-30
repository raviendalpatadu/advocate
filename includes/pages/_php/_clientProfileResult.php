<?php
require_once('../../connection.php');
$func = new functions();
if (isset($_POST['submit'])) {
    
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $id = mysqli_real_escape_string($connection, $_POST['idno']);
    $h_id = mysqli_real_escape_string($connection, $_POST['h_id']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    
    //checking required fields
    $required_field = array('name','idno','phone','address');
    $func->check_required_fields($required_field);
    
    // check whether the email is valid
    if (isset($email)) {
        if (!$func->is_email($_POST['email'])) {            
            $_SESSION['errors'][] = 'Email address is invalid.';
        }
    }
    
    //checking max characters
    $maxchar = array('name' => 100,'idno' => 12,'email' => 100,'phone' => 10, 'address' => 500);
    $func->check_max_len($maxchar);
    
    if (empty($_SESSION['errors'])) {
        
        $query = "UPDATE clientdetails SET client_name='{$name}', client_nic='{$id}', client_email='{$email}',";
        $query.=" client_address='{$address}', client_tel={$phone} WHERE client_id={$h_id} LIMIT 1"; 
        $result = mysqli_query($connection, $query);
        $func->verify_query($result); 
        
        if ($result == 1) {
            
            echo $email;
            $_SESSION['active'] = 'main';
            $_SESSION['clientID'] = $id;
            header('Location:' . BASE_URL . 'includes/pages/clientProfile.php?create=true');
        } 
    } else{
        $_SESSION['active'] = 'main';
        header('Location:'. BASE_URL . 'includes/pages/clientRegistration.php');
    }
}   

if (isset($_POST['back'])) {
    header("Location:".BASE_URL."includes/pages/clientProfile.php");
}
$connection->close();
