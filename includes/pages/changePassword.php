<?php require('../connection.php');
$template = new template();
$func = new functions();

$id = $_GET['userId'];


?>
<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('Change Password'); ?>
<style>
    .contact-form span .pass {
        position: absolute;
        top: 10px;
        left: 305px;
        color: rgb(194, 194, 194);
    }
</style>

<body onload="startTime()">
    <?php $template->getNavBar('main');
    $template->getSideBar();
    ?>
    <section class="get-in-touch">
        <h1 class="title">Change Password</h1>
        <form action="_php/_changePassword.php" method="post">
            <?php
            if (!empty($_SESSION['errors'])) {
                $func->display_errors($_SESSION['errors'], 'errors');
            }
            //  else (!empty($_SESSION['success'])) {
            //     $func->display_success($_SESSION['success'], 'success')
            // }
            ?>
            <div class="container-fluid">
                <div class="contact-form row">
                    <div class="form-field col-lg-6">
                        <input id="password" class="input-text" type="password" name="password" style="padding-right: 28px;"><span class="pass"><i class="far fa-eye-slash pass" id="pass"></i></span>
                        <label for="password" class="label">Password</label>
                        <i class="fas fa-key"></i>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="c_password" class="input-text" type="password" name="confirm_password" style="padding-right: 28px;"><span class="pass"><i class="far fa-eye-slash pass" id="cpass"></i></span>
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

                <div class="contact-form row">
                    <div class="form-field col-lg-4">
                        <input type="submit" name="submit" value="Update" class="Submit-btn">
                    </div>
                    <div class="form-field col-lg-4">
                        <input type="reset" name="" value="Reset" class="Submit-btn">
                    </div>
                    <div class="form-field col-lg-4">
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