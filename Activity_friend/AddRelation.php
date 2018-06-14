<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    // $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    // mysqli_set_charset($con, "utf8"); //中文亂碼

    // function tempRelation($con, $userID, $yoursID, $mode, $context) {
    //     if ($mode == 1) {
    //         $statement = mysqli_prepare($con, "SELECT relationid FROM friend WHERE lord = ? AND angel = ?");
    //     } else {
    //         $statement = mysqli_prepare($con, "SELECT relationid FROM friend WHERE angel = ? AND lord = ?");
    //     }
    //     mysqli_stmt_bind_param($statement, "ii", $userID, $yoursID);
    //     mysqli_stmt_execute($statement);
    //     mysqli_stmt_store_result($statement);
    //     mysqli_stmt_bind_result($statement, $colRelationID);
    //     while (mysqli_stmt_fetch($statement)) {
    //         $relationid = $colRelationID;
    //     }
    //     $count = mysqli_stmt_num_rows($statement);
    //     if ($count > 0) {
    //         $statement = mysqli_prepare($con, "UPDATE friend SET status = 1 WHERE relationid = ?");
    //         mysqli_stmt_bind_param($statement, "i", $relationid);
    //         mysqli_stmt_execute($statement);
    //     } else {
    //         $statement = mysqli_prepare($con, "INSERT INTO friend (lord, angel, status) VALUES (?, ?, -1)");
    //         if ($mode == 1) {
    //             mysqli_stmt_bind_param($statement, "ii", $userID, $yoursID);
    //         } else {
    //             mysqli_stmt_bind_param($statement, "ii", $yoursID, $userID);
    //         }
    //         mysqli_stmt_execute($statement);
    //     }
    // }

    function tempRelation($con, $userID, $yoursID, $mode) {
        $statement = mysqli_prepare($con, "SELECT * FROM friend WHERE lord = ? AND angel = ?");
        if ($mode == 1) {
            mysqli_stmt_bind_param($statement, "ii", $yoursID, $userID);
        } else {
            mysqli_stmt_bind_param($statement, "ii", $userID, $yoursID);
        }
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);

        if ($count == 0) {
            $statement = mysqli_prepare($con, "INSERT INTO friend (lord, angel, status) VALUES (?, ?, -1)");
            if ($mode == 1) {
                mysqli_stmt_bind_param($statement, "ii", $yoursID, $userID);
            } else {
                mysqli_stmt_bind_param($statement, "ii", $userID, $yoursID);
            }
            mysqli_stmt_execute($statement);
        }
    }

    function addRelation($con, $userID, $yoursID, $mode) {
        $statement = mysqli_prepare($con, "UPDATE friend SET status = 1 WHERE lord = ? AND angel = ?");
        if ($mode == 1) {
            mysqli_stmt_bind_param($statement, "ii", $yoursID, $userID);
        } else {
            mysqli_stmt_bind_param($statement, "ii", $userID, $yoursID);
        }
        mysqli_stmt_execute($statement);
    }

?>
