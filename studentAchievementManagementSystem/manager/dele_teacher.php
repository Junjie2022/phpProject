<?php
//connect db
require('../db.php');
// check login
require('../login_check.php');
// delete by id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    //
    $query  = "DELETE FROM teacher WHERE id = $id";
    // check result
    $result = mysqli_query($connection, $query);
    if (!$result) {
        header('Location: teacher.php?success=2');
    }else{
        header('Location: teacher.php?success=del');
    }
} else {
    echo "Can't find the id";
}
mysqli_free_result($result);
// close connection
mysqli_close($connection);
?>