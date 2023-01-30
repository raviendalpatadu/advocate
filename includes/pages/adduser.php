<?php require('../connection.php');
$template = new template();
$func = new functions();
?>
<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('Adduser'); ?>
<style>
    .contact-form span .pass {
        position: absolute;
        top: 10px;
        left: 339px;
        color: rgb(194, 194, 194);
    }
</style>
<body onload="startTime()">
    <?php $template->getNavBar('main');
        $template->getSideBar();
    ?>

    <section class="get-in-touch">
        <h1 class="title">User Registration</h1>
        <form action="_php/_adduser.php" method="post">
            <?php
            if (!empty($_SESSION['errors'])) {
                $func->display_errors($_SESSION['errors'], 'errors');
            }elseif (isset($_GET['create'])) {
                echo '<div class="alert alert-success" id="alert-msg" >User Registered. </div>';
            }
            ?>
            <div class="container-fluid">
                <div class="contact-form row">
                    <div class="form-field col-lg-6">
                        <input id="name" class="input-text" type="text" name="name">
                        <label for="name" class="label"> Name</label>
                        <i class="far fa-user"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="idNo" class="input-text" type="text" name="idno">
                        <label for="idNo" class="label">Id Number</label>
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
                    <div class="form-field col-lg-6">
                        <input id="password" class="input-text" type="password" name="password" style="padding-right: 28px;"><span class="pass"><i class="far fa-eye-slash pass" id="pass"></i></span>
                        <label for="password" class="label"> Password</label>
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="c_password" class="input-text" type="password" name="confirm_password" style="padding-right: 28px;"><span><i class="far fa-eye-slash pass" id="cpass"></i></span>
                        <label for="c_password" class="label">Confirm Password</label>
                        <i class="fas fa-key"></i>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        var showPassword = false;

                        $('#pass').click(function() {
                            if (showPassword == false) {
                                $(this).removeClass("far fa-eye-slash");
                                $(this).addClass("far fa-eye");
                                $('#password').prop('type','text');
                                showPassword =true;
                            } else{
                                $(this).removeClass("far fa-eye");
                                $(this).addClass("far fa-eye-slash");
                                $('#password').prop('type','password');
                                showPassword =false;
                            }
                        })
                        $('#cpass').click(function() {
                            if (showPassword == false) {
                                $(this).removeClass("far fa-eye-slash");
                                $(this).addClass("far fa-eye");
                                $('#c_password').prop('type','text');
                                showPassword =true;
                            } else{
                                $(this).removeClass("far fa-eye");
                                $(this).addClass("far fa-eye-slash");
                                $('#c_password').prop('type','password');
                                showPassword =false;
                            }
                        })
                    })
                </script>
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