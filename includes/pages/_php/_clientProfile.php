<?php
require('../../connection.php');
$func = new functions();
if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $idno = mysqli_real_escape_string($connection, $_POST['idno']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = sha1(mysqli_real_escape_string($connection, $_POST['password']));
    $confirm_password = sha1(mysqli_real_escape_string($connection, $_POST['confirm_password']));
    $h_id = mysqli_real_escape_string($connection, $_POST['h_id']);

    //checking required fields
    $validate = array('name', 'idno', 'phone', 'address', 'email', 'password', 'confirm_password');
    $func->check_required_fields($validate);

    
    //checking  whether the email is valid
    if (!$func->is_email($_POST['email'])) {
        $_SESSION['errors'][] = 'Email address is invalid.';
    }

    //checking max characters
    $maxchar = array('name' => 100,'idno' => 12,'email' => 100,'phone' => 10, 'address' => 500);
    $func->check_max_len($maxchar);

    //checking whether the psswords match
    if ($password != $confirm_password) {
        $_SESSION['errors'][] = 'Passwords doesn\'t match';
    }

    if (empty($_SESSION['errors'])) {
        $query = "UPDATE userdetails SET ";
        $query.= "user_name = '$name', user_NIC='$idno', user_email='$email', ";
        $query .="user_address = '$address', user_password = '$password'  WHERE user_id = '$h_id'LIMIT 1";
        $result = mysqli_query($connection,$query);
        $func->verify_query($result);
        if ($result == 1) {
            header('Location:'.BASE_URL.'includes/pages/userProfile.php?create=true');
        }
    } else {
        header("Location:" . BASE_URL . "includes/pages/userProfile.php?userId={$h_id}");
    }
}

mysqli_close($connection);
