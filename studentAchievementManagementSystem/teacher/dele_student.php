<?php
//connect database
require('../db.php');
// check login
require('../login_check.php');
// // deletd by ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // 2. search
    $query  = "DELETE FROM student WHERE id = $id";
    // search database
    $result = mysqli_query($connection, $query);
    if (!$result) {
        header('Location: student.php?success=2');
    }else{
        header('Location: student.php?success=del');
    }
} else {
    echo "no url link with id";
}
mysqli_free_result($result);
// 5. close database
mysqli_close($connection);
?>