<?php
//check db
require('../db.php');
// check login
require('../login_check.php');
// // get id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // delete query
    $query  = "DELETE FROM student WHERE id = $id";
    // check db result
    $result = mysqli_query($connection, $query);
    if (!$result) {
        header('Location: student.php?success=2');
    }else{
        header('Location: student.php?success=del');
    }
} else {
    echo "Can't find the id. ";
}
mysqli_free_result($result);
// close db
mysqli_close($connection);
?>