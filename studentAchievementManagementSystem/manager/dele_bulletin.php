<?php
//Connect to database
require('../db.php');
// check login
require('../login_check.php');
// // delete by id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // 2. check
    $query  = "DELETE FROM bulletin WHERE id = $id";
    // check data
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query is wrong");
    }
    // go back
    header('Location: bulletin.php?success=del');
} else {
    echo "Can't find the id. ";
}
mysqli_free_result($result);
// 5 close connection
mysqli_close($connection);
?>