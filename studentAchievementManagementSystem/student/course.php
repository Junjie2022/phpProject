<?php
// coonect database
require('../db.php');
// check login
require('../login_check.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT id, name, avatar FROM student WHERE username = '$username'";
$sname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

//optional course
$query = "SELECT course.id, course_no, course.name, period, t.name AS tname, credit FROM course INNER JOIN teacher t ON t.id = course.teacher_id WHERE if_optional = 1 ORDER BY course.id";
$result1 = mysqli_query($connection,$query);

//Selected course
$query = "SELECT sc.id, course_no, c.name, period, t.name AS tname, credit FROM course c INNER JOIN teacher t ON t.id = c.teacher_id INNER JOIN student_course sc ON sc.course_id = c.id INNER JOIN student s ON s.id = sc.student_id WHERE if_optional = 1 AND s.username = '$username'";
$result2 = mysqli_query($connection,$query);

//select course
if (isset($_POST['submit'])){
    $sid = $sname['id'];
    $cid = $_POST['submit'];
    
    $query = "INSERT INTO student_course (student_id, course_id) VALUES ('$sid','$cid')";
    $result = mysqli_query($connection,$query);
    mysqli_free_result($result);
    header('Location: course.php?success=1');
}

//delect course
if (isset($_POST['submit1'])){
    $id = $_POST['submit1'];
    $query  = "DELETE FROM student_course WHERE id = $id";
    $result = mysqli_query($connection, $query);
    mysqli_free_result($result);
    header('Location: course.php?success=2');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Course Selection-Student Score Management System</title>
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
<!--                            <i class="im-windows8 text-logo-element animated bounceIn"></i><span class="text-logo">student</span><span class="text-slogan">Management</span>-->
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
                            <input type="text" name="search" placeholder="refresh...">
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
                        <h1 class="page-header"><i class="en-login"></i>Select Course</h1>
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
                    </div>
                    <!-- End .page-header -->
                </div>
                <!-- End .row -->
                <div class="outlet">
                    <!-- Start .outlet -->
                    <!-- Page start here ( usual with .row ) -->
                    <div class="row">
                        <!-- Start .row -->
                        <div class="col-lg-6">
                            <div class="panel panel-default plain toggle panelClose">
                                <!-- Start .panel -->
                                <div class="panel-heading white-bg">
                                    <h4 class="panel-title">Available Course</h4>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    if(isset($_GET['success'])) {
                                        if($_GET['success']=="1"){
                                            echo "<div class=\"alert alert-success fade in\">
                                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                                <i class=\"fa-ok alert-icon s24\"></i>
                                                <strong>success!</strong> choose the course successfully!
                                            </div>";
                                        }
                                    }
                                    ?>
                                    <form method="post" action="course.php">
                                        <table class="table display" id="datatable1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Course ID</th>
                                                    <th>Course Name</th>
                                                    <th>Credit Hours</th>
                                                    <th>Teacher</th>
                                                    <th>Credit</th>
                                                    <th>Selected Course</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                                while($row=mysqli_fetch_array($result1)){
                                                    echo "<tr>";
                                                    echo "<td class='center'>".$i."</td>";
                                                    echo "<td>".$row['course_no']."</td>";
                                                    echo "<td>".$row['name']."</td>";
                                                    echo "<td>".$row['period']."</td>";
                                                    echo "<td>".$row['tname']."</td>";
                                                    echo "<td>".$row['credit']."</td>";
                                                    $query = "SELECT COUNT(id) AS nums FROM student_course WHERE grade is null AND student_id = ".$sname['id']." AND course_id = ".$row['id'];
                                                    $nums = mysqli_fetch_array(mysqli_query($connection, $query));
                                                    mysqli_free_result(mysqli_query($connection, $query));
                                                    if($nums['nums']==0){
                                                        echo "<td><button onclick='test()' class='btn btn-xs btn-primary' type='submit' name='submit' value='".$row['id']."'>Choose</button></td>";
                                                        }else{
                                                        echo "<td><button onclick='test()' class='btn btn-xs btn-dark' disabled=\"disabled\">Selected</button></td>";
                                                    }
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                                mysqli_free_result($result1);
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <!-- End .panel -->
                        </div>
                        <div class="col-lg-6">
                            <div class="panel panel-default plain toggle panelClose">
                                <!-- Start .panel -->
                                <div class="panel-heading white-bg">
                                    <h4 class="panel-title">Selected Course</h4>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    if(isset($_GET['success'])) {
                                        if($_GET['success']=="2"){
                                            echo "<div class=\"alert alert-success fade in\">
                                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                                <i class=\"fa-ok alert-icon s24\"></i>
                                                <strong>success!</strong> Cancel the course successfully!
                                            </div>";
                                        }
                                    }
                                    ?>
                                    <form method="post" action="course.php">
                                        <table class="table display" id="datatable2">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Cours ID</th>
                                                    <th>Cours Name</th>
                                                    <th>Credit Hours</th>
                                                    <th>Teacher</th>
                                                    <th>credit</th>
                                                    <th>Cancel</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                                while($row=mysqli_fetch_array($result2)){
                                                    echo "<tr>";
                                                    echo "<td class='center'>".$i."</td>";
                                                    echo "<td>".$row['course_no']."</td>";
                                                    echo "<td>".$row['name']."</td>";
                                                    echo "<td>".$row['period']."</td>";
                                                    echo "<td>".$row['tname']."</td>";
                                                    echo "<td>".$row['credit']."</td>";
                                                    echo "<td><button class='btn btn-xs btn-danger' type='submit' name='submit1' value='".$row['id']."'>Cancel</button></td>";
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                                mysqli_free_result($result2);
                                                mysqli_close($connection);
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <!-- End .panel -->
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
        <script src="../assets/plugins/tables/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/plugins/tables/datatables/jquery.dataTablesBS3.js"></script>
        <script src="../assets/plugins/tables/datatables/tabletools/ZeroClipboard.js"></script>
        <script src="../assets/plugins/tables/datatables/tabletools/TableTools.js"></script>
        <script src="../assets/plugins/misc/highlight/highlight.pack.js"></script>
        <script src="../assets/plugins/misc/countTo/jquery.countTo.js"></script>
        <script src="../assets/js/jquery.sprFlat.js"></script>
        <script src="../assets/js/app.js"></script>
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

                //------------- Datatables2 -------------//
                $('#datatable1').dataTable({
                    "sPaginationType": "bs_full", //"bs_normal", "bs_two_button", "bs_four_button", "bs_full"
                    "fnPreDrawCallback": function( oSettings ) {
                        $('.dataTables_filter input').addClass('form-control input-large').attr('placeholder', 'Search..');
                        $('.dataTables_length select').addClass('form-control input-small');
                    },
                    "oLanguage": {
                        "sSearch": "",
                        "sLengthMenu": "<span>Show _MENU_ results</span>"
                    },
                    "bJQueryUI": false,
                    "bAutoWidth": false,
                    "sDom": "<'row'<'col-lg-6 col-md-6 col-sm-12 text-center'l><'col-lg-6 col-md-6 col-sm-12 text-center'f>r>t<'row-'<'col-lg-6 col-md-6 col-sm-12'i><'col-lg-6 col-md-6 col-sm-12'p>>",
                });
                $('#datatable2').dataTable({
                    "sPaginationType": "bs_full", //"bs_normal", "bs_two_button", "bs_four_button", "bs_full"
                    "fnPreDrawCallback": function( oSettings ) {
                        $('.dataTables_filter input').addClass('form-control input-large').attr('placeholder', 'Search..');
                        $('.dataTables_length select').addClass('form-control input-small');
                    },
                    "oLanguage": {
                        "sSearch": "",
                        "sLengthMenu": "<span>Show _MENU_ results</span>"
                    },
                    "bJQueryUI": false,
                    "bAutoWidth": false,
                    "sDom": "<'row'<'col-lg-6 col-md-6 col-sm-12 text-center'l><'col-lg-6 col-md-6 col-sm-12 text-center'f>r>t<'row-'<'col-lg-6 col-md-6 col-sm-12'i><'col-lg-6 col-md-6 col-sm-12'p>>",
                });
            });
        </script>
    </body>
</html>