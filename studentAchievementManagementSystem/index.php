<?php

// connect to db
require('db.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
        // username password
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // query
        $query  = "SELECT username, password FROM " . $role . " WHERE username = '$username' AND password = '$password'";
        //
        $result = mysqli_query($connection, $query);

        // check
        $numrows = mysqli_num_rows($result);
        if ($numrows == 1) {
            session_start();
            $_SESSION['login_user'] = $username;
            if ($role == "student") {
                header('Location: student/home.php');
            } else if ($role == "teacher") {
                header('Location: teacher/home.php');
            } else{
                header('Location: manager/home.php');
            }
            exit();
        } else {
            $error = "Login failed";
        }

        // close
        mysqli_free_result($result);
    }
}

// close
mysqli_close($connection);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login | Student Achievement System</title>
    <!-- Mobile specific metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Force IE9 to render in normal mode -->
    <!-- Import google fonts - Heading first/ text second -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Droid+Sans:400,700' />
    <!--[if lt IE 9]>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!-- Css files -->
    <!-- Icons -->
    <link href="assets/css/icons.css" rel="stylesheet" />
    <!-- jQueryUI -->
    <link href="assets/css/sprflat-theme/jquery.ui.all.css" rel="stylesheet" />
    <!-- Bootstrap stylesheets (included template modifications) -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- Plugins stylesheets (all plugin custom css) -->
    <link href="assets/css/plugins.css" rel="stylesheet" />
    <!-- Main stylesheets (template main css file) -->
    <link href="assets/css/main.css" rel="stylesheet" />
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="icon" href="assets/img/ico/favicon.ico" type="image/png">


</head>
<body class="login-page">
<!-- Start #login -->
<div id="login" class="animated bounceIn">
    <img id="logo" src="assets/img/logo.png"  alt="logo">
    <!-- Start .login-wrapper -->
    <div class="login-wrapper">
        <ul id="myTab" class="nav nav-tabs nav-justified bn">
            <li>
                <a>SAM Login</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content bn">
            <div class="tab-pane fade active in" id="log-in">
                <form class="form-horizontal mt10" id="login-form" role="form" action="index.php" method="POST">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="text" name="username" id="workEmail" class="form-control left-icon" placeholder="username">
                            <i class="ec-user s16 left-input-icon"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="password" name="password" id="password" class="form-control left-icon" placeholder="password">
                            <i class="ec-locked s16 left-input-icon"></i>
                            <span class="help-block"><a href="#"><small> </small></a></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-12 control-label">
                            <?php if(isset($error)){echo "<p class='text-danger'><b>$error</b></p>";}?>
                        </label>
                        <div class="col-lg-8 col-md-8">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <select class="form-control" name="role">
                                        <optgroup label="Choose Role">
                                            <option value="student">Student</option>
                                            <option value="teacher">Teacher</option>
                                            <option value="teacher">Manager</option>
                                        </optgroup>
                                    </select>
<!--                                    <span class="help-block">Login</span>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="seperator">
                        <hr>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                            <!-- col-lg-12 start here -->
<!--                            <label class="checkbox">-->
<!--                                <input type="checkbox" name="remember" id="remember" value="option">remember?-->
<!--                            </label>-->
                        </div>
                        <!-- col-lg-12 end here -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4">
                            <!-- col-lg-12 start here -->
                            <button class="btn btn-success pull-right" name="submit" type="submit">Login</button>
                            <!-- <input type="submit" class="btn btn-success pull-right" name="submit" value="SIGN-IN"> -->
                        </div>
                        <!-- col-lg-12 end here -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End #.login-wrapper -->
</div>
<!-- End #login -->
<!-- Javascripts -->
<!-- Load pace first -->
<script src="assets/plugins/core/pace/pace.min.js"></script>
<!-- Important javascript libs(put in all pages) -->
<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
<script>
    window.jQuery || document.write('<script src="assets/js/libs/jquery-2.1.1.min.js">\x3C/script>')
</script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    window.jQuery || document.write('<script src="assets/js/libs/jquery-ui-1.10.4.min.js">\x3C/script>')
</script>
<!-- Bootstrap plugins -->
<script src="assets/js/bootstrap/bootstrap.js"></script>
<!-- Form plugins -->
<script src="assets/plugins/forms/icheck/jquery.icheck.js"></script>
<script src="assets/plugins/forms/validation/jquery.validate.js"></script>
<script src="assets/plugins/forms/validation/additional-methods.min.js"></script>
<!-- Init plugins olny for this page -->
<script src="assets/js/pages/login.js"></script>
</body>
</html>