<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $relationID = $_POST["relationid"];
    // $context = $_POST["context"];
    // $userID = $_POST["userid"];

    $relationID = 38;
    $context = "fuck me plz!";
    $userID = 10;

    date_default_timezone_set("Asia/Shanghai");
    $date = date("Y/m/d");
    $time = date("H:i:s");

    function AddContext() {
        global $con, $relationID, $context, $userID, $date, $time;
        $statement = mysqli_prepare($con, "INSERT INTO chat (relationid, date, time, context, userid) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement, "isssi", $relationID, $date, $time, $context, $userID);
        mysqli_stmt_execute($statement);

        $count = mysqli_affected_rows($con);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    $response = array();
    $response["success"] = false;

    if (AddContext()) {
        $response["success"] = true;
    } else {
        // echo "Add context failed!";
        $response["error"] = "addContextFailed";
    }

    echo json_encode($response);
?>
