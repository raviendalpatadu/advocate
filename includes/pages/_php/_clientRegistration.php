<?php
require_once('../../connection.php');
$func = new functions();
if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $id = mysqli_real_escape_string($connection, $_POST['idno']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);



    //checking required fields
    $required_field = array('name', 'idno', 'phone', 'address');
    $func->check_required_fields($required_field);

    // check whether the email is valid
    if (!isset($email) || !empty($email)) {

        // echo $email;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errors'][] = 'Email address is invalid.';
        }
    }

    //checking max characters
    $maxchar = array('name' => 100, 'idno' => 12, 'phone' => 10, 'address' => 500);
    $func->check_max_len($maxchar);

    if (empty($_SESSION['errors'])) {

        $query = "INSERT INTO clientdetails (client_name, client_nic, client_email, client_address, client_tel) ";
        $query .= "VALUES ('$name','$id','$email','$address','$phone') LIMIT 1";
        $result = mysqli_query($connection, $query);
        // $func->verify_query($result);

        if ($result == 1) {
            if (mkdir("../../../client_documents/clients/" . $name . "/")) {
                $_SESSION['clientID'] = $id;
                header('Location:' . BASE_URL . 'includes/pages/caseRegistration.php');
            } else {
                echo "error";
            }
        } elseif ($result == false) {
            if (mysqli_errno($connection) == 1062) {
                $_SESSION['errors'][] = "Client Alredy Exsits";
                header('Location:' . BASE_URL . 'includes/pages/clientRegistration.php');
            }
        } 
    } else {

        header('Location:' . BASE_URL . 'includes/pages/clientRegistration.php');
    }
}
$connection->close();
