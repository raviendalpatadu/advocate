<?php require('../connection.php');
$template = new template();
$func = new functions();

?>
<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('CLient Profile'); ?>

<body onload="startTime()">
    <?php $template->getNavBar('main');
        $template->getSideBar();

            if (isset($_GET['client_id'])) {
                $clientid = $_GET['client_id'];    
            } else {
                $_SESSION['errors'][] = "client Id not set";
                header("Location:".BASE_URL."includes/pages/cilentProfile.php");
            }
            
            $query_client = "SELECT * FROM clientdetails WHERE client_id = '{$clientid}' ORDER BY client_dateCreated LIMIT 1";
            $result_client = mysqli_query($connection, $query_client);
            $func->verify_query($result_client);

            $data = mysqli_fetch_assoc($result_client);
            $name =$data['client_name'];
            $email =$data['client_email'];
            $nic =$data['client_nic'];
            $address =$data['client_address'];
            $tel =$data['client_tel'];
            


            ?>
            
            <section class="get-in-touch">
                <h1 class="title"><i class="fas fa-user-edit"></i> <?php echo $name?></h1>
            <form action="_php/_clientProfileResult.php" method="post">
            
               <?php if (!empty($_SESSION['errors'])) {
                    $func->display_errors($_SESSION['errors'], 'errors');
                }elseif (isset($_GET['create'])) {
                    echo '<div class="alert alert-success" id="alert-msg" >client Updated. </div>';
                }
                ?>
                
                <div class="container-fluid">
                            <div class="contact-form row">
                                <div class="form-field col-lg-6">
                                    <input id="name" class="input-text" type="text" name="name" value="<?php echo $name; ?>">
                                    <label for="" class="label"> Name</label>
                                    <input type="hidden" name="h_id" value="<?php echo $clientid; ?>">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input id="idNo" class="input-text" type="text" name="idno" value="<?php echo $nic; ?>">
                                    <label for="idNo" class="label">Id Number</label>
                                    <i class="far fa-address-card"></i>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input id="Telephone" class="input-text" type="text" name="phone" value="<?php echo $tel; ?>">
                                    <label for="Telephone" class="label"> Telephone</label>
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input id="address" class="input-text" type="text" name="address" value="<?php echo $address; ?>">
                                    <label for="address" class="label"> Address</label>
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input id="email" class="input-text" type="text" name="email" value="<?php echo $email; ?>">
                                    <label for="email" class="label"> Email</label>
                                    <i class="far fa-envelope"></i>
                                </div>
                                
                            </div>
                            <div class=" contact-form row">
                                <div class="form-field col-lg-6">
                                    <input type="submit" name="submit" value="Submit" class="Submit-btn">
                                </div>
                    
                                <div class="form-field col-lg-6">
                                    <input type="submit" name="back" value="Back" class="Submit-btn">
                                </div>
                            </div>
                        </div>
                    </form>
                </section>

</body>

</html>
<?php $template->getFooter(); ?>
<?php mysqli_close($connection); ?>