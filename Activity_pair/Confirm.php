<?php
    // require("password.php");
    include("../major_trans.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $token = $_POST["token"];
    $userID = 2;
    $token = "4048607";

    function updatePairStatus() {
        global $con, $userID, $token; //設定全域變數
        $statement = mysqli_prepare($con, "UPDATE user SET pair_status = 1 WHERE userid = ? AND token = ?"); //設定要執行的SQL指令，以?代表參數
        mysqli_stmt_bind_param($statement, "is", $userID, $token); //stmt與變數做連結
        mysqli_stmt_execute($statement); //執行stmt
        mysqli_stmt_close($statement);
    }

    function confirmPair() {
        global $con, $userID, $token;
        $statement = mysqli_prepare($con, "SELECT pair_status FROM user WHERE userid = (SELECT pair FROM pair WHERE userid = ? LIMIT 1)");
        mysqli_stmt_bind_param($statement, "i", $userID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colPairStatus);
        while (mysqli_stmt_fetch($statement)) {
            if ($colPairStatus == 1) {
                return true;
            }
        }
        return false;
    }

    $response = array();
    $response["success"] = false;
    $response["confirm"] = false;

    updatePairStatus();
    $response["success"] = true;
    if (confirmPair()) {
        $response["confirm"] = true;
    } else {
        // echo "Not paired!";
        $response["error"] = "notPaired";
    }

    echo urldecode(json_encode($response));
?>
