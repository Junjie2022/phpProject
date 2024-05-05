<?php

// connect database
require('../db.php');
// check login
require('../login_check.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT name, avatar FROM student WHERE username = '$username'";
$sname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

$option="";
if(isset($_POST['submit'])){
    $content = $_POST['content'];
    $option = $_POST['options'];
    
    if($option=='course'){
        $query = "SELECT course_no, c.name, semester, period, credit, if_optional, t.name AS tname FROM course c INNER JOIN teacher t ON t.id = c.teacher_id WHERE c.name LIKE '%$content%' OR t.name LIKE '%$content%'";
    }else{
        $query = "SELECT t.name, avatar, academic_title, dob, gender, personalEmail, phone, workEmail, inauguration_date, leave_date, a.name AS aname FROM teacher t INNER JOIN academy a ON a.id = t.academy_id WHERE t.name LIKE '%$content%' OR academic_title LIKE '%$content%' GROUP BY t.name";
    }
    $result = mysqli_query($connection,$query);
}

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Search - student Score Management System</title>
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
<!--                            <i class="im-windows8 text-logo-element animated bounceIn"></i><span class="text-logo">Student</span><span class="text-slogan">Management</span>-->
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
                        <h1 class="page-header"><i class="st-search"></i>Search</h1>
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
                        <div class="search-page">
                            <form class="form-inline search-page-form" action="search.php" method="post">
                                <div class="col-lg-4">
                                    <div class="well bn">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="content" value="<?php if(isset($content)){echo $content;} ?>" placeholder="Search..">
                                            <span class="input-group-btn">
                                                <button type="submit" name="submit" class="btn btn-primary"><i class="ec-search s16"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="search-page-toolbar btn-toolbar" role="toolbar">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-default btn-lg">
                                                <input type="radio" name="options" id="option1" value="course" <?php if($option==""||$option=="course"){echo "checked";}?>>Course
                                            </label>
                                            <label class="btn btn-default btn-lg">
                                                <input type="radio" name="options" id="option2" value="teacher" <?php if($option=="teacher"){echo "checked";}?>>Teacher
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default plain toggle panelClose">
                                    <!-- Start .panel -->
                                    <div class="panel-heading white-bg">
                                        <h4 class="panel-title">Search Result</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table display" id="datatable">
                                            <?php
                                            if($option=="course"){
                                                echo "<p class='text-primary'>About<b>course</b>results</p>";
                                                echo "<thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>course ID</th>
                                                        <th>course name</th>
                                                        <th>semester</th>
                                                        <th>credit hours</th>
                                                        <th>credit</th>
                                                        <th>teacher</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";
                                                $i=1;
                                                while($row=mysqli_fetch_array($result)){
                                                    echo "<tr>";
                                                    echo "<td>".$i."</td>";
                                                    echo "<td>".$row['course_no']."</td>";
                                                    echo "<td>".$row['name']."</td>";
                                                    echo "<td>".$row['semester']."</td>";
                                                    echo "<td>".$row['period']."</td>";
                                                    echo "<td>".$row['credit']."</td>";
                                                    echo "<td>".$row['tname']."</td>";
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                                mysqli_free_result($result);
                                            } elseif($option=="teacher") {
                                                echo "<p class='text-primary'>about<b>teacher</b>search result.</p>";
                                                echo "<thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Avatar</th>
                                                        <th>Name</th>
                                                        <th>Title</th>
                                                        <th>Date of birth</th>
                                                        <th>Gender</th>
                                                        <th>Personal Email</th>
                                                        <th>Phone</th>
                                                        <th>Work Email</th>
                                                        <th>Assumption date</th>
                                                        <th>Retired date</th>
                                                        <th>Campus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";
                                                $i=1;
                                                while($row=mysqli_fetch_array($result)){
                                                    echo "<tr>";
                                                    echo "<td>".$i."</td>";
                                                    echo "<td><img height=\"40px\" class=\"user-avatar\" src=\"../assets/img/avatars/".$row['avatar']."\"></td>";
                                                    echo "<td>".$row['name']."</td>";
                                                    echo "<td>".$row['academic_title']."</td>";
                                                    echo "<td>".$row['dob']."</td>";
                                                    echo "<td>".$row['gender']."</td>";
                                                    if($row['personalEmail']==""||$row['personalEmail']==null){$row['personalEmail']="none";}
                                                    echo "<td>".$row['personalEmail']."</td>";
                                                    if($row['phone']==""||$row['phone']==null){$row['phone']="none";}
                                                    echo "<td>".$row['phone']."</td>";
                                                    if($row['workEmail']==""||$row['workEmail']==null){$row['workEmail']="none";}
                                                    echo "<td>".$row['workEmail']."</td>";
                                                    echo "<td>".$row['inauguration_date']."</td>";
                                                    if($row['leave_date']=="0000-00-00"||$row['leave_date']==null){$row['leave_date']="don't retired";}
                                                    echo "<td>".$row['leave_date']."</td>";
                                                    echo "<td>".$row['aname']."</td>";
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                                mysqli_free_result($result);
                                            } else {
                                                echo "<p class='text-primary'>Search results: </p>";
                                            }
                                            echo "</tbody>";
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End .row -->
                        <!-- Page End here -->
                    </div>
                    <!-- End .outlet -->
                </div>
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
        <script src="../assets/js/pages/data-tables.js"></script>
    </body>
</html>