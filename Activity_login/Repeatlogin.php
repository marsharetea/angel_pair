<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $token = $_POST["token"];
    $userID = 9;
    $token = "du78125";

    function repeatLogin() {
        global $con, $userID, $token; //設定全域變數
        $statement = mysqli_prepare($con, "SELECT * FROM user WHERE userid = ? AND token = ?"); //設定要執行的SQL指令，以?代表參數
        mysqli_stmt_bind_param($statement, "is", $userID, $token); //stmt與變數做連結
        mysqli_stmt_execute($statement); //執行stmt
        mysqli_stmt_store_result($statement); //將結果回傳並儲存
        $count = mysqli_stmt_num_rows($statement); //回傳列數
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    $response = array();
    $response["success"] = false;

    if (!repeatLogin()) {
        $response["success"] = true;
        $response["error"] = "repeatLogin";
        // echo "Repeat Login!";
    }

    echo json_encode($response);
?>
