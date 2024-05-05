<?php

// connect database
require('../db.php');
// check login
require('../login_check.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT s.name, avatar, student_id, dob, gender, personalEmail, phone, workEmail, CONCAT(province, '，', city, '，', detail) AS address, enrolment, class_no, year, m.name AS mname, major_num, a.name AS aname FROM student s INNER JOIN class ON class.id = s.class_id INNER JOIN major m ON m.id = class.major_id INNER JOIN academy a ON a.id = m.academy_id WHERE username = '$username'";
$sname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

//更新用户信息
if(isset($_POST['submit'])){
    $dob=$_POST['dob'];
    $address=explode('，', $_POST['address']);
    $province = $address[0];
    $city = $address[1];
    $detail = $address[2];
    $phone=$_POST['phone'];
    $personalEmail=$_POST['personalEmail'];
    $workEmail=$_POST['workEmail'];
    
    $query = "UPDATE student SET dob = '$dob', province = '$province', city = '$city', detail = '$detail', phone = '$phone', personalEmail = '$personalEmail', workEmail = '$workEmail' WHERE username = '$username'";
    $result1 = mysqli_query($connection,$query);
    mysqli_free_result($result1);
    header('Location: profile.php?success=1');
}

//课程信息
$query = "SELECT course_no, c.name, semester FROM course c INNER JOIN student_course sc ON sc.course_id = c.id INNER JOIN student s ON s.id = sc.student_id WHERE username = '$username'";
$result = mysqli_query($connection,$query);

//上传头像
if(isset($_POST['submit1'])){
    if ($_FILES['file']['error']){
    switch ($_FILES['file']['error']){
        case 1:
            $str="More than the values set in php.ini";
            break;
        case 2:
            $str="More than the values set in the form";
            break;
        case 3:
            $str="Only part of the file is uploaded";
            break;
        case 4:
            $str="No files are uploaded";
            break;
        case 5:
            $str="Unable to find a temporary folder";
            break;
        case 6:
            $str="File write failure";
            break;
    }
    die($str);
    }
    //上传文件大小
    if ($_FILES['file']['size'] > (pow(1024,2)*2)){ //(pow(1024,2)*2) == 2M
        die('The size of the file exceeds the permitted size');
    }
    //上传文件的后缀名
    $allowMime = ['image/png','image/jpeg','image/gif','image/jpg'];
    $allowFix = ['png','jpeg','gif','jpg'];

    $info = pathinfo($_FILES['file']['name']);
    $subFix = $info['extension'];
    if(!in_array($subFix,$allowFix)){
        die('Inallowed file suffix');
    }
    if(!in_array($_FILES['file']['type'],$allowMime)){
        die('Inallowed MIME type');
    }

    //path
    $path = "../assets/img/avatars/";
    if (!file_exists($path)){
        mkdir($path);
    }
    //file name
    $name = uniqid().'.'.$subFix;
    //check upload file
    if (is_uploaded_file($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'] , $path.$name)){
            $query = "UPDATE student SET avatar = '$name' WHERE username = '$username'";
            $result2 = mysqli_query($connection,$query);
            mysqli_free_result($result2);
            header('Location: profile.php?success=avatar');
        }else{
            die('failure');
        }
    }else{
        die('This is not a file upload.');
    }
}

//change password
if(isset($_POST['submit2'])){
    if($_POST['username']==$username){
        $old_pass = $_POST['pass'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $query = "SELECT password FROM student WHERE username = '$username'";
        $pass = mysqli_fetch_array(mysqli_query($connection, $query));
        mysqli_free_result(mysqli_query($connection, $query));
        if($pass['password']==$old_pass && $pass1==$pass2){
            $query = "UPDATE student SET password = '$pass1' WHERE username = '$username'";
            $result2 = mysqli_query($connection, $query);
            mysqli_free_result($result2);
            header('Location: profile.php?success=password');
        } else {
            $error = "The password is wrong or the passwords entered twice are different!";
        }
    } else {
        $error = "Incorrect username";
    }
}

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Profile - Student Score Management System</title>
        <!-- Mobile specific metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- Force IE9 to render in normal mode -->
        <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Droid+Sans:400,700' />
        <!--[if lt IE 9]>
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
            <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
            <link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
        <![endif]-->
        <!-- Css files -->
        <!-- Icons -->
        <link href="../assets/css/icons.css" rel="stylesheet" />
        <!-- jQueryUI -->
        <link href="../assets/css/sprflat-theme/jquery.ui.all.css" rel="stylesheet" />
        <!-- Bootstrap stylesheets (included template modifications) -->
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
        <!-- Plugins stylesheets (all plugin custom css) -->
        <link href="../assets/css/plugins.css" rel="stylesheet" />
        <!-- Main stylesheets (template main css file) -->
        <link href="../assets/css/main.css" rel="stylesheet" />
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/img/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="icon" href="../assets/img/ico/favicon.ico" type="image/png">
       
        <meta name="msapplication-TileColor" content="#3399cc" />
    </head>
    <body>
        <!-- Start #header -->
        <div id="header">
            <div class="container-fluid">
                <div class="navbar">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="home.php">
<!--                            <i class="im-windows8 text-logo-element animated bounceIn"></i><span class="text-logo">Studnent</span><span class="text-slogan">Management</span>-->
                            <i class="im-books text-logo-element animated bounceIn"></i><span class="text-logo">SAM</span>
                        </a>
                    </div>
                    <nav class="top-nav" role="navigation">
                        <ul class="nav navbar-nav pull-left">
                            <li id="toggle-sidebar-li">
                                <a href="#" id="toggle-sidebar"><i class="en-arrow-left2"></i>
                        </a>
                            </li>
<!--                            <li>-->
<!--                                <a href="#" class="full-screen"><i class="fa-fullscreen"></i></a>-->
<!--                            </li>-->
                        </ul>
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown">
                                    <img class="user-avatar" src="../assets/img/avatars/<?php echo $sname['avatar'];?>"><?php echo $sname['name'];?></a>
                                <ul class="dropdown-menu right" role="menu">
                                    <li><a href="profile.php"><i class="st-user"></i>Profile</a>
                                    </li>
                                    <li><a href="../logout.php"><i class="im-exit"></i>Logout</a>
                                    </li>
                                </ul>
                            </li>
                            <li id="toggle-right-sidebar-li"><a href="../logout.php"><i class="im-switch"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Start .header-inner -->
        </div>
        <!-- End #header -->
        <!-- Start #sidebar -->
        <div id="sidebar">
            <!-- Start .sidebar-inner -->
            <div class="sidebar-inner">
                <!-- Start #sideNav -->
                <ul id="sideNav" class="nav nav-pills nav-stacked">
                    <li class="top-search">
                        <form>
                            <input type="text" name="search" placeholder="search...">
                            <button type="submit"><i class="ec-search s20"></i>
                            </button>
                        </form>
                    </li>
                    <li><a href="home.php">Home<i class="im-home"></i></a>
                    </li>
                    <li><a href="bulletin.php">Bulletin<i class="im-bullhorn"></i></a>
                    </li>
                    <li><a href="profile.php">Profile<i class="im-profile"></i></a>
                    </li>
                    <li><a href="grade.php">Grade<i class="ec-archive2"></i></a>
                    </li>
                    <li><a href="course.php"><i class="en-login"></i>Course</a>
                    </li>
                    <!--<li><a href="search.php"><i class="st-search"></i>search</a>
                    </li>-->
                    <li><a href="../logout.php"><i class="im-exit"></i>Logout</a>
                    </li>
                </ul>
                <!-- End #sideNav -->
            </div>
            <!-- End .sidebar-inner -->
        </div>
        <!-- End #sidebar -->
        <!-- Start #content -->
        <div id="content">
            <!-- Start .content-wrapper -->
            <div class="content-wrapper">
                <div class="row">
                    <!-- Start .row -->
                    <!-- Start .page-header -->
                    <div class="col-lg-12 heading">
                        <h1 class="page-header"><i class="im-profile"></i>Profile</h1>
                        <!-- Start .bredcrumb -->
                        <ul id="crumb" class="breadcrumb">
                        </ul>
                        <!-- End .breadcrumb -->
                        <!-- Start .option-buttons -->
                        <div class="option-buttons">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group">
                                    <a id="clear-localstorage" class="btn tip" title="refresh">
                                        <i class="ec-refresh s24"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End .option-buttons -->
                        <?php
                        if(isset($_GET['success'])) {
                            if($_GET['success']=="1"){
                                echo "<div class=\"alert alert-success fade in\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <i class=\"fa-ok alert-icon s24\"></i>
                                    <strong>Success!</strong> Edit personal info successfully!
                                </div>";
                            }elseif($_GET['success']=="password"){
                                echo "<div class=\"alert alert-success fade in\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <i class=\"fa-ok alert-icon s24\"></i>
                                    <strong>Success!</strong> Edit password successfully!
                                </div>";
                            }elseif($_GET['success']=="avatar"){
                                echo "<div class=\"alert alert-success fade in\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <i class=\"fa-ok alert-icon s24\"></i>
                                    <strong>Success!</strong> Edit avatar successfully!
                                </div>";
                            }
                        }
                        ?>
                    </div>
                    <!-- End .page-header -->
                </div>
                <!-- End .row -->
                <div class="outlet">
                    <!-- Start .outlet -->
                    <!-- Page start here ( usual with .row ) -->
                    <div class="row">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <!-- col-lg-4 start here -->
                            <div class="panel panel-default plain profile-widget">
                                <!-- Start .panel -->
                                <div class="panel-heading white-bg pl0 pr0">
                                    <img class="profile-image img-responsive" src="../assets/img/profile-cover.jpg" alt="profile cover">
                                </div>
                                <div class="panel-body">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="profile-avatar">
                                            <a  href="#avatar" data-toggle="modal" title="change image"><img class="img-responsive" src="../assets/img/avatars/<?php echo $sname['avatar'];?>" alt="user image"></a>
                                        </div>
                                        <!-- Modal itself -->
                                        <div class="modal fade" id="avatar" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="profile.php" method="post" enctype="multipart/form-data" role="form" class="form-horizontal group-border hover-stripped" id="validate">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">Change user image</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="col-lg-3 control-label">Select File</label>
                                                                <div class="col-lg-9">
                                                                    <input type="file" name="file" id="file" class="form-control" style="display:none">
                                                                </div>
                                                            </div><p></p>
                                                            <ul>
                                                                <li>File size should be less than<b>2 MB.</b></li>
                                                                <li>Allowed file types: <b>JPG, PNG, GIF.</b></li>
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success start" name="submit1">
                                                                <i class="en-upload"></i>
                                                                <span> Submit</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <div class="profile-name">
                                            <?php echo $sname['name'];?> <span class="label label-success">Student</span>
                                        </div>
                                        <div class="profile-quote">
                                            <p>Great deeds are accomplished not by strength but by perseverance.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer white-bg">
                                    <ul class="profile-info">
                                        <li><i class="ec-user"></i><?php echo $sname['name'];?></li>
                                        <li><?php if($sname['gender']=="male"){echo " <i class=\"fa-male\"></i>&ensp;male";}else{echo " <i class=\"fa-female\"></i>&ensp;female";}?></li>
                                        <li><i class="im-point-right"></i><abbr title="studentID"><?php echo $sname['student_id'];?></abbr></li>
                                        <li><i class="im-home3"></i><abbr title="ClassID"><?php echo $sname['class_no'];?></abbr></li>
                                        <li><i class="fa-bitbucket"></i> <abbr title="Programm"><?php echo $sname['mname'];?></abbr></li>
                                        <li><i class="im-office"></i><abbr title=" institution name"><?php echo $sname['aname'];?></abbr></li>
                                        <li><i class="fa-time"></i> <abbr title="enrolment date"><?php echo $sname['enrolment'];?></abbr></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End .panel -->
                            <div class="panel panel-default plain">
                                <!-- Start .panel -->
                                <div class="panel-heading white-bg">
                                    <h4 class="panel-title">My Course</h4>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="per10">
                                                    #
                                                </th>
                                                <th class="per30">Course ID</th>
                                                <th class="per30">Course Name</th>
                                                <th class="per30">Semester</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            while($row=mysqli_fetch_array($result)){
                                                echo "<tr>
                                                    <td>$i</td>
                                                    <td>".$row['course_no']."</td>
                                                    <td>".$row['name']."</td>
                                                    <td>".$row['semester']."</td>
                                                </tr>";
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End .panel -->
                        </div>
                        <!-- col-lg-4 end here -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <!-- col-lg-4 start here -->
                            <div class="panel panel-default plain">
                                <!-- Start .panel -->
                                <div class="panel-heading white-bg">
                                    <h4 class="panel-title"><i class="ec-user"></i>Change Profile</h4>
                                </div>
                                <div class="panel-body">
                                    <form class="form-vertical hover-stripped" role="form" method="post" action="profile.php">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" value="<?php echo $sname['name'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Student ID</label>
                                            <input type="text" class="form-control" value="<?php echo $sname['student_id'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Date of birth</label>
                                            <input type="text" class="form-control" name="dob" value="<?php echo $sname['dob'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Address</label>
                                            <input type="text" class="form-control" name="address" value="<?php echo $sname['address'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Phone</label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $sname['phone'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">workEmail</label>
                                            <input type="email" class="form-control" name="workEmail" value="<?php echo $sname['workEmail'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Personal Email</label>
                                            <input type="text" class="form-control" name="personalEmail" value="<?php echo $sname['personalEmail'];?>">
                                        </div>
                                        <!-- End .form-group  -->
                                        <div class="form-group"></div>
                                        <div class="form-group mb15">
                                            <a href="#basic_info" role="button" class="btn btn-primary" data-toggle="modal">Modify</a>
                                        </div>
                                        <!-- Modal itself -->
                                        <div class="modal fade" id="basic_info" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Warning</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-muted">Are you sure you want to modify the following content?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                        <!-- End .form-group  -->
                                    </form>
                                </div>
                            </div>
                            <!-- End .panel -->
                            <div class="panel panel-default plain">
                                <div class="panel-heading white-bg">
                                    <h4 class="panel-title"><i class="im-lock"></i>Modify Password</h4>
                                </div>
                                <div class="panel-body">
                                    <form class="form-vertical hover-stripped" role="form" method="post" action="profile.php">
                                        <div class="form-group">
                                            <label class="control-label">user name</label>
                                            <input type="text" class="form-control" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Original password</label>
                                            <input type="password" class="form-control" name="pass">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">New password</label>
                                            <input type="password" class="form-control" name="pass1">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Repeat password</label>
                                            <input type="password" class="form-control" name="pass2">
                                        </div>
                                        <div class="form-group">
                                            <?php if(isset($error)){echo "<label class=\"control-label\"><p class='text-danger'><b>$error</b></p></label>";}?>
                                        </div>
                                        <div class="form-group mb15">
                                            <a href="#password" role="button" class="btn btn-primary" data-toggle="modal">Modify</a>
                                        </div>
                                        <!-- Modal itself -->
                                        <div class="modal fade" id="password" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Warning</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-muted">Are you sure you want to modify the current information?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="submit2" class="btn btn-primary">Confirm</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .row -->
                    <!-- Page End here -->
                </div>
                <!-- End .outlet -->
            </div>
            <!-- End .content-wrapper -->
            <div class="clearfix"></div>
        </div>
        <!-- End #content -->
        <!-- Javascripts -->
        <!-- Load pace first -->
        <script src="../assets/plugins/core/pace/pace.min.js"></script>
        <!-- Important javascript libs(put in all pages) -->
        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script>
        window.jQuery || document.write('<script src="../assets/js/libs/jquery-2.1.1.min.js">\x3C/script>')
        </script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script>
        window.jQuery || document.write('<script src="../assets/js/libs/jquery-ui-1.10.4.min.js">\x3C/script>')
        </script>
        <!--[if lt IE 9]>
          <script type="text/javascript" src="../assets/js/libs/excanvas.min.js"></script>
          <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
          <script type="text/javascript" src="../assets/js/libs/respond.min.js"></script>
        <![endif]-->
        <!-- Bootstrap plugins -->
        <script src="../assets/js/bootstrap/bootstrap.js"></script>
        <!-- Core plugins ( not remove ever) -->
        <!-- Handle responsive view functions -->
        <script src="../assets/js/jRespond.min.js"></script>
        <!-- Custom scroll for sidebars,tables and etc. -->
        <script src="../assets/plugins/core/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../assets/plugins/core/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
        <!-- Resize text area in most pages -->
        <script src="../assets/plugins/forms/autosize/jquery.autosize.js"></script>
        <!-- Proivde quick search for many widgets -->
        <script src="../assets/plugins/core/quicksearch/jquery.quicksearch.js"></script>
        <!-- Bootbox confirm dialog for reset postion on panels -->
        <script src="../assets/plugins/ui/bootbox/bootbox.js"></script>
        <!-- Other plugins ( load only nessesary plugins for every page) -->
        <script src="../assets/plugins/core/moment/moment.min.js"></script>
        <script src="../assets/plugins/charts/sparklines/jquery.sparkline.js"></script>
        <script src="../assets/plugins/charts/pie-chart/jquery.easy-pie-chart.js"></script>
        <script src="../assets/plugins/forms/icheck/jquery.icheck.js"></script>
        <script src="../assets/plugins/forms/tags/jquery.tagsinput.min.js"></script>
        <script src="../assets/plugins/forms/tinymce/tinymce.min.js"></script>
        <script src="../assets/plugins/forms/switch/jquery.onoff.min.js"></script>
        <script src="../assets/plugins/forms/maxlength/bootstrap-maxlength.js"></script>
        <script src="../assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js"></script>
        <script src="../assets/plugins/forms/color-picker/spectrum.js"></script>
        <script src="../assets/plugins/forms/daterangepicker/daterangepicker.js"></script>
        <script src="../assets/plugins/forms/datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="../assets/plugins/forms/globalize/globalize.js"></script>
        <script src="../assets/plugins/forms/maskedinput/jquery.maskedinput.js"></script>
        <script src="../assets/plugins/forms/select2/select2.js"></script>
        <script src="../assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js"></script>
        <script src="../assets/plugins/forms/password/jquery-passy.js"></script>
        <script src="../assets/plugins/forms/checkall/jquery.checkAll.js"></script>
        <script src="../assets/plugins/forms/validation/jquery.validate.js"></script>
        <script src="../assets/plugins/forms/validation/additional-methods.min.js"></script>
        <script src="../assets/plugins/misc/highlight/highlight.pack.js"></script>
        <script src="../assets/plugins/misc/countTo/jquery.countTo.js"></script>
        <script src="../assets/js/jquery.sprFlat.js"></script>
        <script src="../assets/js/app.js"></script>
        <script src="../assets/js/pages/form-validation.js"></script>
    </body>
</html>