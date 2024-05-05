<?php
//Connect to db
require('../db.php');
// check login
require('../login_check.php');
// // get id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // delete by id
    $query  = "DELETE FROM course WHERE id = $id";
    // check db
    $result = mysqli_query($connection, $query);
    if (!$result) {
        header('Location: course.php?success=2');
    }else{
        header('Location: course.php?success=del');
    }
} else {
    echo "Can't find the id. ";
}
mysqli_free_result($result);
//  close db
mysqli_close($connection);
?>