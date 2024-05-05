<?php
//connect database
require('../db.php');
// check login
require('../login_check.php');
// // delete by ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // 2. search by ID
    $query  = "DELETE FROM bulletin WHERE id = $id";
    // search database
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query is wrong");
    }
    // return
    header('Location: bulletin.php?success=del');
} else {
    echo "no url link ID";
}
mysqli_free_result($result);
// 5. close the connection
mysqli_close($connection);
?>