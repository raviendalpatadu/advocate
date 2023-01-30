<?php require('./includes/connection.php');
$template = new template();
$func = new functions();

?>


<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('Login', 'login'); ?>
<style>
    .form-floating span .pass {
        position: relative;
        bottom: 30px;
        left: 270px;
        color: rgb(194, 194, 194);
    }
</style>
<body onload="startTime()">
    <?php $template->getNavBar('login'); ?>
    <div class="d-flex justify-content-center"> 
        <fieldset class="inForm">
            <legend class="ledHead">
                <h1>Login</h1>
            </legend>
            <form action="./includes/pages/_php/_index.php" method="post">
                <?php
                if (isset($_GET['create'])) {
                    echo '<div class="alert alert-success id="alert-msg""> User Added. </div>';
                } elseif (isset($_GET['logout']) == true) {
                    echo '<div class="alert alert-success" id="alert-msg"> logged out successfully. </div>';
                }
                //errors
                if (!empty($_SESSION['errors'])) {
                    $func->display_errors($_SESSION['errors'], 'errors');
                }
    
    
                ?>
    
                <div class="inbox">
                    <div class="form-floating">
                        <label for="floatingInput">Username</label>
                        <input type="text" class="form-control" name="username" id="floatingInput" placeholder="name@example.com">
                    </div>
                    <div class="form-floating">
                        <label for="floatingPassword">Password</label>
                        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" style="padding-right: 28px;"><span class="pass"><i class="far fa-eye-slash pass" id="pass"></i></span>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        var showPassword = false;

                        $('#pass').click(function() {
                            if (showPassword == false) {
                                $(this).removeClass("far fa-eye-slash");
                                $(this).addClass("far fa-eye");
                                $('#floatingPassword').prop('type','text');
                                showPassword =true;
                            } else{
                                $(this).removeClass("far fa-eye");
                                $(this).addClass("far fa-eye-slash");
                                $('#floatingPassword').prop('type','password');
                                showPassword =false;
                            }
                        })
                        
                    })
                </script>
                
                <div class="enter">
                    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    
                </div>
            </form>
        </fieldset>
    </div>
</body>

</html>

<?php
$template->getFooter('login');
mysqli_close($connection); ?>