<?php

// connect to db
require('../db.php');
// check login
require('../login_check.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT t.name, teacher_no, avatar, academic_title, dob, gender, personalEmail, workEmail, phone, inauguration_date, leave_date, a.name AS aname, address FROM teacher t INNER JOIN academy a ON a.id = t.academy_id WHERE username = '$username'";
$tname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

//update
if(isset($_POST['submit'])){
    $dob=$_POST['dob'];
    $phone=$_POST['phone'];
    $workEmail=$_POST['workEmail'];
    $personalEmail=$_POST['personalEmail'];
    
    $query = "UPDATE teacher SET dob = '$dob', phone = '$phone', workEmail = '$workEmail', personalEmail = '$personalEmail' WHERE username = '$username'";
    $result1 = mysqli_query($connection,$query);
    mysqli_free_result($result1);
    header('Location: profile.php?success=1');
}

//Course info
$query = "SELECT course_no, c.name, semester FROM course c INNER JOIN teacher t ON t.id = c.teacher_id WHERE username = '$username'";
$result = mysqli_query($connection,$query);

//Upload avatar
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
    //Upload file
    if ($_FILES['file']['size'] > (pow(1024,2)*2)){ //(pow(1024,2)*2) == 2M
        die('The size of the file exceeds the permitted size');
    }
    //Suffix of uploaded files
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

    //Path of file
    $path = "../assets/img/avatars/";
    if (!file_exists($path)){
        mkdir($path);
    }
    //
    $name = uniqid().'.'.$subFix;
    //check
    if (is_uploaded_file($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'] , $path.$name)){
            $query = "UPDATE teacher SET avatar = '$name' WHERE username = '$username'";
            $result2 = mysqli_query($connection,$query);
            mysqli_free_result($result2);
            header('Location: profile.php?success=avatar');
        }else{
            die('Fail');
        }
    }else{
        die('Error');
    }
}

