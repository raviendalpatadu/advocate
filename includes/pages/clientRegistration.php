<?php require('../connection.php');
$template = new template();
$func = new functions();
?>
<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('Add Client'); ?>

<body onload="startTime()">
    <?php $template->getNavBar('main');
    $template->getSideBar();
    ?>
    
    <section class="get-in-touch">
        <h1 class="title">Client Registration</h1>
        <form action="_php/_clientRegistration.php" method="POST">
        <div class="container-fluid">
            <?php
            if (!empty($_SESSION['errors'])) {
                $func->display_errors($_SESSION['errors'], 'errors');
            } 
            if (isset($_GET['create'])) {
                echo '<div class="alert alert-success" id="alert-msg">Client/Case Registered. </div>';
            }
            ?>
                <div class="contact-form row">
                    <div class="form-field col-lg-6">
                        <input id="name" class="input-text" type="text" name="name">
                        <label for="name" class="label"> Name</label>
                        <i class="far fa-user"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="password" class="input-text" type="text" name="idno">
                        <label for="password" class="label">Id Number</label>
                        <i class="far fa-address-card"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="Telephone" class="input-text" type="text" name="phone">
                        <label for="Telephone" class="label"> Telephone</label>
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="Address" class="input-text" type="text" name="address">
                        <label for="Address" class="label"> Address</label>
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="Address" class="input-text" type="text" name="email">
                        <label for="Address" class="label"> Email</label>
                        <i class="far fa-envelope"></i>
                    </div>
                </div>
                <div class=" contact-form row">
                    <div class="form-field col-lg-6">
                        <input type="submit" name="submit" value="Submit" class="Submit-btn">
                    </div>
                    <div class="form-field col-lg-6">
                        <input type="reset" name="" value="Reset" class="Submit-btn">
                    </div>
                </div>
            </div>
        </form>
    </section>
</body>

</html>
<?php $template->getFooter(); ?>
<?php mysqli_close($connection); ?>