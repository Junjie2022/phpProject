<?php

// 连接数据库连接
require('../db.php');
// 检查是否登录
require('../login_check.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT name, avatar FROM teacher WHERE username = '$username'";
$tname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

$query = "SELECT * from teacher";
$result = mysqli_query($connection,$query);

if (isset($_POST['submit'])){
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $academic_title = $_POST['academic_title'];
    $personalEmail = $_POST['personalEmail'];
    $phone = $_POST['phone'];
    $workEmail = $_POST['workEmail'];
    $inauguration = $_POST['inauguration_date'];
    $leave_date = $_POST['leave_date'];
    $academy = $_POST['academy'];
    $teacher_no = rand(10000,99999).rand(10000,99999);
    $username = rand(100000,999999);
    $role = $_POST['role'];
    
    $query = "INSERT INTO teacher (name, teacher_no, gender, dob, academic_title, personalEmail, phone, workEmail, inauguration_date, leave_date, academy_id, username, role) VALUES ('$name', '$teacher_no', '$gender', '$dob', '$academic_title', '$personalEmail', '$phone', '$workEmail', '$inauguration', '$leave_date', (SELECT id FROM academy WHERE name = '$academy'), '$username', '$role')";
    $result1 = mysqli_query($connection, $query);
    mysqli_free_result($result1);
    header('Location: teacher.php?success=1');
}

$query = "SELECT name FROM academy";
$result3 = mysqli_query($connection,$query);

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Teacher Management - Student Achievement Management System</title>
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
                            <i class="im-books text-logo-element animated bounceIn"></i><span class="text-logo">SAM</span>
<!--                            <i class="im-windows8 text-logo-element animated bounceIn"></i><span class="text-logo">Student</span><span class="text-slogan">Management</span>-->
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
                    <li><a href="grade.php"><i class="en-login"></i>Grade Entry</a>
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
                        <h1 class="page-header"><i class="im-user4"></i>Teacher Management</h1>
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
                                    </a>
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
                                    <strong>Success!</strong> Edit teacher info successfully!
                                </div>";
                            }elseif($_GET['success']=="del"){
                                echo "<div class=\"alert alert-success fade in\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <i class=\"fa-ok alert-icon s24\"></i>
                                    <strong>Success!</strong> Delete a teacher successfully!
                                </div>";
                            }elseif($_GET['success']=="2"){
                                echo "<div class=\"alert alert-danger fade in\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <i class=\"fa-remove alert-icon s24\"></i>
                                    <strong>Error!</strong> Can't delete this teacher info.
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
                        <div class="col-lg-12">
                            <!-- col-lg-12 start here -->
                            <div class="page-header">
                                <h5>All Teachers</h5>
                            </div>
                            <table class="table display" id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Avatar</th>
                                        <th>Teacher Name</th>
                                        <th>Title</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Personal Email</th>
                                        <th>Phone</th>
                                        <th>Work Email</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>More</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                                    while($row=mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        echo "<td>".$i."</td>";
                                        echo "<td><img height=\"40px\" class=\"user-avatar\" src=\"../assets/img/avatars/".$row['avatar']."\"></td>";
                                        echo "<td>".$row['name']."</td>";
                                        echo "<td>".$row['academic_title']."</td>";
                                        echo "<td>".$row['dob']."</td>";
                                        echo "<td>".$row['gender']."</td>";
                                        if($row['personalEmail']==""||$row['personalEmail']==null){$row['personalEmail']="None";}
                                        echo "<td>".$row['personalEmail']."</td>";
                                        if($row['phone']==""||$row['phone']==null){$row['phone']="None";}
                                        echo "<td>".$row['phone']."</td>";
                                        if($row['workEmail']==""||$row['workEmail']==null){$row['workEmail']="None";}
                                        echo "<td>".$row['workEmail']."</td>";
                                        echo "<td>".$row['username']."</td>";
                                        echo "<td>".$row['password']."</td>";
                                        echo "<td><button class='btn btn-xs btn-success' onclick=\"window.location.href='detail_teacher.php?id=".$row['id']."'\">More</button></td>";
                                        echo "<td><button class='btn btn-xs btn-danger' onclick=\"window.location.href='dele_teacher.php?id=".$row['id']."'\">Delete</button></td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                    mysqli_free_result($result);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- col-lg-12 end here -->
                        <div class="col-lg-12">
                            <div class="page-header">
                                <h5>Add Teacher</h5>
                            </div>
                            <form class="form-horizontal" role="form" method="post" action="teacher.php">
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">Name</label>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">Gender</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="male" checked="checked">Male
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="female">Female
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">Title</label>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <input type="text" class="form-control" name="academic_title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">DOB</label>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <input class="form-control datetime-picker2" type="text" value="" name="dob">
                                                    <span class="input-group-addon"><i class="fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">Connect Info</label>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control" placeholder="Personal Email" name="personalEmail">
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control" placeholder="Phone" name="phone">
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control" placeholder="Work Email" name="workEmail">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">Term of office </label>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <input class="form-control datetime-picker2" type="text" value="" name="inauguration_date">
                                                    <span class="input-group-addon"><i class="fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">Retirement date</label>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <input class="form-control datetime-picker2" type="text" value="" name="leave_date">
                                                    <span class="input-group-addon"><i class="fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">Campus</label>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <select class="form-control select2" name="academy">
                                                    <option></option>
                                                    <?php
                                                    while($row=mysqli_fetch_array($result3)){
                                                        echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
                                                    }
                                                    mysqli_free_result($result3);
                                                    ?>
                                                </select>
                                                <span class="help-block">Chose one campus</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">Management level</label>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <select class="form-control" name="role">
                                                    <option></option>
                                                    <option value="1">General Teachers</option>
                                                    <option value="2">Administrator Teachers</option>
                                                </select>
                                                <span class="help-block">The teacher's management level</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label"></label>
                                    <div class="col-lg-10 col-md-10">
                                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                    </div>
                                </div><br><br>
                            </form>
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
        <script src="../assets/plugins/tables/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/plugins/tables/datatables/jquery.dataTablesBS3.js"></script>
        <script src="../assets/plugins/tables/datatables/tabletools/ZeroClipboard.js"></script>
        <script src="../assets/plugins/tables/datatables/tabletools/TableTools.js"></script>
        <script src="../assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js"></script>
        <script src="../assets/plugins/forms/password/jquery-passy.js"></script>
        <script src="../assets/plugins/forms/checkall/jquery.checkAll.js"></script>
        <script src="../assets/plugins/misc/highlight/highlight.pack.js"></script>
        <script src="../assets/plugins/misc/countTo/jquery.countTo.js"></script>
        <script src="../assets/js/jquery.sprFlat.js"></script>
        <script src="../assets/js/app.js"></script>
        <script src="../assets/js/pages/forms.js"></script>
        <script>
            $(document).ready(function() {
                //------------- Extend table tools -------------//
                $.extend( true, $.fn.DataTable.TableTools.classes, {
                    "container": "DTTT btn-group",
                    "buttons": {
                        "normal": "btn btn-default",
                        "disabled": "disabled"
                    },
                    "collection": {
                        "container": "DTTT_dropdown dropdown-menu",
                        "buttons": {
                            "normal": "",
                            "disabled": "disabled"
                        }
                    },
                    "print": {
                        "info": "DTTT_print_info modal"
                    }
                } );

                // Have the collection use a bootstrap compatible dropdown
                $.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
                    "collection": {
                        "container": "ul",
                        "button": "li",
                        "liner": "a"
                    }
                });

                //------------- Datatables -------------//
                $('#datatable').dataTable({
                    "sPaginationType": "bs_full", //"bs_normal", "bs_two_button", "bs_four_button", "bs_full"
                    "fnPreDrawCallback": function( oSettings ) {
                        $('.dataTables_filter input').addClass('form-control input-large').attr('placeholder', 'search..');
                        $('.dataTables_length select').addClass('form-control input-small');
                    },
                    "oLanguage": {
                        "sSearch": "",
                        "sLengthMenu": "<span>Show _MENU_ Results</span>"
                    },
                    "bJQueryUI": false,
                    "bAutoWidth": false,
                    "sDom": "<'row'<'col-lg-6 col-md-6 col-sm-12 text-center'l><'col-lg-6 col-md-6 col-sm-12 text-center'f>r>t<'row-'<'col-lg-6 col-md-6 col-sm-12'i><'col-lg-6 col-md-6 col-sm-12'p>>",
                });
            });
        </script>
    </body>
</html>