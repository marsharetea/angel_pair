<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $token = $_POST["token"];
    // $mode = $_POST["mode"];
    $userID = 3;
    $token = "1279314";
    $mode = 1;

    function updatePairStatus() {
        global $con, $mode, $userID, $token, $response; //設定全域變數
        if ($mode == 1) {
            $response["pair_lord_status"] = 1;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 1 WHERE userid = ? AND token = ?");
        } else {
            $response["pair_angel_status"] = 1;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_angel_status = 1 WHERE userid = ? AND token = ?");
        }
        mysqli_stmt_bind_param($statement, "is", $userID, $token); //stmt與變數做連結
        mysqli_stmt_execute($statement); //執行stmt
        mysqli_stmt_close($statement);
    }

    function confirmPair() {
        global $con, $mode, $userID, $token, $response;
        if ($mode == 1) {
            $statement = mysqli_prepare($con, "SELECT pair_angel_status FROM user WHERE userid = (SELECT angel FROM pair WHERE lord = ? AND status = 0 LIMIT 1)");
        } else {
            $statement = mysqli_prepare($con, "SELECT pair_lord_status FROM user WHERE userid = (SELECT lord FROM pair WHERE angel = ? AND status = 0 LIMIT 1)");
        }
        mysqli_stmt_bind_param($statement, "i", $userID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colPairStatus);
        while (mysqli_stmt_fetch($statement)) {
            if ($colPairStatus > 0) {
                if ($mode == 1) {
                    $response["pair_lord_status"] = 2;
                    $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 2 WHERE userid = ? AND token = ?");
                    mysqli_stmt_bind_param($statement, "is", $userID, $token);
                    mysqli_stmt_execute($statement);
                    $statement = mysqli_prepare($con, "UPDATE user SET pair_angel_status = 2 WHERE userid = (SELECT angel FROM pair WHERE lord = ? AND status = 0 LIMIT 1)");
                    mysqli_stmt_bind_param($statement, "i", $userID);
                    mysqli_stmt_execute($statement);
                } else {
                    $response["pair_angel_status"] = 2;
                    $statement = mysqli_prepare($con, "UPDATE user SET pair_angel_status = 2 WHERE userid = ? AND token = ?");
                    mysqli_stmt_bind_param($statement, "is", $userID, $token);
                    mysqli_stmt_execute($statement);
                    $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 2 WHERE userid = (SELECT lord FROM pair WHERE angel = ? AND status = 0 LIMIT 1)");
                    mysqli_stmt_bind_param($statement, "i", $userID);
                    mysqli_stmt_execute($statement);
                }
            }
        }
    }

    $response = array();
    $response["success"] = false;

    updatePairStatus();
    confirmPair();
    $response["success"] = true;

    echo json_encode($response);
?>
