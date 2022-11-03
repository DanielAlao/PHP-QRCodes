<!DOCTYPE html>
<html lang="en">
<title>Login - Qrcode Generator</title>
<?php include './includes/head.php';

require_once 'config/config.php';

session_start();
?>



<body class="login-page" style="min-height: 512.391px;">
    <div class="login-box">
        <div class="login-logo">
            <img src="dist/img/php_logo.jpg" style="width: 10%; height: 10%">
        </div>

        <?php if (isset($_SESSION['success_msg'])) : ?>
            <br>
            <div class="text-center mb-3">
                <div class="card-body p-0">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php
                        echo $_SESSION['success_msg'];
                        unset($_SESSION['success_msg']);
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php if (isset($_SESSION['register_fail'])) : ?>
            <br>
            <div class="text-center mb-3">
                <div class="card-body p-0">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php
                        echo $_SESSION['register_fail'];
                        unset($_SESSION['register_fail']);
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['register_fail_password'])) : ?>
            <br>
            <div class="text-center mb-3">
                <div class="card-body p-0">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php
                        echo $_SESSION['register_fail_password'];
                        unset($_SESSION['register_fail_password']);
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>        

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign up to start your session</p>

                <form method="POST" action="register_auth.php">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                        </div>
                    </div>
                        <!-- /.col -->

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" name="reg_user">Register</button>
                        </div>
                    </div>
                        <hr>    
                            <input type="button" value="Login" class="btn btn-success btn-block" id="btnHome" 
				            onClick="document.location.href='login.php'"/>
                        <!-- /.col -->
                    </div>

                </form>

