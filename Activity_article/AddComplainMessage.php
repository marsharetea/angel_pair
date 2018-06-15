<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $articleID = $_POST["articleid"];
    // $userID = $_POST["userid"];
    // $message = $_POST["message"];
    $articleID = 8;
    $userID = 2;
    $message = "幹哩北七喔";

    date_default_timezone_set("Asia/Shanghai");
    $date = date("Y/m/d");
    $time = date("H:i:s");

    function AddMessage() {
        global $con, $articleID, $userID, $date, $time, $message;
        $statement = mysqli_prepare($con, "INSERT INTO message_complain (articleid, userid, date, time, message) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement, "iisss", $articleID, $userID, $date, $time, $message);
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

    if (AddMessage()) {
        $response["success"] = true;
    } else {
        // echo "Add complain message failed!";
        $response["error"] = "addMessageFailed";
    }

    echo json_encode($response);
?>