//修改密码
if(isset($_POST['submit2'])){
    if($_POST['username']==$username){
        $old_pass = $_POST['pass'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $query = "SELECT password FROM teacher WHERE username = '$username'";
        $pass = mysqli_fetch_array(mysqli_query($connection, $query));
        mysqli_free_result(mysqli_query($connection, $query));
        if($pass['password']==$old_pass && $pass1==$pass2){
            $query = "UPDATE teacher SET password = '$pass1' WHERE username = '$username'";
            $result3 = mysqli_query($connection, $query);
            mysqli_free_result($result3);
            header('Location: profile.php?success=password');
        } else {
            $error = "Incorrect password or different passwords entered twice!";
        }
    } else {
        $error = "Incorrect username!";
    }
}

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Profile - Student Achievement Management System</title>
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
<!--                            <i class="im-windows8 text-logo-element animated bounceIn"></i><span class="text-logo">学生</span><span class="text-slogan">管理</span> -->
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
                                    <img class="user-avatar" src="../assets/img/avatars/<?php echo $tname['avatar'];?>"><?php echo $tname['name'];?></a>
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
                            <input type="text" name="search" placeholder="Search...">
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
                    <li><a href="student.php">Student<i class="im-accessibility"></i></a>
                    </li>
                    <li><a href="teacher.php">Teacher<i class="im-user4"></i></a>
                    </li>
                    <li><a href="course.php">Course<i class="im-book"></i></a>
                    </li>
                    <li><a href="grade_manage.php">Grade Manage<i class="ec-archive2"></i></a>
                    </li>
                    <li><a href="grade.php"><i class="en-login"></i>Grade</a>
                    </li>
                    <!--<li><a href="search.php"><i class="st-search"></i>搜索</a>
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
<!--                                    <a id="clear-localstorage" class="btn tip" title="Reset panels position">-->
<!--                                        <i class="ec-refresh s24"></i>-->
<!--                                    </a>-->
                                </div>
                                <div class="btn-group dropdown">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" id="dropdownMenu2"><i class="ec-pencil s24"></i></a> 
                                    <div class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu2">
                                        <div class="option-dropdown">
                                            <div class="row">
                                                <p class="col-lg-12">Submit</p>
                                                <form class="form-horizontal" role="form" method="post" action="bulletin.php">
                                                    <!-- End .form-group  -->
                                                    <div class="form-group">
                                                        <div class="col-lg-12">
                                                            <textarea class="form-control wysiwyg" placeholder="content" name="content"></textarea>
                                                        </div>
                                                    </div>
                                                    <!-- End .form-group  -->
                                                    <div class="form-group">
                                                        <div class="col-lg-12">
                                                            <button class="btn btn-success btn-xs pull-right" type="submit" name="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                    <!-- End .form-group  -->
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
                                    <strong>Done!</strong> Edit info successfully!
                                </div>";
                            }elseif($_GET['success']=="password"){
                                echo "<div class=\"alert alert-success fade in\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <i class=\"fa-ok alert-icon s24\"></i>
                                    <strong>Done!</strong> Edit password successfully!
                                </div>";
                            }elseif($_GET['success']=="avatar"){
                                echo "<div class=\"alert alert-success fade in\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <i class=\"fa-ok alert-icon s24\"></i>
                                    <strong>Done!</strong> Edit avatar successfully!
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
                                            <a  href="#avatar" data-toggle="modal" title="edit avatar"><img class="img-responsive" src="../assets/img/avatars/<?php echo $tname['avatar'];?>" alt="edit avatar"></a>
                                        </div>
                                        <!-- Modal itself -->
                                        <div class="modal fade" id="avatar" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="profile.php" method="post" enctype="multipart/form-data" role="form" class="form-horizontal group-border hover-stripped" id="validate">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">Edit avatar</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="col-lg-3 control-label">Choose file</label>
                                                                <div class="col-lg-9">
                                                                    <input type="file" name="file" id="file" class="form-control" style="display:none">
                                                                </div>
                                                            </div><p></p>
                                                            <ul>
                                                                <li>File size should be less than: <b>2 MB.</b></li>
                                                                <li>File type: <b>JPG, PNG, GIF.</b></li>
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success start" name="submit1">
                                                                <i class="en-upload"></i>
                                                                <span>Submit</span>
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
                                            <?php echo $tname['name'];?> <span class="label label-success">Teacher</span>
                                        </div>
                                        <div class="profile-quote">
                                            <p>Love the world!</p>
                                            <p class="pull-right">——JJ</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer white-bg">
                                    <ul class="profile-info">
                                        <li><i class="ec-user"></i><?php echo $tname['name'];?></li>
                                        <li><?php if($tname['gender']=="male"){echo " <i class=\"fa-male\"></i>&ensp;male";}else{echo " <i class=\"fa-female\"></i>&ensp;female";}?></li>
                                        <li><i class="im-point-right"></i><abbr title="Teacher ID"><?php echo $tname['teacher_no'];?></abbr></li>
                                        <li><i class="fa-bitbucket"></i> <abbr title="Title"><?php echo $tname['academic_title'];?></abbr></li>
                                        <li><i class="im-home3"></i><abbr title="Campus"><?php echo $tname['aname'];?></abbr></li>
                                        <!--<li><i class="im-office"></i><abbr title="教学楼"><?php echo $tname['address'];?></abbr></li>-->
                                        <li><i class="fa-time"></i> <abbr title="Inauguration Date"><?php echo $tname['inauguration_date'];?></abbr></li>
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
                                    <h4 class="panel-title"><i class="ec-user"></i>Edit Info</h4>
                                </div>
                                <div class="panel-body">
                                    <form class="form-vertical hover-stripped" role="form" method="post" action="profile.php">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" value="<?php echo $tname['name'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Teacher ID</label>
                                            <input type="text" class="form-control" value="<?php echo $tname['teacher_no'];?>" disabled>
                                        </div>
                                        <!--<div class="form-group">
                                            <label class="control-label">教学楼</label>
                                            <input type="text" class="form-control" value="<?php echo $tname['address'];?>" disabled>
                                        </div>-->
                                        <div class="form-group">
                                            <label class="control-label">Bod</label>
                                            <input type="text" class="form-control" name="dob" value="<?php echo $tname['dob'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Phone</label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $tname['phone'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Work Email</label>
                                            <input type="email" class="form-control" name="workEmail" value="<?php echo $tname['workEmail'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Personal Email</label>
                                            <input type="text" class="form-control" name="personalEmail" value="<?php echo $tname['personalEmail'];?>">
                                        </div>
                                        <!-- End .form-group  -->
                                        <div class="form-group"></div>
                                        <div class="form-group mb15">
                                            <a href="#basic_info" role="button" class="btn btn-primary" data-toggle="modal">Edit</a>
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
                                                        <p class="text-muted">Are you sure you want to edit?</p>
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
                                    <h4 class="panel-title"><i class="im-lock"></i>Edit Password</h4>
                                </div>
                                <div class="panel-body">
                                    <form class="form-vertical hover-stripped" role="form" method="post" action="profile.php">
                                        <div class="form-group">
                                            <label class="control-label">User Name</label>
                                            <input type="text" class="form-control" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Old Password</label>
                                            <input type="password" class="form-control" name="pass">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">New Password</label>
                                            <input type="password" class="form-control" name="pass1">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Repeat New Password</label>
                                            <input type="password" class="form-control" name="pass2">
                                        </div>
                                        <div class="form-group">
                                            <?php if(isset($error)){echo "<label class=\"control-label\"><p class='text-danger'><b>$error</b></p></label>";}?>
                                        </div>
                                        <div class="form-group mb15">
                                            <a href="#password" role="button" class="btn btn-primary" data-toggle="modal">Edit</a>
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
                                                        <p class="text-muted">Are you sure you want to edit?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="submit2" class="btn btn-primary">Submit</button>
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
          <script type="text/javascript" src="../http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
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