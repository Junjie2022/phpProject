<?php
error_reporting(0);
// connect to db
$dbhost = "localhost:3306";
$dbuser = "root";
$dbpass = "";
$dbname = "student_manage";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// check db
if (mysqli_connect_errno()) {
    die("Database connection failed: " .
        mysqli_connect_error() .
        " (" . mysqli_connect_errno() . ")" 
    );
}

?>
<script>
    function test(){
        var result = confirm("success!");
        if(result){
            window,open('home.php');
        }
    }
</script>
